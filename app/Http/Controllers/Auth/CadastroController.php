<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Empresas;
use App\Models\Funcionarios;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CadastroController extends Controller
{
    public function create()
    {
        return view('index\cadastroDeEmpresa');
    }

    public function store(Request $request)
    {
        
        // Validação dos dados
        $request->validate([
            'nomeempresa' => 'required|string',
            'cnpj' => 'required|string',
            'tamanhoempresa' => 'required|string',
            'tipoempresa' => 'required|string',
            'telefone' => 'required|string',
            'nome' => 'required|string',
            'sobrenome' => 'required|string',
            'email' => 'required|string|email|unique:funcionarios,email',
            'senha' => 'required|string|min:8',
        ]);

        // Criando a empresa
        $empresa = Empresas::create([
            'nome' => $request->input('nomeempresa'),
            'cnpj' => $request->input('cnpj'),
            'tamanho_empresa' => $request->input('tamanhoempresa'),
            'tipo_empresa' => $request->input('tipoempresa'),
            'telefone' => $request->input('telefone'),
        ]);

        // Gerando ID único para o funcionário
        $id_funcionario = mt_rand(100, 999) . strtoupper(substr($request->input('nome'), 0, 1) . substr($request->input('sobrenome'), 0, 1)) . mt_rand(10, 99);

        // Criando o funcionário
        $funcionario = Funcionarios::create([
            'id' => $id_funcionario,
            'nome' => $request->input('nome'),
            'sobrenome' => $request->input('sobrenome'),
            'email' => $request->input('email'),
            'cnpj' => $empresa->cnpj,
            'senha' => Hash::make($request->input('senha')),
        ]);

        // Redirecionamento após o cadastro
        if ($funcionario) {
            return redirect('/')->with('success', 'Cadastro realizado com sucesso!');
        } else {
            return view('index\login');
        }
        
    }
}
