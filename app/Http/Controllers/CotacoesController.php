<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF; ;
use App\Models\Fornecedores;
use App\Models\Produtos;
use App\Models\Cotacoes;


class CotacoesController extends Controller
{
    //
    public function create(Request $request)
    {
        $fornecedores = Fornecedores::all();

        return view('sistema\cotacao\cotacaoDeProdutosInserir', ['page' => 'cotacao', 'fornecedores' => $fornecedores,]);
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
}

    public function createRevisao()
    {
        return view('sistema\cotacao\cotacaoDeProdutosRevisao', ['page' => 'cotacao']);
    }

    public function createFinal(){
        return view('sistema\cotacao\cotacaoDeProdutosFinal', ['page' => 'cotacao']);
    }

    public function createEdicao(){
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

}
