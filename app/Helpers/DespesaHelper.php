<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Contas;

class DespesaHelper
{

    public static function despesasUltimosSeisMeses()
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
}
