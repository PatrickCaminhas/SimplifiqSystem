<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendas;
use App\Models\Itens_venda;
use App\Models\Produtos;
use App\Models\Clientes;
use App\Models\Estoque;
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
        return view('sistema.venda.cadastrarVenda', ['produtos' => $produtos, 'clientes' => $clientes], ['page' => 'servicos']);

    }

    public function info()
    {
        $vendas = Vendas::with(['cliente', 'itens.produto'])->get();
        return view('sistema.venda.listaVendas', ['vendas' => $vendas], ['page' => 'servicos']);
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); // Inicia a transação

        try {
            // Criar a venda
            $venda = new Vendas();
            $venda->cliente_id = $request->input('cliente_id');
            $venda->data_venda = now();
            $venda->valor_total = 0;  // Será atualizado depois
            $venda->save();

            $totalVenda = 0;

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
                    $estoque->usuario = Auth::user()->nome . ' ' . Auth::user()->sobrenome;
                    $estoque->save();

                    // Atualizar o estoque do produto
                    $produto->quantidade -= $quantidade;
                    $produto->save();

                    // Atualizar o total da venda
                    $totalVenda += $itemVenda->subtotal;
                }
            }

            // Atualizar o total da venda
            $venda->valor_total = $totalVenda;

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
        $faturamento = HistoricoFaturamento::where('ano_mes', date('Y')."-".date('m'))->first();
        if ($faturamento) {
            $faturamento->renda_bruta += $valorVenda;
            $faturamento->save();
        } else {
            $faturamento = new HistoricoFaturamento();
            $faturamento->ano_mes = date('Y')."-".date('m');
            $faturamento->renda_bruta = $valorVenda;
            $faturamento->save();
        }
    }

}
