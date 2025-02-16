<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contas;
use Carbon\Carbon;

class ContasController extends Controller
{
    /**
     * Exibe a página com a lista de contas a pagar.
     */
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

    /**
     * Exibe a página para cadastro de uma nova conta.
     */
    public function create()
    {
        return view('sistema.informativo.contasAPagarCadastro', ['page' => 'Empresa']);
    }

    /**
     * Exibe a página para finalizar uma conta.
     */
    public function update(Request $request)
    {
        $conta = Contas::find($request->input('id'));
        return view('sistema.informativo.contasAPagarFinalizar', [
            'conta' => $conta,
            'page' => 'Empresa'
        ]);
    }

    /**
     * Cadastra uma nova conta no banco de dados.
     */
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

    /**
     * Finaliza uma conta, alterando seu estado e registrando a data de pagamento.
     */
    public function finalizarConta(Request $request)
    {
        $conta = Contas::find($request->input('id'));
        $conta->estado = $request->input('estado');
        $conta->data_pagamento = now()->format('Y-m-d');
        $conta->save();

        return redirect()->route('contas.read');
    }

    /**
     * Calcula o total de despesas dos últimos seis meses.
     */
    public function despesasUltimosSeisMeses()
    {
        $despesasPorMes = [];

        for ($i = 6; $i > 0; $i--) {
            $mesAno = now()->subMonths($i)->format('Y-m');
            $despesaMensal = Contas::where('data_pagamento', 'like', "$mesAno%")->sum('valor');
            $mesFormatado = now()->subMonths($i)->format('m/Y');

            $despesasPorMes[$mesFormatado] = $despesaMensal;
        }

        return $despesasPorMes;
    }

    /**
     * Exclui uma conta do banco de dados.
     */
    public function delete(Request $request)
    {
        $conta = Contas::find($request->input('id'));
        $conta->delete();

        return redirect()->route('contas.read');
    }
}
