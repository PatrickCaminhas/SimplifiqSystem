<?php

namespace App\Http\Controllers;

use App\Models\Produtos; // Add this line to import the Produto class

use Illuminate\Http\Request;

class InformacaoProdutosController extends Controller
{
    //
    public function create()
    {
        return view('produto\informacaoProdutoRequisicao');
    }
    public function createRead()
    {
        return view('produto\informacaoProduto');
    }

    public function getInformation(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
        ]);
        $produto = Produtos::where('nome', $request->input('nome'))->first();
        if ($produto) {
            return view('produto\informacaoProduto', ['produto' => $produto]);
        } else {
            return redirect('informacaoproduto')->with('error', 'Produto não encontrado.');
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'marca' => 'string',
            'modelo' => 'string',
            'categoria' => 'string',
            'unidade_medida' => 'string',
            'medida' => 'string',
            'descricao' => 'string',
        ]);
        $produto = Produtos::create([
            'nome' => $request->input('nome'),
            'marca' => $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'categoria' => $request->input('categoria'),
            'unidade_medida' => $request->input('unidade_medida'),
            'medida' => $request->input('medida'),
            'descricao' => $request->input('descricao'),
            'ultimo_fornecedor'=> "Nenhum",
            'quantidade'=> 0,
            'preco_compra'=> 0,
            'preco_venda'=> 0,

        ]);
        if ($produto) {
            return redirect('dashboard')->with('success', 'Cadastro realizado com sucesso!');
        } else {
            return redirect('cadastroproduto')->with('error', 'Erro ao cadastrar produto.');
        }
    }
}
