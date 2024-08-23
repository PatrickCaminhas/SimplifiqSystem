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
        } else {
            $estoqueRecente = new Estoque();
            $estoqueRecente->acao = null;
        }
        return view('estoque\alterarEstoque', ['produto' => $produto, 'page' => 'estoque', 'estoqueRecente' => $estoqueRecente]);

    }

    public function getEstoqueRecente($id)
    {
        $estoqueRecente = Estoque::where('id_produto', $id)->latest()->first();
        if ($estoqueRecente) {
            $estoqueRecente->formatted_created_at = $estoqueRecente->created_at->format('d/m/Y H:i:s');
            return response()->json([
                'acao' => $estoqueRecente->acao,
                'quantidade' => $estoqueRecente->quantidade,
                'usuario' => $estoqueRecente->usuario ?? 'desconhecido',  // Assumindo que há uma relação 'usuario' no model
                'formatted_created_at' => $estoqueRecente->formatted_created_at
            ]);
        } else {
            return response()->json(null);
        }
    }


    public function update(Request $request)
    {
        $produto = Produtos::find($request->input('id_produto'));
        $quantidade = $request->input('quantidade'.$request->input('id_produto'));
        $acao = $request->input('acao');
        if (is_null($request->input('acao'))) {
            return redirect()->back()->withErrors(['acao' => 'Ação não foi recebida. '.$acao]);
        }
        if ($acao == 'reposicao') {
            $produto->quantidade += $quantidade;
        } elseif ($acao == 'baixa') {
            if ($produto->quantidade < $quantidade) {
                return redirect()->back()->withErrors(['quantidade' => 'Quantidade em estoque insuficiente!']);
            }
            $produto->quantidade -= $quantidade;
        }
        if ($quantidade == 0) {
            return redirect()->back()->withErrors(['quantidade' => 'Quantidade não pode ser 0.']);
        }

        $produto->save();

        $estoque = new Estoque();
        $estoque->id_produto = $produto->id;
        $estoque->quantidade = $quantidade;
        $estoque->acao = $acao;
        $estoque->mes = date('m');
        $estoque->ano = date('Y');
        $estoque->usuario = Auth::user()->nome . ' ' . Auth::user()->sobrenome;
        $estoque->save();

        return redirect()->back()->with(['status' => 'Estoque atualizado com sucesso!']);
    }
}
