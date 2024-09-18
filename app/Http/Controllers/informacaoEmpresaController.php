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
            'page' => 'informacaoEmpresa',
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
            $dia = str_pad($i, 2, '0', STR_PAD_LEFT) . '/' . $hoje->format('m/Y');

            $despesasPorDia[$dia] = $despesaDiaria;
        }

        return $despesasPorDia;
    }
    public function vendasUltimosSeisMeses()
    {
        $vendasPorMes = [];

        for ($i = 6; $i > 0; $i--) {
            $mes = now()->subMonths($i)->format('Y-m');
            $vendasMensal = Vendas::where('data_venda', 'like', $mes . '%')
                ->sum('valor_total');
            $mes = now()->subMonths($i)->format('m/Y');

            $vendasPorMes[$mes] = $vendasMensal;
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

        for ($i = 5; $i >= 0; $i--) {
            $mes = now()->subMonths($i)->format('Y-m');
            $crediarioMensal = Vendas::where('data_venda', 'like', $mes . '%')->where('metodo_pagamento', 'Crediário')
                ->sum('valor_total');
            $mes = now()->subMonths($i)->format('m/Y');

            $crediarioPorMes[$mes] = $crediarioMensal;
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
