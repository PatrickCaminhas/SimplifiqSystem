<?php

namespace App\Http\Controllers;

use App\Models\Empresa_information;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Models\Fornecedores;
use App\Models\Produtos;
use App\Models\Cotacoes;
use App\Models\Itens_cotacoes;

class CotacoesController extends Controller
{
    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE INSERÇÃO DE COTAÇÃO
    // ------------------
    public function create(Request $request)
    {
        $fornecedores = Fornecedores::all();
        return view('sistema.cotacao.cotacaoDeProdutosInserir', ['page' => 'Cotação', 'fornecedores' => $fornecedores]);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE LISTA DE PRODUTOS PARA COTAÇÃO
    // ------------------
    public function createLista()
    {
        $produtos = Produtos::all();
        $checagem = $this->checarProdutosEFornecedores();
        return view('sistema.cotacao.cotacaoDeProdutos', ['page' => 'Cotação', 'produtos' => $produtos, 'checagem' => $checagem]);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE LISTAGEM DE COTAÇÕES
    // ------------------
    public function info()
    {
        $cotacoes = Cotacoes::with('itens.produto', 'itens.fornecedor')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('sistema.cotacao.cotacaoLista', ['cotacoes' => $cotacoes, 'page' => 'Cotação']);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE REVISÃO DE COTAÇÃO
    // ------------------
    public function createRevisao()
    {
        return view('sistema.cotacao.cotacaoDeProdutosRevisao', ['page' => 'Cotação']);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE FINALIZAÇÃO DE COTAÇÃO
    // ------------------
    public function createFinal()
    {
        return view('sistema.cotacao.cotacaoDeProdutosFinal', ['page' => 'Cotação']);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE EDIÇÃO DE COTAÇÃO
    // ------------------
    public function createEdicao()
    {
        return view('cotacao.cotacaoDeProdutosEdicao', ['page' => 'Cotação']);
    }
     // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE REPOSIÇÃO DE PRODUTOS COTADOS
    // ------------------

    public function createReposicaoGet($id)
    {
        $cotacao = Cotacoes::find($id);
        $itens = Itens_cotacoes::where('id_cotacao', $cotacao->id)
            ->with('produto', 'fornecedor')
            ->get()
            ->sortBy('fornecedor.id');

        return view('sistema.cotacao.cotacaoDeProdutosReposicao', ['page' => 'Cotação', 'cotacao' => $cotacao, 'itens' => $itens]);
    }
    public function createVerificaoCotacaoGet($id)
    {
        $cotacao = Cotacoes::find($id);
        $itens = Itens_cotacoes::where('id_cotacao', $cotacao->id)
            ->with('produto', 'fornecedor')
            ->get()
            ->sortBy('fornecedor.id');
        return view('sistema.cotacao.cotacaoDeProdutosVerificacao', ['page' => 'Cotação', 'cotacao' => $cotacao, 'itens' => $itens]);
    }


    // ------------------
    // FUNÇÃO PARA: CHECAR SE EXISTEM PRODUTOS E FORNECEDORES
    // ------------------
    private function checarProdutosEFornecedores()
    {
        $produtos = Produtos::all();
        $fornecedores = Fornecedores::all();
        if ($produtos->isEmpty() && $fornecedores->isEmpty()) {
            return 'produtos e fornecedores';
        }
        if ($produtos->isEmpty()) {
            return 'produtos';
        }
        if ($fornecedores->isEmpty()) {
            return 'fornecedores';
        }
        return 'true';
    }

    // ------------------
    // FUNÇÃO PARA: PROCESSAR PRODUTOS SELECIONADOS PARA COTAÇÃO
    // ------------------
    public function processarProdutosSelecionados(Request $request)
    {
        $produtosSelecionadosIds = $request->input('produtos', []);
        $produtosSelecionados = Produtos::whereIn('id', $produtosSelecionadosIds)->get();
        $fornecedores = Fornecedores::all();
        return view('sistema.cotacao.cotacaoDeProdutosInserir', [
            'page' => 'Cotação',
            'produtos' => $produtosSelecionados,
            'fornecedores' => $fornecedores,
        ]);
    }

    // ------------------
    // FUNÇÃO PARA: INSERIR COTAÇÃO NO BANCO DE DADOS
    // ------------------
    public function inserirCotacao(Request $request)
    {
        DB::beginTransaction();
        try {
            if (!isset($request->cotacao) || !is_array($request->cotacao)) {
                return back()->withErrors('Nenhum produto foi selecionado para cotação.');
            }
            $cotacaoAtual = Cotacoes::create(['data_cotacao' => now()]);
            foreach ($request->cotacao as $produtoId => $fornecedores) {
                $menorPreco = null;
                $fornecedorEscolhido = null;
                foreach ($fornecedores as $fornecedorId => $preco) {
                    if ($preco !== null && ($menorPreco === null || $preco < $menorPreco)) {
                        $menorPreco = $preco;
                        $fornecedorEscolhido = $fornecedorId;
                    }
                }
                if ($menorPreco === null || $fornecedorEscolhido === null) {
                    continue;
                }
                Itens_cotacoes::create([
                    'id_cotacao' => $cotacaoAtual->id,
                    'produto_id' => $produtoId,
                    'preco' => $menorPreco,
                    'fornecedor_id' => $fornecedorEscolhido,
                ]);
            }
            DB::commit();
            return redirect()->route('cotacao.resultados', ['id_cotacao' => $cotacaoAtual->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Erro ao cadastrar a cotação: ' . $e->getMessage());
        }
    }

    // ------------------
    // FUNÇÃO PARA: MOSTRAR RESULTADOS DA COTAÇÃO
    // ------------------
    public function mostrarResultados($id_cotacao)
    {
        $cotacoes = Itens_cotacoes::where('id_cotacao', $id_cotacao)
            ->with('produto', 'fornecedor')
            ->get();
        $nomeEmpresa = Empresa_information::first()->nome;
        $dataCotacao = now()->format('d/m/Y H:i:s');
        return view('sistema.cotacao.resultados', ['page' => 'Cotação', 'cotacoes' => $cotacoes, 'nomeEmpresa' => $nomeEmpresa, 'dataCotacao' => $dataCotacao]);
    }

    // ------------------
    // FUNÇÃO PARA: DELETAR COTAÇÃO
    // PARAMETROS: REQUEST COM ID DA COTAÇÃO
    // ------------------
    public function delete(Request $request)
    {
        $cotacao = Cotacoes::find($request->input('id'));
        if ($cotacao) {
            $cotacao->delete();
        }
        return redirect()->route('cotacao.read');
    }
}
