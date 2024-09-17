<?php

namespace App\Http\Controllers;

use App\Models\Produtos; // Add this line to import the Produto class

use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    //
    public function create()
    {
        return view('sistema.produto.cadastroDeProduto', ['page' => 'cadastroProduto']);
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

}
