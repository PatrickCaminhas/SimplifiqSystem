<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa_information;
use App\Models\Contas;
use Carbon\Carbon;
use App\Models\Vendas;
use App\Models\Clientes;
use App\Models\Produtos;

class InformacaoEmpresaController extends Controller
{
    //
    public function createRead()
    {
        $informacaoEmpresa = Empresa_information::first();
        $despesasPorMes = $this->despesasUltimosSeisMeses();
        $despesasDiarias = $this->despesasDiariasMesAtual();
        $vendasPorMes = $this->vendasUltimosSeisMeses();
        $vendasDiarias = $this->vendasDiariasMesAtual();
        $vendasPorMetodoPagamento = $this->vendasPorMetodoPagamento();
        $crediarioMensal = $this->vendaCrediarioUltimosSeisMeses();
        $crediarioClientes = $this->crediarioClientesValor();
        $produtos = $this->estoqueProdutos();
        $produtos = (object) $produtos;
        $crediarioClientes = (object) $crediarioClientes;

        return view('sistema.informativo.informacaoEmpresa', [
            'informacaoEmpresa' => $informacaoEmpresa,
            'page' => 'Empresa',
            'despesasPorMes' => $despesasPorMes,
            'despesasDiarias' => $despesasDiarias,
            'vendasPorMes' => $vendasPorMes,
            'vendasDiarias' => $vendasDiarias,
            'vendasPorMetodoPagamento' => $vendasPorMetodoPagamento,
            'crediarioMensal' => $crediarioMensal,
            'crediarioClientes' => $crediarioClientes,
            'produtos' => $produtos
        ]);
    }



    public function despesasUltimosSeisMeses()
    {
        $despesasPorMes = [];

        // Incluir o mês atual (0) e os 5 meses anteriores
        for ($i = 0; $i < 6; $i++) {
            $mes = now()->subMonths($i)->format('Y-m'); // Formato de data para busca

            // Somar as despesas mensais para o mês atual e os anteriores
            $despesaMensal = Contas::where('data_pagamento', 'like', $mes . '%')
                ->sum('valor');

            // Formato para exibição (mes/ano)
            $mesFormatado = now()->subMonths($i)->format('m/Y');
            $despesasPorMes[$mesFormatado] = $despesaMensal;
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
            $dia = str_pad($i, 2, '0', STR_PAD_LEFT) . '/' . $hoje->format('m/Y');

            $despesasPorDia[$dia] = $despesaDiaria;
        }

        return $despesasPorDia;
    }
    public function vendasUltimosSeisMeses()
    {
        $vendasPorMes = [];

        // Incluir o mês atual (0)
        for ($i = 0; $i < 6; $i++) {
            $mes = now()->subMonths($i)->format('Y-m'); // Formato de data para busca
            $vendasMensal = Vendas::where('data_venda', 'like', $mes . '%')
                ->sum('valor_total');

            $mesFormatado = now()->subMonths($i)->format('m/Y'); // Formato para exibição (mes/ano)
            $vendasPorMes[$mesFormatado] = $vendasMensal;
        }

        return $vendasPorMes;
    }


    public function vendasDiariasMesAtual()
    {
        $vendasPorDia = [];
        $hoje = now();
        $diasNoMes = $hoje->day;

        for ($i = 1; $i <= $diasNoMes; $i++) {
            $dia = $hoje->format('Y-m') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $vendaDiaria = Vendas::whereDate('data_venda', $dia)
                ->sum('valor_total');
            $dia = str_pad($i, 2, '0', STR_PAD_LEFT) . '/' . $hoje->format('m/Y');

            $vendasPorDia[$dia] = $vendaDiaria;
        }

        return $vendasPorDia;
    }
    public function vendasPorMetodoPagamento()
    {
        $dataInicial = Carbon::now()->subMonths(12)->startOfMonth();
        $dataFinal = Carbon::now()->endOfMonth();

        $vendasDinheiro = Vendas::where('metodo_pagamento', 'Dinheiro')
            ->whereBetween('data_venda', [$dataInicial, $dataFinal])
            ->count();

        $vendasPix = Vendas::where('metodo_pagamento', 'Pix')
            ->whereBetween('data_venda', [$dataInicial, $dataFinal])
            ->count();

        $vendasCartaoCredito = Vendas::where('metodo_pagamento', 'Cartão de crédito')
            ->whereBetween('data_venda', [$dataInicial, $dataFinal])
            ->count();

        $vendasCartaoDebito = Vendas::where('metodo_pagamento', 'Cartão de débito')
            ->whereBetween('data_venda', [$dataInicial, $dataFinal])
            ->count();

        $vendasCrediario = Vendas::where('metodo_pagamento', 'Crediário')
            ->whereBetween('data_venda', [$dataInicial, $dataFinal])
            ->count();

        return [
            'Dinheiro' => $vendasDinheiro,
            'Pix' => $vendasPix,
            'Cartão de crédito' => $vendasCartaoCredito,
            'Cartão de débito' => $vendasCartaoDebito,
            'Crediário' => $vendasCrediario
        ];
    }

public function vendaCrediarioUltimosSeisMeses()
{
    $crediarioPorMes = [];

    // Incluir o mês atual (0)
    for ($i = 0; $i < 6; $i++) {
        $mes = now()->subMonths($i)->format('Y-m'); // Formato de data para busca

        // Filtrando as vendas do crediário usando a data formatada (ano-mês) no campo 'data_venda'
        $crediarioMensal = Vendas::whereDate('data_venda', '>=', now()->subMonths($i)->startOfMonth())
            ->whereDate('data_venda', '<=', now()->subMonths($i)->endOfMonth())
            ->where('metodo_pagamento', 'Crediário')
            ->sum('valor_total');

        // Formato para exibição (mes/ano)
        $mesFormatado = now()->subMonths($i)->format('m/Y');
        $crediarioPorMes[$mesFormatado] = $crediarioMensal;
    }

    return $crediarioPorMes;
}


    public function crediarioClientesValor()
    {
        $qtdClientes = Clientes::where('debitos', '>', 0)->count();
        $valorTotal = Clientes::where('debitos', '>', 0)->sum('debitos');
        return [
            'qtdClientes' => $qtdClientes,
            'valorTotal' => $valorTotal
        ];
    }

    public function estoqueProdutos()
    {
        $produtos = Produtos::all();
        $estoque = 0;
        $qtdProdutosEmEstoque = 0;
        $qtdProdutosSemEstoque = 0;
        $valorTotalEmEstoque = 0;

        foreach ($produtos as $produto) {
            $estoque += $produto->quantidade;
            $valorTotalEmEstoque += $produto->quantidade * $produto->preco_venda;
            if ($produto->quantidade > 0) {
                $qtdProdutosEmEstoque++;
            } elseif ($produto->quantidade == 0) {
                $qtdProdutosSemEstoque++;
            }
        }

        return [
            'estoque' => $estoque,
            'qtdProdutosEmEstoque' => $qtdProdutosEmEstoque,
            'qtdProdutosSemEstoque' => $qtdProdutosSemEstoque,
            'valorTotalEmEstoque' => $valorTotalEmEstoque,
        ];
    }

}
