<?php

namespace App\Http\Controllers;

use App\Models\Itens_cotacoes;
use App\Models\Itens_venda;
use App\Models\Produtos;
use App\Models\Produtos_categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


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
            'nome',
            'marca',
            'modelo',
            'categoria',
            'unidade_medida',
            'medida',
            'preco_compra',
            'descricao'
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

        $produtos = Produtos::where(function ($query) use ($term) {
            $query->where('nome', 'LIKE', '%' . $term . '%')
                ->orWhere('modelo', 'LIKE', '%' . $term . '%')
                ->orWhere('marca', 'LIKE', '%' . $term . '%');
        })
        ->where('estado', 'Ativo')
        //->where('quantidade', '>', 0)
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

    //------------------
    //FUNÇÃO PARA: DESATIVAR PRODUTO
    //PARÂMETROS: ID DO PRODUTO
    //------------------

    public function alterarEstadoProduto($id)
    {
        $produto = Produtos::find($id);

        if (!$produto) {
            return response()->json(['error' => true, 'message' => 'Produto não encontrado'], 404);
        }

        $produto->estado = "Inativo";
        $produto->save();

        return redirect()->route('produto.listar')->with('success', 'Produto desativado com sucesso!');
    }

    //------------------
    //FUNÇÃO PARA: BUSCAR OS 10 MAIORES COMPRADORES DESSE PRODUTO
    //PARÂMETROS: ID DO PRODUTO
    //RETORNO: CLIENTES
    //------------------

    public function buscarMaioresCompradores($id)
    {
        $umAnoAtras = now()->subYear();

        $clientes = Itens_venda::where('produto_id', $id)
            ->join('vendas', 'itens_vendas.venda_id', '=', 'vendas.id') // Relacionando com vendas
            ->join('clientes', 'vendas.cliente_id', '=', 'clientes.id') // Pegando cliente correto
            ->where('vendas.data_venda', '>=', $umAnoAtras)
            ->select('clientes.id', 'clientes.nome', DB::raw('COUNT(*) as total_compras'))
            ->groupBy('clientes.id', 'clientes.nome')
            ->orderByDesc('total_compras')
            ->take(10)
            ->get();

        if ($clientes->isEmpty()) {
            return response()->json(['error' => true, 'message' => 'Nenhuma compra encontrada para esse produto'], 404);
        }

        return response()->json($clientes);
    }



    //------------------
    //FUNÇÃO PARA: BUSCAR OS 10 MAIORES FORNECEDORES DESSE PRODUTO EM COTAÇÕES
    //PARÂMETROS: ID DO PRODUTO
    //RETORNO: FORNECEDORES
    //------------------
    public function buscarMaioresFornecedoresCotacoes($id)
    {
        $produto = Produtos::find($id);

        if (!$produto) {
            return response()->json(['error' => true, 'message' => 'Produto não encontrado'], 404);
        }

        $umAnoAtras = now()->subYear();

        $fornecedores = DB::table('itens_cotacoes')
            ->join('cotacoes', 'itens_cotacoes.id_cotacao', '=', 'cotacoes.id') // Verifique a FK correta
            ->join('fornecedores', 'itens_cotacoes.fornecedor_id', '=', 'fornecedores.id') // Junta com fornecedores
            ->where('itens_cotacoes.produto_id', $id)
            ->where('cotacoes.data_cotacao', '>=', $umAnoAtras)
            ->select('fornecedores.nome as fornecedor_nome', DB::raw('COUNT(*) as total_cotacoes'))
            ->groupBy('fornecedores.nome')
            ->orderByDesc('total_cotacoes')
            ->take(5)
            ->get();

        return response()->json($fornecedores);
    }
    //------------------
    //FUNÇÃO PARA: BUSCAR VARIAÇÃO DE PRECO_UNITARIO DESTE PRODUTO EM 1 ANO
    //PARÂMETROS: ID DO PRODUTO
    //RETORNO: VARIAÇÃO DE PREÇO
    //------------------
    public function buscarVariacaoPrecoProduto($id)
    {
        $produto = Produtos::find($id);

        if (!$produto) {
            return response()->json(['error' => true, 'message' => 'Produto não encontrado'], 404);
        }

        $dataLimite = Carbon::now()->subMonths(13);

        $variacoes = Itens_venda::join('vendas', 'itens_vendas.venda_id', '=', 'vendas.id')
            ->where('itens_vendas.produto_id', $id)
            ->where('vendas.data_venda', '>=', $dataLimite)
            ->select(
                DB::raw("DATE_FORMAT(vendas.data_venda, '%Y/%m') as mes_ano"),
                'itens_vendas.preco_unitario'
            )
            ->groupBy('vendas.created_at', 'data_venda', 'itens_vendas.preco_unitario')
            ->orderBy('vendas.created_at', 'asc')
            ->get();

        return response()->json($variacoes);
    }

    public function atualizarProdutoApi(Request $request, $id)
    {
        // Validação dos dados de entrada
        $validatedData = $request->validate([
            'nome' => 'sometimes|string|max:255',
            'marca' => 'sometimes|string|max:255',
            'modelo' => 'sometimes|string|max:255',
            'categoria_id' => 'sometimes|exists:produtos_categorias,id', // Assumindo que é um relacionamento
            'unidade_medida' => 'sometimes|string|max:50',
            'medida' => 'sometimes|numeric|min:0',
            'preco_compra' => 'sometimes|numeric|min:0',
            'descricao' => 'sometimes|string|max:1000',
        ]);

        // Busca o produto
        $produto = Produtos::find($id);

        if (!$produto) {
            return response()->json([
                'error' => true,
                'message' => 'Produto não encontrado'
            ], 404);
        }

        try {
            // Atualiza o produto com os dados validados
            $produto->update($validatedData);

            // Recarrega o produto com possíveis relacionamentos
            $produto->load('categoria'); // Carrega o relacionamento de categoria, se existir

            return response()->json([
                'success' => true,
                'message' => 'Produto atualizado com sucesso',
                'produto' => $produto // Retorna os dados atualizados do produto
            ], 200);

        } catch (\Exception $e) {
            // Log do erro (opcional)
            Log::error('Erro ao atualizar produto: ' . $e->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Erro ao atualizar produto',
                'details' => $e->getMessage() // Detalhes do erro (apenas em ambiente de desenvolvimento)
            ], 500);
        }
    }

    public function atualizarPrecosAPI(Request $request, $id)
    {
        // Validação dos dados de entrada
        $validatedData = $request->validate([
            'preco_venda' => 'sometimes|numeric|min:0',
            'desconto_maximo' => 'sometimes|numeric|min:0|max:' . $request->preco_venda,
        ]);

        // Busca o produto
        $produto = Produtos::find($id);

        if (!$produto) {
            return response()->json([
                'error' => true,
                'message' => 'Produto não encontrado'
            ], 404);
        }

        try {
            // Atualiza os preços do produto com os dados validados
            $produto->update($validatedData);

            // Recarrega o produto para garantir que os dados estão atualizados
            $produto->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Preços atualizados com sucesso',
                'produto' => $produto // Retorna os dados atualizados do produto
            ], 200);

        } catch (\Exception $e) {
            // Log do erro (opcional)
            Log::error('Erro ao atualizar preços do produto: ' . $e->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Erro ao atualizar preços do produto',
                'details' => $e->getMessage() // Detalhes do erro (apenas em ambiente de desenvolvimento)
            ], 500);
        }
    }

}
