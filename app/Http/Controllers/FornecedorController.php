<?php

namespace App\Http\Controllers;

use App\Models\Fornecedores;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE CADASTRO DE FORNECEDORES
    // ------------------
    public function create()
    {
        return view('sistema.fornecedores.cadastroDeFornecedor', ['page' => 'Fornecedores']);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DA LISTA DE FORNECEDORES
    // PARAMETROS: TODOS OS FORNECEDORES
    // ------------------
    public function read()
    {
        $fornecedores = Fornecedores::all();
        return view('sistema.fornecedores.listaFornecedores', ['page' => 'Fornecedores', 'fornecedores' => $fornecedores]);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE EDIÇÃO DE FORNECEDORES
    // PARAMETROS: REQUEST COM ID DO FORNECEDOR
    // ------------------
    public function edit(Request $request)
    {
        $fornecedor = Fornecedores::find($request->id);
        return view('sistema.fornecedores.alterarFornecedor', ['page' => 'Fornecedores', 'fornecedor' => $fornecedor]);
    }

    // ------------------
    // FUNÇÃO PARA: ATUALIZAR FORNECEDOR
    // PARAMETROS: REQUEST COM ID E DADOS ATUALIZADOS DO FORNECEDOR
    // ------------------
    public function update(Request $request)
    {
        $fornecedor = Fornecedores::find($request->id);
        $fornecedor->update($request->only(['nome', 'cnpj', 'endereco', 'cidade', 'estado', 'nome_representante', 'email', 'telefone']));

        return redirect('fornecedores')->with('success', 'Fornecedor editado com sucesso!');
    }

    // ------------------
    // FUNÇÃO PARA: REGISTRAR NOVO FORNECEDOR
    // PARAMETROS: REQUEST COM DADOS DO FORNECEDOR
    // ------------------
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

        $fornecedores = Fornecedores::create($request->only(['nome', 'cnpj', 'endereco', 'cidade', 'estado', 'nome_representante', 'email', 'telefone']));

        if ($fornecedores) {
            return redirect()->back()->with('success', 'Cadastro realizado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao cadastrar fornecedor.');
        }
    }

    // ------------------
    // FUNÇÃO PARA: DELETAR FORNECEDOR
    // PARAMETROS: REQUEST COM ID DO FORNECEDOR
    // ------------------
    public function delete(Request $request)
    {
        $fornecedor = Fornecedores::find($request->id);
        if ($fornecedor) {
            $fornecedor->delete();
            return redirect('fornecedores')->with('success', 'Fornecedor deletado com sucesso!');
        }
        return redirect()->back()->with('error', 'Fornecedor não encontrado.');
    }
}
