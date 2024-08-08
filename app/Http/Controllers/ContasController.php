<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contas;


class ContasController extends Controller
{
    //
    public function createRead()
    {
        $contas = Contas::all();
        return view('sistema.informativo.contasAPagar', ['contas' => $contas],['page'=>'contas']);
    }
    public function create()
    {
        return view('sistema.informativo.contasAPagarCadastro', ['page' => 'contas']);
    }
    public function update(Request $request)
    {
        $conta = Contas::find($request->input('id'));
        return view('sistema.informativo.contasAPagarFinalizar', ['conta' => $conta],['page'=>'contas']);
    }
    public function createConta(Request $request){
        $conta = new Contas();
        $conta->credor = $request->input('credor');
        $conta->valor = $request->input('valor');
        $conta->tipo = $request->input('tipo');
        $conta->data_vencimento = $request->input('data_vencimento');
        $conta->estado = 'Pendente';
        $conta->save();
        return redirect()->route('contas.read');

    }
    public function finalizarConta(Request $request){
        $conta = Contas::find($request->input('id'));
        $conta->estado = $request->input('estado');
        $conta->data_pagamento = date('Y-m-d');
        $conta->save();
        return redirect()->route('contas.read');
    }
}
