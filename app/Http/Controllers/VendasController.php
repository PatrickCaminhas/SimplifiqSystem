<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendas;
use App\Models\Itens_venda;
use App\Models\Produtos;
use App\Models\Clientes;
use App\Models\Estoque;
use App\Models\Metas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoricoFaturamento;
use App\Services\metaService;

class VendasController extends Controller
{
    //
    protected $metaService;

    public function __construct(MetaService $metaService)
    {
        $this->metaService = $metaService;
    }
    public function create()
    {
        $produtos = Produtos::all();
        $clientes = Clientes::all();
        return view('sistema.venda.cadastrarVenda', ['produtos' => $produtos, 'clientes' => $clientes], ['page' => 'Vendas']);

    }

    public function info()
    {
        $vendas = Vendas::with(['cliente', 'itens.produto'])
            ->orderBy('created_at', 'desc')  // Ordena pela coluna 'created_at' de forma decrescente
            ->get();
        return view('sistema.venda.listaVendas', ['vendas' => $vendas], ['page' => 'Vendas']);
    }

    public function clienteCrediario($clienteId, $valorCrediario)
    {
        Clientes::where('id', $clienteId)->increment('crediario', $valorCrediario);
    }
    public function store(Request $request)
    {
        DB::beginTransaction(); // Inicia a transação

        try {
            // Criar a venda

            $venda = new Vendas();
            $venda->cliente_id = $request->input('cliente_id');
            $venda->data_venda = now();
            $venda->metodo_pagamento = $request->input('metodo_pagamento');
            $venda->valor_total = 0;  // Será atualizado depois
            $venda->save();

            $totalVenda = 0;
            $this->verificarSeExisteMeta();
            // Processar cada produto vendido
            foreach ($request->input('quantidades') as $produtoId => $quantidade) {
                if ($quantidade > 0) {
                    $produto = Produtos::find($produtoId);

                    // Verificar se a quantidade disponível no estoque é suficiente
                    if ($produto->quantidade < $quantidade) {
                        // Se não houver estoque suficiente, lançar uma exceção
                        throw new \Exception('Quantidade insuficiente no estoque para o produto ' . $produto->nome);
                    }

                    $precoUnitario = $produto->preco_venda;

                    // Criar o item da venda
                    $itemVenda = new Itens_venda();
                    $itemVenda->venda_id = $venda->id;
                    $itemVenda->produto_id = $produtoId;
                    $itemVenda->quantidade = $quantidade;
                    $itemVenda->preco_unitario = $precoUnitario;
                    $itemVenda->subtotal = $quantidade * $precoUnitario;
                    $itemVenda->save();
                    $estoque = new Estoque();
                    $estoque->id_produto = $produtoId;
                    $estoque->quantidade = $quantidade;
                    $estoque->acao = "Venda";
                    $estoque->mes = date('m');
                    $estoque->ano = date('Y');
                    $estoque->usuario = Auth::user()->id;
                    $estoque->save();

                    // Atualizar o estoque do produto
                    $produto->quantidade -= $quantidade;
                    $produto->save();

                    // Atualizar o total da venda
                    $totalVenda += $itemVenda->subtotal;
                }
            }

            // Atualizar o total da venda
            if ($request->input('valor_venda') != null) {
                if ($request->input('valor_venda') < $request->input('desconto_maximo')) {
                    $venda->valor_total = $totalVenda;
                }
                $venda->valor_total = $request->input('valor_venda');
            } else {
                $venda->valor_total = $totalVenda;
            }
            if ($venda->metodo_pagamento == 'Crediário') {
                $this->clienteCrediario($venda->cliente_id, $totalVenda);

                $venda->crediario = $totalVenda;
            }
            $this->atualizarFaturamento($totalVenda);
            $this->metaService->cadastrarProgressoEmTodasMetasAbertas($totalVenda);
            $venda->save();

            DB::commit(); // Confirma a transação se tudo der certo
            return redirect()->back()->with('success', 'Venda registrada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback(); // Reverte a transação se houver erro

            // Apagar os itens da venda e a venda em si
            if (isset($venda)) {
                // Apaga os itens associados à venda
                Itens_venda::where('venda_id', $venda->id)->delete();

                // Apaga a venda
                $venda->delete();
            }

            // Redirecionar de volta com a mensagem de erro
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function atualizarFaturamento($valorVenda)
    {
        $faturamento = HistoricoFaturamento::where('ano_mes', date('Y') . "-" . date('m'))->first();
        if ($faturamento) {
            $faturamento->renda_bruta += $valorVenda;
            $faturamento->save();
        } else {
            $faturamento = new HistoricoFaturamento();
            $faturamento->ano_mes = date('Y') . "-" . date('m');
            $faturamento->renda_bruta = $valorVenda;
            $faturamento->save();
        }
    }

    public function verificarSeExisteMeta()
    {
        $ultimoDiaMes = Carbon::now()->endOfMonth()->toDateString();
        $metaExistente = Metas::whereDate('ending_at', $ultimoDiaMes)->exists();
        if (!$metaExistente) {
            $this->criarMeta();
        }
    }
    function criarMeta()
    {
        $meta = new Metas();
        $meta->valor = 4800000;
        $meta->valor_atual = 0;
        $meta->ending_at = Carbon::now()->endOfMonth()->toDateString();
        $meta->estado = 'Pendente';
        $meta->save();

    }


    public function delete(Request $request)
    {
        $venda = Vendas::find($request->id);
        $itensVenda = Itens_venda::where('venda_id', $request->id)->get();
        foreach ($itensVenda as $item) {
            $produto = Produtos::find($item->produto_id);
            $produto->quantidade += $item->quantidade;
            $produto->save();
            $item->delete();
        }
        $venda->delete();
        return redirect()->back()->with('success', 'Venda excluída com sucesso!');
    }

    public function cancelarVenda(Request $request)
    {
        DB::beginTransaction();

        try {
            // Buscar a venda
            $venda = Vendas::findOrFail($request->id);

            if (
                $venda->metodo_pagamento == 'Dinheiro(Cancelado)' ||
                $venda->metodo_pagamento == 'Pix(Cancelado)' ||
                $venda->metodo_pagamento == 'Cartão de credito(Cancelado)' ||
                $venda->metodo_pagamento == 'Cartão de debito(Cancelado)' ||
                $venda->metodo_pagamento == 'Crediario(Cancelado)'
            ) {
                return redirect()->back()->withErrors('Esta venda já foi cancelada.');
            }

            // Reverter o progresso nas metas
            $this->metaService->removerProgressoEmTodasMetasAbertas($venda->valor_total);

            // Reverter o faturamento
            $this->atualizarFaturamento(-$venda->valor_total);

            // Repor o estoque
            $itensVenda = Itens_venda::where('venda_id', $venda->id)->get();
            foreach ($itensVenda as $item) {
                $produto = Produtos::find($item->produto_id);

                if ($produto) {
                    $produto->quantidade += $item->quantidade;
                    $produto->save();

                    // Registrar no histórico de estoque
                    $estoque = new Estoque();
                    $estoque->id_produto = $item->produto_id;
                    $estoque->quantidade = $item->quantidade;
                    $estoque->acao = "Cancelamento";
                    $estoque->mes = date('m');
                    $estoque->ano = date('Y');
                    $estoque->usuario = Auth::user()->nome . ' ' . Auth::user()->sobrenome;
                    $estoque->save();
                }
            }

            // Alterar status da venda para cancelado
            if ($venda->metodo_pagamento == "Dinheiro") {
                $venda->metodo_pagamento = 'Dinheiro(Cancelado)';
            } else if ($venda->metodo_pagamento == 'Pix') {
                $venda->metodo_pagamento = 'Pix(Cancelado)';
            } else if ($venda->metodo_pagamento == 'Cartão de credito') {
                $venda->metodo_pagamento = 'Cartão de credito(Cancelado)';
            } else if ($venda->metodo_pagamento == 'Cartão de debito') {
                $venda->metodo_pagamento = 'Cartão de debito(Cancelado)';
            } else if ($venda->metodo_pagamento == 'Crediario') {
                $venda->metodo_pagamento = 'Crediario(Cancelado)';
            }


            $venda->save();

            DB::commit();
            return redirect()->back()->with('success', 'Venda cancelada com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors('Erro ao cancelar a venda: ' . $e->getMessage());
        }
    }



}
