<?php

namespace App\Http\Controllers;

use App\Models\Fornecedores;

use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    //
    public function create()
    {
        return view('sistema.fornecedores.cadastroDeFornecedor', ['page' => ' fornecedor']);
    }

    public function read(){
        $fornecedores = Fornecedores::all();
        return view('sistema.fornecedores.listaFornecedores', ['page' => ' fornecedor', 'fornecedores' => $fornecedores]);
    }
    public function edit(Request $request)
    {
        $fornecedor = Fornecedores::find($request->id);
        return view('sistema.fornecedores.alterarFornecedor', ['page' => ' fornecedor', 'fornecedor' => $fornecedor]);
    }
    public function update(Request $request)
    {
        $fornecedor = Fornecedores::find($request->id);
        $fornecedor->nome = $request->nome;
        $fornecedor->cnpj = $request->cnpj;
        $fornecedor->endereco = $request->endereco;
        $fornecedor->cidade = $request->cidade;
        $fornecedor->estado = $request->estado;
        $fornecedor->nome_representante = $request->nome_representante;
        $fornecedor->email = $request->email;
        $fornecedor->telefone = $request->telefone;
        $fornecedor->save();
        return redirect('fornecedores')->with('success', 'Fornecedor editado com sucesso!');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'cnpj' => 'required|string',
            'endereco' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
            'nome_representante' => 'required|string',
            'email' => 'required|string',
            'telefone' => 'required|string',
        ]);
        $fornecedores = Fornecedores::create([
            'nome' => $request->input('nome'),
            'cnpj' => $request->input('cnpj'),
            'endereco' => $request->input('endereco'),
            'cidade' => $request->input('cidade'),
            'estado' =>  $request->input('estado'),
            'nome_representante' => $request->input('nome_representante'),
            'email' => $request->input('email'),
            'telefone' => $request->input('telefone'),
        ]);

        if ($fornecedores) {
            return redirect()->back()->with('success', 'Cadastro realizado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao cadastrar fornecedor.');
        }
    }
    public function delete(Request $request)
    {
        $fornecedor = Fornecedores::find($request->id);
        $fornecedor->delete();
        return redirect('fornecedores')->with('success', 'Fornecedor deletado com sucesso!');
    }
}
