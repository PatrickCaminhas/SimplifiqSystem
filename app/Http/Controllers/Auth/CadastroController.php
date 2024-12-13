<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Empresas;
use App\Models\Funcionarios;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\AuxiliarService;
use phpDocumentor\Reflection\Types\Integer;
use Stancl\Tenancy\Facades\Tenancy;

class CadastroController extends Controller
{
    private $cadastroService;

    public function __construct(AuxiliarService $cadastroService)
    {
        $this->cadastroService = $cadastroService;
    }

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
        $this->ValidarFuncionario($request);
        // Verificar e criar a empresa
        $empresa = $this->createEmpresa($request);
        if (!$empresa) {
            return redirect()->back()->withErrors([
                'cnpj' => 'O CNPJ fornecido já está cadastrado.',
            ]);
        }
        $idFuncionario = $this->cadastroService->generateUniqueFuncionarioId();
        // Gerar ID único para o funcionário

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
    private function ValidarFuncionario($request)
    {
        if ($request->input('cnpj') == null) {
            $request->validate([
                'nome' => 'required|string',
                'sobrenome' => 'required|string',
                'cargo' => 'required|string',
                'email' => 'required|string|email|unique:funcionarios,email',
                'senha' => 'required|string|min:8',
            ]);
        } else {
            $request->validate([
                'nome' => 'required|string',
                'sobrenome' => 'required|string',
                'cnpj' => 'required|string',
                'email' => 'required|string|email|unique:funcionarios,email',
                'senha' => 'required|string|min:8',
            ]);
        }
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



    // Criar o funcionário
    private function createFuncionario($request, $idFuncionario)
    {
        if ($request->input('cnpj') != null) {
            //Se foi informado CNPJ o usuario é o administrador no momento da criação da empresa
            $cargo = 'Administrador';
            return Funcionarios::create([
                'id' => $idFuncionario,
                'nome' => $request->input('nome'),
                'sobrenome' => $request->input('sobrenome'),
                'cargo' => $cargo,
                'email' => $request->input('email'),
                'cnpj' => $request->input('cnpj'),
                'senha' => Hash::make($request->input('senha')),
            ]);
        } else {
            //Se não foi informado CNPJ o usuario é usuario de uma empresa existente

            $cargo = $request->input('cargo');
            return Funcionarios::create([
                'id' => $idFuncionario,
                'nome' => $request->input('nome'),
                'sobrenome' => $request->input('sobrenome'),
                'cargo' => $cargo,
                'email' => $request->input('email'),
                'senha' => Hash::make($request->input('senha')),
            ]);
        }

    }

    private function cadastrarNovoFuncionarioEmpresaExiste(Request $request)
    {
        $this->ValidarFuncionario($request);
        $idFuncionario = new Integer();

        // *** Inserir funcionário no escopo global ***
        Tenancy::setTenant(null); // Desativa temporariamente o tenant atual
        try {
            $idFuncionario = $this->cadastroService->generateUniqueFuncionarioId();

            $funcionario = $this->createFuncionario($request, $idFuncionario);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao cadastrar o funcionário no escopo global: ' . $e->getMessage()]);
        } finally {
            Tenancy::setTenant($funcionario->empresa); // Reativa o tenant atual
        }


    }

}
