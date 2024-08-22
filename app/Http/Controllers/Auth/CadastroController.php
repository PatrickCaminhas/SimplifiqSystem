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
    public function cadastroConcluido()
    {
        return view('index\cadastroEmpresaConcluido');
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

        // Verificar se a empresa já existe
        if (!Empresas::where('cnpj', $request->input('cnpj'))->exists()) {
            // Criando a empresa
            $empresa = Empresas::create([
                'nome' => $request->input('nomeempresa'),
                'cnpj' => $request->input('cnpj'),
                'tamanho_empresa' => $request->input('tamanhoempresa'),
                'tipo_empresa' => $request->input('tipoempresa'),
                'telefone' => $request->input('telefone'),
                'estado' => 'inexistente',
            ]);
        } else {
            return redirect()->back()->withErrors([
                'cnpj' => 'O CNPJ fornecido já está cadastrado.',
            ]);
        }

        // Gerando ID único para o funcionário
        do {
            $id_funcionario = mt_rand(100, 999);
        } while (Funcionarios::where('id', $id_funcionario)->exists());

        // Criando o funcionário
        $funcionario = Funcionarios::create([
            'id' => $id_funcionario,
            'nome' => $request->input('nome'),
            'sobrenome' => $request->input('sobrenome'),
            'cargo' => 'Administrador',
            'email' => $request->input('email'),
            'cnpj' => $request->input('cnpj'), // Certifique-se de que o nome do campo está correto
            'senha' => Hash::make($request->input('senha')),
        ]);

        // Redirecionamento após o cadastro
        if ($funcionario) {
            return redirect('cadastroConcluido')->with('success', 'Cadastro realizado com sucesso!');
        } else {
            return view('index/inicio');
        }
    }

}
