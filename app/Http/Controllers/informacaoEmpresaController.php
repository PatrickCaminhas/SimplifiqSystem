<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa_information;
use App\Models\Contas;
use Carbon\Carbon;

class informacaoEmpresaController extends Controller
{
    //
    public function createRead()
    {
        $informacaoEmpresa = Empresa_information::first();
        $despesasPorMes = $this->despesasUltimosSeisMeses();
        $despesasDiarias = $this->despesasDiariasMesAtual();


        return view('sistema.informativo.informacaoEmpresa', ['informacaoEmpresa' => $informacaoEmpresa, 'page' => 'informacaoEmpresa', 'despesasPorMes' => $despesasPorMes, 'despesasDiarias' => $despesasDiarias]);
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

    public function despesasDiariasMesAtual()
    {
        $despesasPorDia = [];
        $hoje = now();
        $diasNoMes = $hoje->day;

        for ($i = 1; $i <= $diasNoMes; $i++) {
            $dia = $hoje->format('Y-m') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $despesaDiaria = Contas::whereDate('data_pagamento', $dia)
                ->sum('valor');
            $dia =  str_pad($i, 2, '0', STR_PAD_LEFT).'/'.$hoje->format('m/Y');

            $despesasPorDia[$dia] = $despesaDiaria;
        }

        return $despesasPorDia;
    }

}
