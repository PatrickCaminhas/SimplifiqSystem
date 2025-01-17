<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contas;
use Carbon\Carbon;


class ContasController extends Controller
{
    //
    public function createRead()
    {
        $contas = Contas::all();
        $despesasPorMes = $this->despesasUltimosSeisMeses();

        return view('sistema.informativo.contasAPagar', [
            'contas' => $contas,
            'despesasPorMes' => $despesasPorMes,
            'page' => 'Empresa'
        ]);
    }

    public function create()
    {
        return view('sistema.informativo.contasAPagarCadastro', ['page' => 'Empresa']);
    }
    public function update(Request $request)
    {
        $conta = Contas::find($request->input('id'));
        return view('sistema.informativo.contasAPagarFinalizar', ['conta' => $conta], ['page' => 'Empresa']);
    }
    public function store(Request $request)
    {
        $conta = new Contas();
        $conta->credor = $request->input('credor');
        $conta->valor = $request->input('valor');
        $conta->tipo = $request->input('tipo');
        $conta->data_vencimento = $request->input('data_vencimento');
        $conta->estado = 'Pendente';
        $conta->save();
        return redirect()->route('contas.read');
    }
    public function finalizarConta(Request $request)
    {
        $conta = Contas::find($request->input('id'));
        $conta->estado = $request->input('estado');
        $conta->data_pagamento = date('Y-m-d');
        $conta->save();
        return redirect()->route('contas.read');
    }

    public function despesasUltimosSeisMeses()
    {
        $despesasPorMes = [];

        for ($i = 6; $i > 0; $i--) {
            $mes = now()->subMonths($i)->format('Y-m');
            $despesaMensal = Contas::where('data_pagamento', 'like', $mes . '%')
                ->sum('valor');
            $mes = now()->subMonths($i)->format('m/Y');

            $despesasPorMes[$mes] = $despesaMensal;
        }

        return $despesasPorMes;
    }

    public function delete(Request $request)
    {
        $conta = Contas::find($request->input('id'));
        $conta->delete();
        return redirect()->route('contas.read');
    }
}
