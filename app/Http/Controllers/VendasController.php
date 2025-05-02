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
use Illuminate\Auth\AuthenticationException;
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
        DB::beginTransaction();

        try {
            $venda = $this->criarVenda($request);

            $totalVenda = $this->processarItensVenda($request, $venda);
            $this->atualizarTotalVenda($request, $venda, $totalVenda);
            $this->processarPagamento($venda, $totalVenda);
            $this->atualizarMetricas($totalVenda);

            DB::commit();
            return redirect()->back()->with('success', 'Venda registrada com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            $this->reverterTransacao($venda ?? null);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function criarVenda(Request $request): Vendas
    {
        $venda = new Vendas();
        $venda->cliente_id = $request->input('cliente_id');
        $venda->data_venda = now();
        $venda->metodo_pagamento = $request->input('metodo_pagamento');
        $venda->valor_total = 0;
        $venda->save();
        return $venda;
    }
    public function processarItensVenda(Request $request, Vendas $venda): float
    {
        $totalVenda = 0;

        foreach ($request->input('quantidades') as $produtoId => $quantidade) {
            if ($quantidade <= 0)
                continue;

            $produto = $this->validarProduto($produtoId, $quantidade);
            $subtotal = $this->criarItemVenda($venda, $produto, $quantidade);
            $this->atualizarEstoque($produto, $quantidade);

            $totalVenda += $subtotal;
        }

        return $totalVenda;
    }
    public function validarProduto(int $produtoId, int $quantidade): Produtos
    {
        $produto = Produtos::findOrFail($produtoId);

        if ($produto->quantidade < $quantidade) {
            throw new \Exception("Quantidade insuficiente no estoque para o produto {$produto->nome}");
        }

        return $produto;
    }
    public function criarItemVenda(Vendas $venda, Produtos $produto, int $quantidade): float
    {
        $subtotal = $quantidade * $produto->preco_venda;

        Itens_venda::create([
            'venda_id' => $venda->id,
            'produto_id' => $produto->id,
            'quantidade' => $quantidade,
            'preco_unitario' => $produto->preco_venda,
            'subtotal' => $subtotal
        ]);

        return $subtotal;
    }
    public function atualizarEstoque(Produtos $produto, int $quantidade): void
    {
        if (!Auth::check()) {
            throw new AuthenticationException();
        }
        $produto->decrement('quantidade', $quantidade);

        Estoque::create([
            'id_produto' => $produto->id,
            'quantidade' => $quantidade,
            'acao' => "Venda",
            'mes' => date('m'),
            'ano' => date('Y'),
            'usuario' => Auth::id()
        ]);
    }
    public function atualizarTotalVenda(Request $request, Vendas $venda, float $totalVenda): void
    {
        $valorVenda = $request->input('valor_venda');
        $descontoMaximo = $request->input('desconto_maximo');

        $venda->valor_total = match (true) {
            is_numeric($valorVenda) && $valorVenda >= $descontoMaximo && $valorVenda <= $totalVenda => $valorVenda,
            default => $totalVenda
        };

        $venda->save();
    }

    public function processarPagamento(Vendas $venda, float $totalVenda): void
    {
        if ($venda->metodo_pagamento === 'Crediário') {
            $this->clienteCrediario($venda->cliente_id, $totalVenda);
            $venda->update(['crediario' => $totalVenda]);
        }
    }

    public function atualizarMetricas(float $totalVenda): void
    {
        $this->atualizarFaturamento($totalVenda);
        $this->metaService->verificarSeExisteMeta();
        $this->metaService->cadastrarProgressoEmTodasMetasAbertas($totalVenda);
    }

    public function reverterTransacao(?Vendas $venda): void
    {
        if ($venda) {
            Itens_venda::where('venda_id', $venda->id)->delete();
            $venda->delete();
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



/*
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
                return redirect()->back()->with('Esta venda já foi cancelada.');
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
            return redirect()->back()->with('Erro ao cancelar a venda: ' . $e->getMessage());
        }
    }
    */



}
