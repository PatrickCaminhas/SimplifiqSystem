<?php

namespace App\Http\Controllers;

use App\Models\Empresa_information;
use App\Models\Empresas;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Funcionarios;
use App\Http\Controllers\Auth\CadastroController;

class configuracoesController extends Controller
{

    public function createConfiguracoes()
    {
        $status_cadastro = $this->verificarFuncionario();
        return view('sistema.configuracoes.configuracaoUsuario', ['page' => 'configuracoes', 'cadastro_funcionario' => $status_cadastro]);
    }
    public function verificarFuncionario()
    {
        $status_cadastro = 'permitido';
        $empresa = Empresa_information::first();
        $quantidade_funcionarios = Funcionarios::all()->count();
        if ($quantidade_funcionarios == 2 && $empresa->tamanho_empresa == "mei") {
            $status_cadastro = 'negado';
        }
        if ($quantidade_funcionarios == 10 && $empresa->tamanho_empresa == "microempresa" && ($empresa->tipo_empresa == "Comércio" || $empresa->tipo_empresa == "Serviços")) {
            $status_cadastro = 'negado';
        }
        if ($quantidade_funcionarios == 20 && $empresa->tamanho_empresa == "microempresa" && $empresa->tipo_empresa == "Indústria") {
            $status_cadastro = 'negado';
        }
        if ($quantidade_funcionarios == 49 && $empresa->tamanho_empresa == "pequenaempresa" && ($empresa->tipo_empresa == "Comércio" || $empresa->tipo_empresa == "Serviços")) {
            $status_cadastro = 'negado';
        }
        if ($quantidade_funcionarios == 99 && $empresa->tamanho_empresa == "pequenaempresa" && $empresa->tipo_empresa == "Indústria") {
            $status_cadastro = 'negado';
        }
        return $status_cadastro;
    }

    public function createAlterarSenha()
    {
        return view('sistema.configuracoes.alterarSenha', ['page' => 'configuracoes']);
    }

    public function createAlteraDadosPessoais()
    {
        $idUsuario = auth()->id();
        $funcionario = Funcionarios::find($idUsuario);
        return view('sistema.configuracoes.alterarDadosPessoais', ['page' => 'configuracoes', 'funcionario' => $funcionario]);
    }

    public function createAlterarCargos()
    {
        $usuarioAtual = auth()->user();
        if ($usuarioAtual->cargo == 'Administrador' || $usuarioAtual->cargo == 'Gerente' || $usuarioAtual->cargo == 'Proprietario') {
            $funcionarios = Funcionarios::all();
            return view('sistema.configuracoes.alterarCargos', ['page' => 'configuracoes', 'funcionarios' => $funcionarios]);
        } else {
            return redirect()->back()->with('error', 'Você não tem permissão para acessar essa página!');
        }
    }

    public function createExcluirFuncionario()
    {
        $usuarioAtual = auth()->user();
        if ($usuarioAtual->cargo == 'Administrador' || $usuarioAtual->cargo == 'Gerente' || $usuarioAtual->cargo == 'Proprietario') {
            $funcionarios = Funcionarios::all();
            return view('sistema.configuracoes.excluirFuncionario', ['page' => 'configuracoes', 'funcionarios' => $funcionarios]);
        } else {
            return redirect()->back()->with('error', 'Você não tem permissão para acessar essa página!');
        }
    }

    public function excluirFuncionario(Request $request){
        Funcionarios::where('id', $request->input('funcionario'))->delete();
        return redirect()->back()->with('success','Funcionário excluído do sistema com sucesso!');
    }

    public function alterarDadosPessoais(Request $request)
    {
        $request->validate([
            'nome' => 'string',
            'sobrenome' => 'string',
            'email' => 'email',
        ]);
        $idUsuario = auth()->id();

        Funcionarios::where('id', $idUsuario)->update([
            'nome' => $request->input('nome'),
            'sobrenome' => $request->input('sobrenome'),
            'email' => $request->input('email'),
        ]);
        return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
    }

    public function alterarCargos(Request $request)
    {
        $request->validate([
            'cargo' => 'required|string',
        ]);
        Funcionarios::where('id', $request->input('funcionario'))->update([
            'cargo' => $request->input('cargo'),
        ]);

        return redirect()->back()->with('success','Cargo alterado com sucesso!');
    }

    public function createCadastroFuncionario()
    {
        $status_cadastro = $this->verificarFuncionario();
        if ($status_cadastro == 'negado') {
            return redirect('configuracoes')->with('error', 'Limite de funcionários atingido!');
        } else {
            return view('sistema.configuracoes.cadastrarFuncionario', ['page' => 'configuracoes'], ['cadastro_funcionario' => $status_cadastro]);
        }
    }

    public function alterarSenha(Request $request)
    {
        $request->validate([
            'senhaantiga' => 'required|string',
            'novasenha' => 'required|string|min:8',
            'confirmasenhanova' => 'required|string|same:novasenha',
        ]);

        // Obter o usuário logado
        $user = Auth::user();

        // Verificar se a senha antiga está correta
        if (!Hash::check($request->input('senhaantiga'), $user->senha)) {
            return redirect()->back()->with('error', 'A senha antiga está incorreta.');
        }

        // Atualizar a senha do usuário usando a classe Funcionarios
        $updated = Funcionarios::where('id', $user->id)->update([
            'senha' => Hash::make($request->input('novasenha')),
        ]);

        if ($updated) {
            return redirect()->back()->with('success', 'Senha alterada com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao alterar a senha.');
        }
    }





}
