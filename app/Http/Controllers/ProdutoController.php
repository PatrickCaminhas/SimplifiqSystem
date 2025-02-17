<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use App\Models\Produtos_categoria;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    // ------------------
    // FUNÇÕES PARA: RETORNAR VIEWS
    // ------------------

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE CADASTRO DE PRODUTO
    // ------------------
    public function create()
    {
        $categorias = Produtos_categoria::all();
        return view('sistema.produto.cadastroDeProduto', ['page' => 'Produto', 'categorias' => $categorias]);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE ATUALIZAÇÃO DE DADOS DO PRODUTO
    // PARÂMETROS: ID DO PRODUTO
    // ------------------
    public function createAtualizarDadosProduto($id)
    {
        $categorias = Produtos_categoria::all();
        $produto = Produtos::find($id);
        return view('sistema.produto.alterarDadosProduto', ['page' => 'Produto', 'categorias' => $categorias, 'produto' => $produto]);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE ATUALIZAÇÃO DE PREÇO DO PRODUTO
    // PARÂMETROS: ID DO PRODUTO
    // ------------------
    public function createAtualizarPrecoProduto($id)
    {
        $produto = Produtos::find($id);
        return view('sistema.produto.alterarPrecoProduto', ['page' => 'Produto', 'produto' => $produto]);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE CADASTRO DE CATEGORIA
    // ------------------
    public function createCadastroCategoria()
    {
        return view('sistema.produto.cadastroDeCategoria', ['page' => 'Produto']);
    }

    // ------------------
    // FUNÇÕES PARA: CADASTRO E ATUALIZAÇÃO DE DADOS
    // ------------------

    // ------------------
    // FUNÇÃO PARA: CADASTRAR CATEGORIA
    // PARÂMETROS: REQUEST COM NOME DA CATEGORIA
    // ------------------
    public function storeCategoria(Request $request)
    {
        $request->validate(['nome' => 'required|string']);

        if (Produtos_categoria::where('nome', $request->input('nome'))->exists()) {
            return redirect()->back()->with('error', 'Categoria já cadastrada.');
        }

        Produtos_categoria::create(['nome' => $request->input('nome')]);
        return redirect()->back()->with('success', 'Categoria cadastrada com sucesso!');
    }

    // ------------------
    // FUNÇÃO PARA: CADASTRAR PRODUTO
    // PARÂMETROS: REQUEST COM DADOS DO PRODUTO
    // ------------------
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

        Produtos::create([
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

        return redirect()->back()->with('success', 'Produto cadastrado com sucesso!');
    }

    // ------------------
    // FUNÇÃO PARA: ATUALIZAR DADOS DO PRODUTO
    // PARÂMETROS: REQUEST COM DADOS DO PRODUTO
    // ------------------
    public function atualizarDadosProduto(Request $request)
    {
        Produtos::findOrFail($request->id)->update($request->only([
            'nome', 'marca', 'modelo', 'categoria', 'unidade_medida', 'medida', 'preco_compra', 'descricao'
        ]));

        return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
    }

    // ------------------
    // FUNÇÕES PARA: CONSULTAS E PESQUISAS
    // ------------------

    // ------------------
    // FUNÇÃO PARA: BUSCAR PRODUTOS NA VIEW DE VENDAS
    // PARÂMETROS: REQUEST COM TERMO DE PESQUISA
    // ------------------
    public function search(Request $request)
    {
        $term = $request->input('term');

        $produtos = Produtos::where('nome', 'LIKE', '%' . $term . '%')
            ->orWhere('modelo', 'LIKE', '%' . $term . '%')
            ->orWhere('marca', 'LIKE', '%' . $term . '%')
            ->get();

        return response()->json($produtos);
    }

    // ------------------
    // FUNÇÃO PARA: LISTAR TODAS AS CATEGORIAS VIA API
    // ------------------
    public function listarTodasCategoriasAPI()
    {
        return response()->json(Produtos_categoria::all());
    }

    // ------------------
    // FUNÇÃO PARA: BUSCAR CATEGORIA POR ID VIA API
    // PARÂMETROS: ID DA CATEGORIA
    // ------------------
    public function searchCategoria($id)
    {
        $categoria = Produtos_categoria::find($id);

        if (!$categoria) {
            return response()->json(['error' => true, 'message' => 'Categoria não encontrada'], 404);
        }

        return response()->json(['categoria' => $categoria]);
    }
}
