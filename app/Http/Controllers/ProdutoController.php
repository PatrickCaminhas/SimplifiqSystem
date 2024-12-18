<?php

namespace App\Http\Controllers;

use App\Models\Produtos; // Add this line to import the Produto class
use App\Models\Produtos_categoria; // Add this line to import the Categoria class
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    //
    public function create()
    {
        $categorias = Produtos_categoria::all();
        return view('sistema.produto.cadastroDeProduto', ['page' => 'produto','categorias' => $categorias]);
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
            'ultimo_fornecedor' => "Nenhum",
            'quantidade' => 0,
            'preco_compra' => 0,
            'preco_venda' => 0,

        ]);
        if ($produto) {
            return redirect('dashboard')->with('success', 'Cadastro realizado com sucesso!');
        } else {
            return redirect('cadastroproduto')->with('error', 'Erro ao cadastrar produto.');
        }
    }

    public function search(Request $request)
    {
        $term = $request->input('term');

        // Buscar produtos que correspondem ao termo digitado
        $produtos = Produtos::where('nome', 'LIKE', '%' . $term . '%')
            ->orWhere('modelo', 'LIKE', '%' . $term . '%')
            ->orWhere('marca', 'LIKE', '%' . $term . '%')
            ->get();

        // Retornar como JSON para o autocomplete
        return response()->json($produtos);
    }

    public function atualizarDadosProduto(Request $request, $id){
        Produtos::find( $id )->update([
            'nome' => $request->input('nome'),
            'marca' => $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'categoria' => $request->input('categoria'),
            'unidade_medida' => $request->input('unidade_medida'),
            'medida' => $request->input('medida'),
            'preco_compra' => $request->input('preco_compra'),
            'descricao' => $request->input('descricao'),
            'desconto_maximo' => $request->input('desconto_maximo'),
        ]);

    }

    public function atualizarPrecoProduto(Request $request, $id){
        Produtos::find( $id )->update([
            'preco_venda' => $request->input('preco_venda'),
        ]);
    }

    public function createAtualizarDadosProduto(Request $request, $id){
        $categorias = Produtos_categoria::all();
        $produto = Produtos::find($id);
        return view('sistema.produto.atualizarDadosProduto', ['page' => 'produto','categorias' => $categorias, 'produto' => $produto]);

    }


}
