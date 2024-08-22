<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produtos;
use App\Models\Estoque;
use Illuminate\Support\Facades\Auth;


class EstoqueController extends Controller
{
    //
    public function create()
    {
        $produtos = Produtos::all();
        return view('estoque\estoque', ['produtos' => $produtos], ['page' => 'estoque']);
    }
    public function edit($id)
    {
        $produto = Produtos::find($id);
        $estoqueRecente = Estoque::where('id_produto', $id)->orderBy('created_at', 'desc')->first();
        if ($estoqueRecente) {
            $estoqueRecente->formatted_created_at = $estoqueRecente->created_at->format('d/m/Y H:i:s');
        }else{
            $estoqueRecente = new Estoque();
            $estoqueRecente->acao = null;
        }
            return view('estoque\alterarEstoque', ['produto' => $produto,'page' => 'estoque','estoqueRecente' => $estoqueRecente]);

    }

    public function getEstoqueRecente($id)
{
    $estoqueRecente = Estoque::where('produto_id', $id)->latest()->first();
    if ($estoqueRecente) {
        $estoqueRecente->formatted_created_at = $estoqueRecente->created_at->format('d/m/Y H:i:s');
    }else{
        $estoqueRecente = new Estoque();
        $estoqueRecente->acao = null;
    }
    return response()->json($estoqueRecente);
}

    public function update(Request $request, $id)
    {
        $produto = Produtos::find($id);
        $quantidade = $request->input('quantidade');
        $acao = $request->input('acao');

        if ($acao == 'reposicao') {
            $produto->quantidade += $quantidade;
        } elseif ($acao == 'baixa') {
            if($produto->quantidade < $quantidade){
                return redirect()->back()->withErrors(['quantidade'=> 'Quantidade em estoque insuficiente!']);
            }
            $produto->quantidade -= $quantidade;
        }
        if( $quantidade == 0 ){
            return redirect()->back()->withErrors(['quantidade'=> 'Quantidade não pode ser 0!']);
        }
        $produto->save();

        $estoque = new Estoque();
        $estoque->id_produto = $produto->id;
        $estoque->quantidade = $quantidade;
        $estoque->acao = $request->input('acao');
        $estoque->mes = date('m');
        $estoque->ano = date('Y');
        $estoque->usuario = Auth::user()->nome.' '.Auth::user()->sobrenome;
        $estoque->save();

        return redirect()->back()->with(['status'=> 'Estoque atualizado com sucesso!']);
    }
}
