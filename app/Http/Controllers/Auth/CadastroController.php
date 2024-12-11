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
        $this->ValidarEmpresa($request);

        // Verificar e criar a empresa
        $empresa = $this->createEmpresa($request);
        if (!$empresa) {
            return redirect()->back()->withErrors([
                'cnpj' => 'O CNPJ fornecido já está cadastrado.',
            ]);
        }

        // Gerar ID único para o funcionário
        $idFuncionario = $this->generateUniqueFuncionarioId();

        // Criar o funcionário
        $funcionario = $this->createFuncionario($request, $idFuncionario);

        // Redirecionamento após o cadastro
        if ($funcionario) {
            return redirect('cadastroConcluido')->with('success', 'Cadastro realizado com sucesso!');
        }

        return view('index/inicio');
    }

    private function ValidarEmpresa($request)
    {
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
    }

    private function createEmpresa($request)
    {
        if (Empresas::where('cnpj', $request->input('cnpj'))->exists()) {
            return null;
        } // Se já existir retorna null

        $areaAtuacao = match ([$request->tamanhoempresa, $request->tipoempresa]) {
            ['MEI', 'comercio'] => "mei_comercio",
            ['MEI', 'comercioEservicos'] => "mei_servico",
            default => "anexo1",
        };

        return Empresas::create([
            'nome' => $request->input('nomeempresa'),
            'cnpj' => $request->input('cnpj'),
            'area_atuacao' => $areaAtuacao,
            'tamanho_empresa' => $request->input('tamanhoempresa'),
            'tipo_empresa' => $request->input('tipoempresa'),
            'telefone' => $request->input('telefone'),
            'estado' => 'inexistente',
        ]);
    }

    private function generateUniqueFuncionarioId()
    {
        do {
            $id = mt_rand(100, 999);
        } while (Funcionarios::where('id', $id)->exists());

        return $id;
    }

    // Criar o funcionário
    private function createFuncionario($request, $idFuncionario)
    {
        return Funcionarios::create([
            'id' => $idFuncionario,
            'nome' => $request->input('nome'),
            'sobrenome' => $request->input('sobrenome'),
            'cargo' => 'Administrador',
            'email' => $request->input('email'),
            'cnpj' => $request->input('cnpj'),
            'senha' => Hash::make($request->input('senha')),
        ]);
    }

}
