<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\Empresas;
use App\Models\Funcionarios;
use App\Models\Empresa_information;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\AuxiliarService;
use phpDocumentor\Reflection\Types\Integer;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Facades\Tenancy;
use App\Models\Tenant;

class CadastroController extends Controller
{
    private $cadastroService;

    public function __construct(AuxiliarService $cadastroService)
    {
        $this->cadastroService = $cadastroService;
    }

    public function create()
    {
        return view('index.cadastroDeEmpresa');
    }
    public function cadastroConcluido()
    {
        return view('index.cadastroEmpresaConcluido');
    }
    public function store(Request $request)
    {
        // Validação dos dados
        $this->ValidarEmpresa($request);
        $this->ValidarFuncionario($request);
        // Verificando e criar a empresa
        $empresa = $this->createEmpresa($request);
        if (!$empresa) {
            return redirect()->back()->withErrors([
                'cnpj' => 'O CNPJ fornecido já está cadastrado.',
            ]);
        }
        $idFuncionario = $this->cadastroService->generateUniqueFuncionarioId();
        // Gerar ID único para o funcionário

        // Criar o funcionário
        $request->merge(['cargo' => "Administrador"]);
        $funcionario = $this->createFuncionarioGlobal($request, $idFuncionario);

        // Redirecionamento após o cadastro
        if ($funcionario) {
            return redirect('cadastroConcluido')->with('success', 'Cadastro realizado com sucesso!');
        }

        return view('index.inicio');
    }

    private function ValidarEmpresa($request)
    {
        $request->validate([
            'nomeempresa' => 'required|string',
            'cnpj' => 'required|string',
            'tamanhoempresa' => 'required|string',
            'tipoempresa' => 'required|string',
            'telefone' => 'required|string',
            'data_de_criacao => required|date',
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
        Empresa_information::create([
            'nome' => $request->input('nomeempresa'),
            'cnpj' => $request->input('cnpj'),
            'tamanho_empresa' => $request->input('tamanhoempresa'),
            'tipo_empresa' => $request->input('tipoempresa'),
            'telefone' => $request->input('telefone'),
            'data_de_criacao' => $request->input('data_de_criacao'),
            'estado' => 'ativa',
            'padrao_cores' => 'azul',
        ]);
        return Empresas::create([
            'nome' => $request->input('nomeempresa'),
            'cnpj' => $request->input('cnpj'),
            'area_atuacao' => $areaAtuacao,
            'tamanho_empresa' => $request->input('tamanhoempresa'),
            'tipo_empresa' => $request->input('tipoempresa'),
            'telefone' => $request->input('telefone'),
            'data_de_criacao' => $request->input('data_de_criacao'),
            'estado' => 'ativa',
        ]);

    }


    public function generateUniqueFuncionarioId()
    {
        do {
            $id = mt_rand(100, 99999);
        } while (Funcionarios::on('mysql')->where('id', $id)->exists());
        return $id;
    }

    // Criar o funcionário
    private function createFuncionarioGlobal($request, $idFuncionario)
    {
            //Se foi informado CNPJ o usuario é o administrador no momento da criação da empresa

            return Funcionarios::on('mysql')->create([
                'id' => $idFuncionario,
                'nome' => $request->input('nome'),
                'sobrenome' => $request->input('sobrenome'),
                'cargo' => $request->input('cargo'),
                'email' => $request->input('email'),
                'cnpj' => $request->input('cnpj'),
                'senha' => Hash::make($request->input('senha')),
            ]);

            //Se não foi informado CNPJ o usuario é usuario de uma empresa existente
    }
    private function createNovoFuncionarioTenant($request, $idFuncionario)
    {
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


    public function cadastrarNovoFuncionarioEmpresaExiste(Request $request)
    {
        $this->ValidarFuncionario($request);
        $idFuncionario = 0;

        $senha = strtoupper(substr($request->input('nome'), 0, 3) . substr($request->input('sobrenome'), 0, 3) . '12');
        $empresa = null;

        // *** Inserir funcionário no escopo global ***
        DB::beginTransaction();
        try {


            // Busca a empresa do tenant

            $empresa = Empresa_information::on('mysql')->first();


            // Gerar ID único para o funcionário
            $idFuncionario = $this->generateUniqueFuncionarioId();
            $request->merge(['senha' => $senha, 'cnpj' => $empresa->cnpj]);
            $funcionario = $this->createFuncionarioGlobal($request, $idFuncionario);

            // Reativa o tenant atual

            DB::commit(); // Confirma a transação

        } catch (\Exception $e) {
            DB::rollback(); // Reverte a transação em caso de erro
            return redirect()->back()->withErrors(['success' => 'Erro ao cadastrar o funcionário: ' . $e->getMessage()]);
        }



        // *** Inserir funcionário no tenant ***


        if ($funcionario) {
            return redirect()->back()->with('success' , 'Cadastro realizado com sucesso!');
        }

        return view('sistema.dashboard');
    }




}
