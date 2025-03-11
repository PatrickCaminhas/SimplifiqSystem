<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produtos;
use App\Models\Estoque;
use Illuminate\Support\Facades\Auth;

class EstoqueController extends Controller
{
    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE CADASTRO DE ESTOQUE
    // ------------------
    public function create()
    {
        $produtos = Produtos::where('estado', 'Ativo')
            ->orWhere(function ($query) {
                $query->where('estado', 'Inativo')
                    ->where('quantidade', '>', 0);
            })->get();
        return view('sistema.estoque.estoque', ['produtos' => $produtos], ['page' => 'Produto']);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE ALTERAÇÃO DE ESTOQUE
    // PARAMETROS: ID DO PRODUTO
    // ------------------
    public function edit($id)
    {
        $produto = Produtos::find($id);
        $estoqueRecente = Estoque::where('id_produto', $id)->orderBy('created_at', 'desc')->first();

        if ($estoqueRecente) {
            $estoqueRecente->formatted_created_at = $estoqueRecente->created_at->format('d/m/Y H:i:s');
        } else {
            $estoqueRecente = new Estoque();
            $estoqueRecente->acao = null;
        }

        return view('estoque.alterarEstoque', ['produto' => $produto, 'page' => 'Produto', 'estoqueRecente' => $estoqueRecente]);
    }

    // ------------------
    // FUNÇÃO PARA: OBTER ÚLTIMA MOVIMENTAÇÃO DE ESTOQUE
    // PARAMETROS: ID DO PRODUTO
    // RETORNO: JSON COM A ÚLTIMA MOVIMENTAÇÃO
    // ------------------
    public function getEstoqueRecente($id)
    {
        $estoqueRecente = Estoque::where('id_produto', $id)->latest()->first();

        if ($estoqueRecente) {
            $estoqueRecente->formatted_created_at = $estoqueRecente->created_at->format('d/m/Y H:i:s');
            return response()->json([
                'acao' => $estoqueRecente->acao,
                'quantidade' => $estoqueRecente->quantidade,
                'usuario' => $estoqueRecente->funcionario->nome . " " . $estoqueRecente->funcionario->sobrenome ?? 'desconhecido',
                'formatted_created_at' => $estoqueRecente->formatted_created_at
            ]);
        }

        return response()->json(null);
    }

    // ------------------
    // FUNÇÃO PARA: ATUALIZAR ESTOQUE
    // PARAMETROS: REQUEST COM ID DO PRODUTO, QUANTIDADE E AÇÃO
    // ------------------
    public function update(Request $request)
    {
        $produto = Produtos::find($request->input('id_produto'));
        $quantidade = $request->input('quantidade' . $request->input('id_produto'));
        $acao = $request->input('acao');

        if (is_null($acao)) {
            return redirect()->back()->with(['acao' => 'Ação não foi recebida.']);
        }

        if ($acao == 'reposicao') {
            $produto->quantidade += $quantidade;
        } elseif ($acao == 'baixa') {
            if ($produto->quantidade < $quantidade) {
                return redirect()->back()->with(['quantidade' => 'Quantidade em estoque insuficiente!']);
            }
            $produto->quantidade -= $quantidade;
        }

        if ($quantidade == 0) {
            return redirect()->back()->with(['quantidade' => 'Quantidade não pode ser 0.']);
        }

        $produto->save();

        // ------------------
        // REGISTRAR MOVIMENTAÇÃO NO HISTÓRICO DE ESTOQUE
        // ------------------
        $this->store($produto->id, $quantidade, $acao);

        return redirect()->back()->with(['status' => 'Estoque atualizado com sucesso!']);
    }
    public function store($produtoId, $quantidade, $acao){
        $estoque = new Estoque();
        $estoque->id_produto = $produtoId;
        $estoque->quantidade = $quantidade;
        $estoque->acao = $acao;
        $estoque->mes = date('m');
        $estoque->ano = date('Y');
        $estoque->usuario = Auth::user()->id;
        return $estoque->save();
    }

    public function reporEstoque(Request $request)
    {
        // Percorre todas as entradas do request
        foreach ($request->all() as $key => $value) {
            // Verifica se o input é um campo de quantidade (produtoX)
            if (preg_match('/^produto(\d+)$/', $key, $matches)) {
                $produtoId = $matches[1]; // Extrai o ID do produto
                $quantidadeRepor = intval($value); // Converte a quantidade para inteiro

                // Garante que a quantidade seja positiva
                if ($quantidadeRepor > 0) {
                    // Busca o produto no banco de dados
                    $produto = Produtos::find($produtoId);

                    if ($produto) {
                        // Atualiza a quantidade do produto no estoque
                        $produto->quantidade += $quantidadeRepor;
                        $produto->save();
                        $this->store($produto->id, $quantidadeRepor, 'reposicao');
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Estoque reposto com sucesso!');
    }



}
