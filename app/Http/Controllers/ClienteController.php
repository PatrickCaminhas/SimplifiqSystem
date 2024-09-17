<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;

class ClienteController extends Controller
{
    //
    public function create()
    {
        return view('sistema.cliente.cadastroCliente', ['page' => 'cadastro']);

    }
    public function read()
    {
        $clientes = Clientes::all();
        return view('sistema.cliente.listaClientes', ['clientes' => $clientes, 'page' => 'lista']);
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
            $request->email = "-";
        }
        $cliente->email = $request->email;
        $cliente->endereco_completo = $request->endereco_completo;
        $cliente->debitos = 0;
        $cliente->observacoes = "-";

        $cliente->save();

        return response()->json($cliente);
    }
    public function edit(Request $request)
    {
        $cliente = Clientes::find($request->id);
        return view('sistema.cliente.alterarCliente', ['cliente' => $cliente, 'page' => 'editar']);
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
            $request->email = "-";
        }
        $cliente->email = $request->email;
        $cliente->endereco_completo = $request->endereco_completo;
        $cliente->debitos = 0;
        $cliente->observacoes = $request->observacoes;

        $cliente->save();

        return redirect('clientes')->with('success', 'Cliente atualizado com sucesso!');
    }

}
