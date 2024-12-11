<?php

namespace App\Http\Controllers;

use App\Models\Empresa_information;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Models\Fornecedores;
use App\Models\Produtos;
use App\Models\Cotacoes;


class CotacoesController extends Controller
{
    //
    public function create(Request $request)
    {
        $fornecedores = Fornecedores::all();

        return view('sistema.cotacao.cotacaoDeProdutosInserir', ['page' => 'cotacao', 'fornecedores' => $fornecedores,]);
    }

    public function createLista()
    {
        $produtos = Produtos::all();
        return view('sistema.cotacao.cotacaoDeProdutos', ['page' => 'cotacao', 'produtos' => $produtos]);
    }

    public function processarProdutosSelecionados(Request $request)
    {
        // Receber os IDs dos produtos selecionados
        $produtosSelecionadosIds = $request->input('produtos', []);

        // Buscar os produtos e fornecedores
        $produtosSelecionados = Produtos::whereIn('id', $produtosSelecionadosIds)->get();
        $fornecedores = Fornecedores::all();

        // Passar os produtos e fornecedores para a próxima view
        return view('sistema.cotacao.cotacaoDeProdutosInserir', [
            'page' => 'cotacao',
            'produtos' => $produtosSelecionados,
            'fornecedores' => $fornecedores,
        ]);
    }



    public function inserirCotacao(Request $request)
    {
        DB::beginTransaction();
        try {
            // Inicialmente, busca o maior id_cotacao para começar
            $ultimoIdCotacao = Cotacoes::max('id_cotacao');
            $novoIdCotacao= $ultimoIdCotacao + 1;

            // Verificar se a estrutura de cotacao está sendo passada corretamente
            if (!isset($request->cotacao) || !is_array($request->cotacao)) {
                return back()->withErrors('Nenhum produto foi selecionado para cotação.');
            }

            $produtosCotados = []; // Para armazenar os resultados

            // Percorrer os produtos e seus fornecedores para encontrar o menor preço
            foreach ($request->cotacao as $produtoId => $fornecedores) {
                $menorPreco = null;
                $fornecedorEscolhido = null;

                foreach ($fornecedores as $fornecedorId => $preco) {
                    // Verificar se o preço é válido e menor que o atual menor preço
                    if ($preco !== null && ($menorPreco === null || $preco < $menorPreco)) {
                        $menorPreco = $preco;
                        $fornecedorEscolhido = $fornecedorId;
                    }
                }

                // Se não houver um fornecedor com preço válido, continuar
                if ($menorPreco === null || $fornecedorEscolhido === null) {
                    continue; // Pular para o próximo produto se não encontrar um preço válido
                }

                // Incrementar o id_cotacao para cada novo produto cotado


                // Inserir a cotação no banco de dados com o menor preço encontrado
                Cotacoes::create([
                    'produto_id' => $produtoId,
                    'preco' => $menorPreco,
                    'fornecedor_id' => $fornecedorEscolhido,
                    'id_cotacao' => $novoIdCotacao, // Inserir com o ID incrementado
                ]);

                // Armazenar os dados para exibir na view
                $produtosCotados[] = [
                    'produto' => $produtoId,
                    'fornecedor' => $fornecedorEscolhido,
                    'preco' => $menorPreco,
                ];
            }

            DB::commit();

            // Enviar os resultados para a view de resultados
            return redirect()->route('cotacao.resultados', ['id_cotacao' => $novoIdCotacao]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Erro ao cadastrar a cotação: ' . $e->getMessage());
        }
    }

    public function mostrarResultados($id_cotacao)
    {
        // Busca a cotação pelo id_cotacao com relacionamentos
        $cotacoes = Cotacoes::where('id_cotacao', $id_cotacao)
            ->with('produto', 'fornecedor') // Eager loading dos relacionamentos
            ->get();

        // Pegar nome da empresa (assumindo que tenha uma relação com a cotação)
        $nomeEmpresa = Empresa_information::first()->nome;

        // Data atual
        $dataCotacao = now()->format('d/m/Y H:i:s');

        return view('sistema.cotacao.resultados', compact('cotacoes', 'nomeEmpresa', 'dataCotacao'));
    }







    /*public function inserirCotacao(Request $request)
{
    $produtosSelecionados = $request->input('produtos');

    foreach ($produtosSelecionados as $produto_id => $fornecedores) {
        foreach ($fornecedores as $fornecedor_id => $preco) {
            if ($preco) {
                $fornecedor_id = str_replace('fornecedor', '', $fornecedor_id);

                $cotacao = new Cotacoes;
                $cotacao->produto_id = $produto_id;
                $cotacao->preco = $preco;
                $cotacao->fornecedor_id = $fornecedor_id;
                $cotacao->save();
            }
        }
    }

    return redirect()->back()->with('success', 'Cotações salvas com sucesso!');
}*/

    public function createRevisao()
    {
        return view('sistema\cotacao\cotacaoDeProdutosRevisao', ['page' => 'cotacao']);
    }

    public function createFinal()
    {
        return view('sistema\cotacao\cotacaoDeProdutosFinal', ['page' => 'cotacao']);
    }

    public function createEdicao()
    {
        return view('cotacao\cotacaoDeProdutosEdicao', ['page' => 'cotacao']);
    }
    public function store(Request $request)
    {

    }

    public function gerarPdf()
    {
        $dados = [
            'produtos' => [
                ['nome' => 'Produto 1', 'fornecedor' => 'Fornecedor A', 'preco' => 100],
                ['nome' => 'Produto 2', 'fornecedor' => 'Fornecedor B', 'preco' => 200],
                // Adicione mais produtos aqui
            ]
        ];

        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML('<h1>Teste</h1>');
        // Carregue uma view ou HTML em um PDF
        return $pdf->stream();


        // Faça o download do PDF
//return $pdf->download('invoice.pdf');
    }

    public function delete(Request $request)
    {
        $cotacao = Cotacoes::find($request->input('id'));
        $cotacao->delete();
        return redirect()->route('cotacao.read');
    }

}
