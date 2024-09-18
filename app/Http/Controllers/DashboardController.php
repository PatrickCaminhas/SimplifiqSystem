<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contas; // Import the Contas class
use App\Helpers\DespesaHelper;
use App\Models\Vendas;
use App\Models\Produtos;
use App\Models\Metas;
use App\Models\Clientes;


class DashboardController extends Controller
{
    public function index()
    {
        $contas = Contas::all();
        $despesasPorMes = DespesaHelper::despesasUltimosSeisMeses();
        $ultimas6Vendas = $this->ultimasVendasRealizadas();
        $ultimos6Produtos = $this->ultimosProdutosCadastrados();
        $metasFaltandoUmaSemana = $this->metasQueFaltamUmaSemana();
        $contas = $this->proximasContasAVencer();
        $cartoesDashboard = $this->cartoesDashboard();
        $cartoesDashboard = (object) $cartoesDashboard;
        return view('sistema\dashboard', [
            'page' => 'dashboard',
            'contas' => $contas,
            'despesasPorMes' => $despesasPorMes,
            'ultimas6Vendas' => $ultimas6Vendas,
            'ultimos6Produtos' => $ultimos6Produtos,
            'metasFaltandoUmaSemana' => $metasFaltandoUmaSemana,
            'cartoesDashboard' => $cartoesDashboard

        ]);
    }

    public function cadastros()
    {

        return view('sistema\cadastrosSistema\cadastros', ['page' => 'cadastros']);
    }


    public function cartoesDashboard(){
        $produtosCadastrados = $this->quantidadeProdutosCadastrados();
        $vendasRealizadas = $this->quantidadeVendasRealizadas();
        $clientesCadastrados = $this->quantidadeClientesCadastrados();
        $metasCumpridas = $this->quantidadeMetasCumpridas();
        $metasEmAndamento = $this->quantidadeMetasEmAndamento();
        $itensNoEstoque = $this->quantidadeItensNoEstoque();
        return [
            'produtosCadastrados' => $produtosCadastrados,
            'vendasRealizadas' => $vendasRealizadas,
            'clientesCadastrados' => $clientesCadastrados,
            'metasCumpridas' => $metasCumpridas,
            'metasEmAndamento' => $metasEmAndamento,
            'itensNoEstoque' => $itensNoEstoque
        ];
    }
    public function quantidadeProdutosCadastrados(){
        $produtos = Produtos::all()->count();
        return $produtos;
    }
    public function quantidadeVendasRealizadas(){
        $vendas = Vendas::all()->count();
        return $vendas;
    }
    public function quantidadeClientesCadastrados(){
        $clientes = Clientes::all()->count();
        return $clientes;
    }
    public function quantidadeMetasCumpridas()
    {
        $metas = Metas::where('estado', ['Cumprida', 'Finalizado'])
            ->count();
        return $metas;
    }
    public function quantidadeMetasEmAndamento()
    {
        $metas = Metas::where('estado', 'Pendente')
            ->count();
        return $metas;
    }

    public function quantidadeItensNoEstoque()
    {
        $produtos = Produtos::all()->sum('quantidade');
        return $produtos;
    }

    public function ultimasVendasRealizadas()
    {
        $vendas = Vendas::orderBy('created_at', 'desc')->with('cliente')
            ->take(5)
            ->get();
        return $vendas;
    }

    public function ultimosProdutosCadastrados()
    {
        $produtos = Produtos::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return $produtos;
    }

    public function metasQueFaltamUmaSemana()
    {
        $metas = Metas::where('ending_at', '<', now()->addWeek())
            ->get();
        return $metas;
    }
    public function proximasContasAVencer(){
        $contas = Contas::where('data_vencimento', '>', now())
            ->orderBy('data_vencimento', 'asc')
            ->get();
        return $contas;
    }

    // Adicione outros métodos conforme necessário
}
