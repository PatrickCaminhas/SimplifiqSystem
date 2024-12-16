<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Vendas;

class ClienteController extends Controller
{
    //
    public function create()
    {
        return view('sistema.cliente.cadastroCliente', ['page' => 'cliente']);

    }
    public function read()
    {
        $clientes = Clientes::all();
        return view('sistema.cliente.listaClientes', ['clientes' => $clientes, 'page' => 'cliente']);
    }
    public function quitarDividaView(Request $request)
    {
        $cliente = Clientes::find($request->id);
        return view('sistema.cliente.quitarDivida', ['cliente' => $cliente, 'page' => 'cliente']);
    }
    public function quitarDividaStore(Request $request)
    {
        $cliente = Clientes::find($request->cliente_id);
        $debito = $cliente->debitos;
        $pagamento = $request->valor_quitacao;
        if ($debito < $pagamento) {
            return redirect('clientes')->with('error', 'Valor de quitação maior que o valor da dívida!');
        }
        $cliente->debitos = $debito - $pagamento;
        $this->mudarEstadoVendaCrediario($pagamento, $cliente);
        $cliente->save();
        return redirect('clientes')->with('success', 'Dívida quitada com sucesso!');
    }

    public function mudarEstadoVendaCrediario($pagamento, $cliente)
    {
        // Buscar todas as vendas em crediário do cliente, ordenadas por data (FIFO)
        $vendasEmDebito = Vendas::where('cliente_id', $cliente->id)
            ->whereIn('metodo_pagamento', ['Crediário', 'Crediário(Pago Parcial)'])
            ->orderBy('data_venda', 'asc') // Ordenação FIFO
            ->get();
        foreach ($vendasEmDebito as $venda) {
            // Verificar se ainda há pagamento disponível
            if ($pagamento <= 0) {
                break;
            }


            if ($pagamento >= $venda->crediario) {
                // Pagamento é suficiente para quitar esta venda
                $venda->metodo_pagamento = 'Crediário(Pago)';
                $pagamento -= $venda->crediario; // Subtrai o valor pendente do pagamento
                $venda->crediario = 0; // Total quitado
            } else {
                // Pagamento não é suficiente para quitar esta venda
                $venda->metodo_pagamento = 'Crediário(Pago Parcial)';
                $venda->crediario -= $pagamento; // Atualiza o valor pago
                $pagamento = 0; // Todo o pagamento foi usado
            }

            $venda->save(); // Salva as alterações na venda
        }
    }




    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'cpfOuCnpj' => 'required|string',
            'telefone' => 'required|string',
            'email' => 'string',
            'endereco_completo' => 'required|string',
        ]);
        // Verificar se o cliente já está cadastrado pelo cpfOuCnpj
        $existingCliente = Clientes::where('cpfOuCnpj', $request->cpfOuCnpj)->first();
        if ($existingCliente) {
            return response()->json(['error' => 'Cliente já cadastrado com este CPF ou CNPJ.'], 409);
        }

        $cliente = new Clientes();
        $cliente->nome = $request->nome;
        $cliente->cpfOuCnpj = $request->cpfOuCnpj;
        $cliente->telefone = $request->telefone;
        if ($request->email == null) {
            $cliente->email = "-";
        } else {
            $cliente->email = $request->email;
        }
        $cliente->endereco_completo = $request->endereco_completo;
        $cliente->debitos = 0;
        $cliente->observacoes = "-";

        $cliente->save();

        return redirect('clientes')->with('success', 'Cliente cadastrado com sucesso!');
    }
    public function edit(Request $request)
    {
        $cliente = Clientes::find($request->id);
        return view('sistema.cliente.alterarCliente', ['cliente' => $cliente, 'page' => 'cliente']);
    }
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
        if ($request->email == null) {
            $cliente->email = "-";
        } else {
            $cliente->email = $request->email;
        }
        $cliente->endereco_completo = $request->endereco_completo;
        $cliente->debitos = 0;
        $cliente->observacoes = $request->observacoes;

        $cliente->save();

        return redirect('clientes')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function delete(Request $request)
    {
        $cliente = Clientes::find($request->id);
        $cliente->delete();
        return redirect('clientes')->with('success', 'Cliente deletado com sucesso!');
    }

}
