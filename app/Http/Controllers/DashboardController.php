<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Contas;
use App\Helpers\DespesaHelper;
use App\Models\Vendas;
use App\Models\Produtos;
use App\Models\Metas;
use App\Models\Clientes;

class DashboardController extends Controller
{
    /**
     * Exibe o painel principal do sistema.
     */
    public function index()
    {
        return view('sistema\dashboard', [
            'page' => 'Pagina Inicial',
            'contas' => $this->proximasContasAVencer(),
            'despesasPorMes' => DespesaHelper::despesasUltimosSeisMeses(),
            'ultimas6Vendas' => $this->ultimasVendasRealizadas(),
            'ultimos6Produtos' => $this->ultimosProdutosCadastrados(),
            'metasFaltandoUmaSemana' => $this->metasQueFaltamUmaSemana(),
            'cartoesDashboard' => (object) $this->cartoesDashboard(),
            'vendasSemana' => $this->vendasNaUltimaSemana()
        ]);
    }

    /**
     * Exibe uma tela de teste para home.
     */
    public function testeHome()
    {
        return view('testeHome', [
            'page' => 'Pagina Inicial',
            'contas' => $this->proximasContasAVencer(),
            'despesasPorMes' => DespesaHelper::despesasUltimosSeisMeses(),
            'ultimas6Vendas' => $this->ultimasVendasRealizadas(),
            'ultimos6Produtos' => $this->ultimosProdutosCadastrados(),
            'metasFaltandoUmaSemana' => $this->metasQueFaltamUmaSemana(),
            'cartoesDashboard' => (object) $this->cartoesDashboard(),
            'vendasSemana' => $this->vendasNaUltimaSemana()
        ]);
    }

    /**
     * Exibe a tela de cadastros.
     */
    public function cadastros()
    {
        return view('sistema\cadastrosSistema\cadastros', ['page' => 'cadastros']);
    }

    /**
     * Retorna os dados dos cartões do dashboard.
     */
    private function cartoesDashboard()
    {
        return [
            'produtosCadastrados' => $this->quantidadeProdutosCadastrados(),
            'vendasRealizadas' => $this->quantidadeVendasRealizadas(),
            'clientesCadastrados' => $this->quantidadeClientesCadastrados(),
            'metasCumpridas' => $this->quantidadeMetasCumpridas(),
            'metasEmAndamento' => $this->quantidadeMetasEmAndamento(),
            'itensNoEstoque' => $this->quantidadeItensNoEstoque()
        ];
    }

    /** Métodos auxiliares para contagem de registros no sistema */
    private function quantidadeProdutosCadastrados() { return Produtos::count(); }
    private function quantidadeVendasRealizadas() { return Vendas::count(); }
    private function quantidadeClientesCadastrados() { return Clientes::count(); }
    private function quantidadeMetasCumpridas() { return Metas::whereIn('estado', ['Cumprida', 'Finalizado'])->count(); }
    private function quantidadeMetasEmAndamento() { return Metas::where('estado', 'Pendente')->count(); }
    private function quantidadeItensNoEstoque() { return Produtos::sum('quantidade'); }

    /**
     * Retorna as últimas 5 vendas realizadas com os clientes associados.
     */
    private function ultimasVendasRealizadas()
    {
        return Vendas::orderBy('created_at', 'desc')->with('cliente')->take(5)->get();
    }

    /**
     * Retorna os últimos 5 produtos cadastrados.
     */
    private function ultimosProdutosCadastrados()
    {
        return Produtos::orderBy('created_at', 'desc')->take(5)->get();
    }

    /**
     * Retorna as metas que estão a menos de uma semana do prazo final.
     */
    private function metasQueFaltamUmaSemana()
    {
        return Metas::where('ending_at', '<', now()->addWeek())->get();
    }

    /**
     * Retorna as próximas contas a vencer ordenadas pela data de vencimento.
     */
    private function proximasContasAVencer()
    {
        return Contas::where('data_vencimento', '>', now())->orderBy('data_vencimento', 'asc')->get();
    }

    /**
     * Retorna o total de vendas na última semana, agrupando por data.
     */
    private function vendasNaUltimaSemana()
    {
        return Vendas::where('created_at', '>', now()->subWeek())
            ->where('metodo_pagamento', '!=', 'Crediário')
            ->selectRaw('DATE(data_venda) as data, SUM(valor_total) as total_vendas')
            ->groupBy('data')
            ->orderBy('data')
            ->get();
    }
}
