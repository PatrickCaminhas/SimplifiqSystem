<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF; ;
class CotacoesController extends Controller
{
    //
    public function create()
    {
        return view('cotacao\cotacaoDeProdutos', ['page' => 'cotacao']);
    }

    public function createRevisao()
    {
        return view('cotacao\cotacaoDeProdutosRevisao', ['page' => 'cotacao']);
    }

    public function createFinal(){
        return view('cotacao\cotacaoDeProdutosFinal', ['page' => 'cotacao']);
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
