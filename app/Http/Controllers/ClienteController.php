<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Vendas;
use App\Models\Itens_venda;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE CADASTRO DE CLIENTES
    // ------------------
    public function create()
    {
        return view('sistema.cliente.cadastroCliente', ['page' => 'Cliente']);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE LISTA DE CLIENTES
    // PARAMETROS: TODOS OS CLIENTES
    // ------------------
    public function read()
    {
        $clientes = Clientes::all();
        return view('sistema.cliente.listaClientes', ['clientes' => $clientes, 'page' => 'Cliente']);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE QUITAÇÃO DE DÍVIDA
    // PARAMETROS: ID DO CLIENTE
    // ------------------
    public function quitarDividaView(Request $request)
    {
        $cliente = Clientes::find($request->id);
        return view('sistema.cliente.quitarDivida', ['cliente' => $cliente, 'page' => 'Cliente']);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE ALTERAÇÃO DE CLIENTE
    // PARAMETROS: ID DO CLIENTE
    // ------------------
    public function edit(Request $request)
    {
        $cliente = Clientes::find($request->id);
        return view('sistema.cliente.alterarCliente', ['cliente' => $cliente, 'page' => 'Cliente']);
    }

    // ------------------
    // FUNÇÃO PARA: CADASTRAR CLIENTE
    // PARAMETROS: REQUEST COM DADOS DO CLIENTE
    // ------------------
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'cpfOuCnpj' => 'required|string',
            'telefone' => 'required|string',
            'endereco_completo' => 'required|string',
        ]);

        $existingCliente = Clientes::where('cpfOuCnpj', $request->cpfOuCnpj)->first();
        if ($existingCliente) {
            return response()->json(['error' => 'Cliente já cadastrado com este CPF ou CNPJ.'], 409);
        }

        $cliente = new Clientes();
        $cliente->nome = $request->nome;
        $cliente->cpfOuCnpj = $request->cpfOuCnpj;
        $cliente->telefone = $request->telefone;
        $cliente->email = $request->email ?? "-";
        $cliente->endereco_completo = $request->endereco_completo;
        $cliente->debitos = 0;
        $cliente->observacoes = "-";

        $cliente->save();

        return redirect('clientes')->with('success', 'Cliente cadastrado com sucesso!');
    }

    // ------------------
    // FUNÇÃO PARA: ATUALIZAR CLIENTE
    // PARAMETROS: REQUEST COM ID DO CLIENTE E NOVOS DADOS
    // ------------------
    public function update(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'cpfOuCnpj' => 'required|string',
            'telefone' => 'required|string',
            'email' => 'string',
            'endereco_completo' => 'required|string',
        ]);

        $cliente = Clientes::find($request->id);
        $cliente->nome = $request->nome;
        $cliente->cpfOuCnpj = $request->cpfOuCnpj;
        $cliente->telefone = $request->telefone;
        $cliente->email = $request->email ?? "-";
        $cliente->endereco_completo = $request->endereco_completo;
        $cliente->debitos = 0;
        $cliente->observacoes = $request->observacoes;

        $cliente->save();

        return redirect('clientes')->with('success', 'Cliente atualizado com sucesso!');
    }

    // ------------------
    // FUNÇÃO PARA: QUITAR DÍVIDA DO CLIENTE
    // PARAMETROS: REQUEST COM ID DO CLIENTE E VALOR PAGO
    // ------------------
    public function quitarDividaStore(Request $request)
    {
        $cliente = Clientes::find($request->cliente_id);
        $debito = $cliente->debitos;
        $pagamento = $request->valor_quitacao;

        if ($debito < $pagamento) {
            return redirect('clientes')->with('error', 'Valor de quitação maior que o valor da dívida!');
        }

        $cliente->debitos -= $pagamento;
        $this->mudarEstadoVendaCrediario($pagamento, $cliente);
        $cliente->save();

        return redirect('clientes')->with('success', 'Dívida quitada com sucesso!');
    }

    // ------------------
    // FUNÇÃO PARA: ATUALIZAR ESTADO DAS VENDAS NO CREDIÁRIO
    // PARAMETROS: VALOR PAGO E CLIENTE
    // ------------------
    public function mudarEstadoVendaCrediario($pagamento, $cliente)
    {
        $vendasEmDebito = Vendas::where('cliente_id', $cliente->id)
            ->whereIn('metodo_pagamento', ['Crediário', 'Crediário(Pago Parcial)'])
            ->orderBy('data_venda', 'asc')
            ->get();

        foreach ($vendasEmDebito as $venda) {
            if ($pagamento <= 0) {
                break;
            }

            if ($pagamento >= $venda->crediario) {
                $venda->metodo_pagamento = 'Crediário(Pago)';
                $pagamento -= $venda->crediario;
                $venda->crediario = 0;
            } else {
                $venda->metodo_pagamento = 'Crediário(Pago Parcial)';
                $venda->crediario -= $pagamento;
                $pagamento = 0;
            }

            $venda->save();
        }
    }

    // ------------------
    // FUNÇÃO PARA: DELETAR CLIENTE
    // PARAMETROS: REQUEST COM ID DO CLIENTE
    // ------------------
    public function delete(Request $request)
    {
        $cliente = Clientes::find($request->id);
        $cliente->delete();
        return redirect('clientes')->with('success', 'Cliente deletado com sucesso!');
    }

    // ------------------
    // FUNÇÃO PARA: BUSCAR OS 10 PRODUTOS MAIS COMPRADOS PELO CLIENTE
    // PARAMETROS: ID DO CLIENTE
    // ------------------
    public function buscarProdutosMaisComprados($id)
    {
        $cliente = Clientes::find($id);

        if (!$cliente) {
            return response()->json(['error' => true, 'message' => 'Cliente não encontrado'], 404);
        }

        $produtosMaisComprados = Itens_venda::whereHas('venda', function ($query) use ($cliente) {
            $query->where('cliente_id', $cliente->id)
                ->where('metodo_pagamento', '!=', 'Crediário');
        })
            ->select('produto_id', DB::raw('SUM(quantidade) as total_comprado'))
            ->groupBy('produto_id')
            ->orderByDesc('total_comprado')
            ->with('produto') // Carrega a relação produto
            ->limit(10)
            ->get();

        return response()->json($produtosMaisComprados);
    }

}
