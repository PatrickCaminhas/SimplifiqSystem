<?php

namespace App\Http\Controllers;

use App\Models\Fornecedores; // Add this line to import the Produto class

use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    //
    public function create()
    {
        return view('cadastrosSistema\cadastroDeFornecedor', ['page' => 'cadastrofornecedor']);
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
            return redirect('dashboard')->with('success', 'Cadastro realizado com sucesso!');
        } else {
            return redirect('cadastrofornecedor')->with('error', 'Erro ao cadastrar fornecedor.');
        }
    }
}
