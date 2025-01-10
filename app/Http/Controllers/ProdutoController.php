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
        return view('sistema.produto.cadastroDeProduto', ['page' => 'produto', 'categorias' => $categorias]);
    }


    public function createAtualizarDadosProduto($id)
    {
        $categorias = Produtos_categoria::all();
        $produto = Produtos::find($id);
        return view('sistema.produto.alterarDadosProduto', ['page' => 'produto', 'categorias' => $categorias, 'produto' => $produto]);
    }

    public function createAtualizarPrecoProduto($id)
    {
        $produto = Produtos::find($id);
        return view('sistema.produto.alterarPrecoProduto', ['page' => 'produto', 'produto' => $produto]);
    }

    public function createCadastroCategoria()
    {
        return view('sistema.produto.cadastroDeCategoria', ['page' => 'produto']);
    }

    public function storeCategoria(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
        ]);
        $existeCategoria = Produtos_categoria::where('nome', $request->input('nome'))->first();
        if ($existeCategoria) {
            return redirect()->back()->with('error', 'Categoria já cadastrada.');
        }
        $categoria = Produtos_categoria::create([
            'nome' => $request->input('nome'),
        ]);
        if ($categoria) {
            return redirect()->back()->with('success', 'Categoria cadastrada com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao cadastrar categoria.');
        }
    }




    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'marca' => 'string',
            'modelo' => 'string',
            'categoria' => 'integer',
            'unidade_medida' => 'string',
            'medida' => 'string',
            'descricao' => 'string',
        ]);
        $produto = Produtos::create([
            'nome' => $request->input('nome'),
            'marca' => $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'categoria_id' => $request->input('categoria'),
            'unidade_medida' => $request->input('unidade_medida'),
            'medida' => $request->input('medida'),
            'descricao' => $request->input('descricao'),
            'ultimo_fornecedor' => "Nenhum",
            'quantidade' => 0,
            'preco_compra' => 0,
            'preco_venda' => 0,
            'desconto_maximo' => 0,

        ]);
        if ($produto) {
            return redirect()->back()->with('success', 'Produto cadastrado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao cadastrar produto.');
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

    public function atualizarDadosProduto(Request $request)
    {
        try {
            Produtos::find($request->id)->update([
                'nome' => $request->input('nome'),
                'marca' => $request->input('marca'),
                'modelo' => $request->input('modelo'),
                'categoria' => $request->input('categoria'),
                'unidade_medida' => $request->input('unidade_medida'),
                'medida' => $request->input('medida'),
                'preco_compra' => $request->input('preco_compra'),
                'descricao' => $request->input('descricao'),
            ]);
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Erro ao atualizar produto.');
        }
        return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
    }

    public function atualizarPrecoProduto(Request $request)
    {

        try {

            if ($request->input('desconto_maximo') == null) {
                $desconto_maximo = $request->input('preco_venda');
            } else {
                if ($request->input('desconto_maximo') > $request->input('preco_venda')) {
                    return redirect()->back()->with('error', 'O desconto máximo não pode ser maior que o preço de venda.');
                } else {
                    $desconto_maximo = $request->input('desconto_maximo');
                }
            }
            Produtos::find($request->id)->update([
                'preco_venda' => $request->input('preco_venda'),
                'desconto_maximo' => $desconto_maximo,
            ]);
        } catch (\Exception $e) {
           
            return redirect()->back()->with('error', 'Erro ao atualizar preço do produto.');
        }
        return redirect()->back()->with('success', 'Preço do produto atualizado com sucesso!');
    }
}
