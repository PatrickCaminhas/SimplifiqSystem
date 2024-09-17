<?php
namespace App\Services;

use App\Models\HistoricoFaturamento;
use Carbon\Carbon;
use App\Models\Vendas;

class FaturamentoService
{

    public function calcularVendasDoMesAtual()
    {
        // Definir o início e o fim do mês atual
        $inicioMes = Carbon::now()->startOfMonth(); // Exemplo: 2024-09-01 00:00:00
        $fimMes = Carbon::now()->endOfMonth();      // Exemplo: 2024-09-30 23:59:59

        // Buscar todas as vendas realizadas dentro desse intervalo de datas
        $totalVendasMesAtual = Vendas::whereBetween('data_venda', [$inicioMes, $fimMes])
            ->sum('valor'); // Soma o valor de todas as vendas do mês

        return $totalVendasMesAtual;
    }
    public function calcularRendaDosUltimos12Meses()
    {
        $mesAtual = Carbon::now()->startOfMonth(); // Pega o início do mês atual

        // Pega os últimos 12 meses
        $rendaUltimos12Meses = HistoricoFaturamento::where('mes', '>=', $mesAtual->subMonths(12)->format('Y-m'))
            ->get();

        $rendaTotal = $rendaUltimos12Meses->sum('renda_bruta');

        return $rendaTotal;
    }
    public function atualizarFaturamentoMensal($valor_vendas_mes)
    {
        $mesAtual = Carbon::now()->format('Y-m'); // Exemplo: '2024-08'

        // Verifica se já existe um registro para o mês atual
        $faturamentoExistente = HistoricoFaturamento::where('mes', $mesAtual)->first();

        if (!$faturamentoExistente) {
            // Insere novo registro para o mês atual
            HistoricoFaturamento::create([
                'mes' => $mesAtual,
                'renda_bruta' => $valor_vendas_mes,
            ]);
        }
    }

}
