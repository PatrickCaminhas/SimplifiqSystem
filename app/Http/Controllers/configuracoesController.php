<?php

namespace App\Http\Controllers;

use App\Models\Empresa_information;
use App\Models\Empresas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Funcionarios;
use App\Http\Controllers\Auth\CadastroController;

class ConfiguracoesController extends Controller
{
    /**
     * Retorna a view de configurações do usuário.
     */
    public function createConfiguracoes()
    {
        $status_cadastro = $this->verificarFuncionario();
        return view('sistema.configuracoes.configuracaoUsuario', ['page' => 'Configurações', 'cadastro_funcionario' => $status_cadastro]);
    }

    /**
     * Retorna a view com a lista de funcionários.
     */
    public function createListaFuncionarios()
    {
        $funcionarios = Funcionarios::all();
        return view('sistema.configuracoes.listaFuncionarios', ['page' => 'Configurações', 'funcionarios' => $funcionarios]);
    }

    /**
     * Retorna a view de alteração de senha.
     */
    public function createAlterarSenha()
    {
        return view('sistema.configuracoes.alterarSenha', ['page' => 'Configurações']);
    }

    /**
     * Retorna a view de alteração de dados pessoais.
     */
    public function createAlteraDadosPessoais()
    {
        $idUsuario = auth()->id();
        $funcionario = Funcionarios::find($idUsuario);
        return view('sistema.configuracoes.alterarDadosPessoais', ['page' => 'Configurações', 'funcionario' => $funcionario]);
    }

    /**
     * Retorna a view para alteração de cargos.
     */
    public function createAlterarCargos()
    {
        $usuarioAtual = auth()->user();
        if (in_array($usuarioAtual->cargo, ['Administrador', 'Gerente', 'Proprietario'])) {
            $funcionarios = Funcionarios::where('id', '!=', $usuarioAtual->id)->get();
            return view('sistema.configuracoes.alterarCargos', ['page' => 'Configurações', 'funcionarios' => $funcionarios]);
        }
        return redirect()->back()->with('error', 'Você não tem permissão para acessar essa página!');
    }

    /**
     * Retorna a view para exclusão de funcionários.
     */
    public function createExcluirFuncionario()
    {
        $usuarioAtual = auth()->user();
        if (in_array($usuarioAtual->cargo, ['Administrador', 'Gerente', 'Proprietario'])) {
            $funcionarios = Funcionarios::where('id', '!=', $usuarioAtual->id)->get();
            return view('sistema.configuracoes.excluirFuncionario', ['page' => 'Configurações', 'funcionarios' => $funcionarios]);
        }
        return redirect()->back()->with('error', 'Você não tem permissão para acessar essa página!');
    }

    /**
     * Retorna a view de cadastro de funcionário, verificando se a empresa permite.
     */
    public function createCadastroFuncionario()
    {
        $status_cadastro = $this->verificarFuncionario();
        if ($status_cadastro == 'negado') {
            return redirect('configuracoes')->with('error', 'Limite de funcionários atingido!');
        }
        return view('sistema.configuracoes.cadastrarFuncionario', ['page' => 'Configurações', 'cadastro_funcionario' => $status_cadastro]);
    }

    /**
     * Verifica se a empresa pode cadastrar mais funcionários.
     */
    public function verificarFuncionario()
    {
        $status_cadastro = 'permitido';
        $empresa = Empresa_information::first();
        $quantidade_funcionarios = Funcionarios::count();

        $limites = [
            'mei' => 2,
            'microempresa_comercio_servicos' => 10,
            'microempresa_industria' => 20,
            'pequenaempresa_comercio_servicos' => 49,
            'pequenaempresa_industria' => 99,
        ];

        $tipo_empresa = $empresa->tamanho_empresa . '_' . strtolower(str_replace(' ', '_', $empresa->tipo_empresa));

        if (isset($limites[$tipo_empresa]) && $quantidade_funcionarios >= $limites[$tipo_empresa]) {
            $status_cadastro = 'negado';
        }

        return $status_cadastro;
    }

    /**
     * Exclui um funcionário do sistema.
     */
    public function excluirFuncionario(Request $request)
    {
        Funcionarios::where('id', $request->input('funcionario'))->delete();
        return redirect()->back()->with('success', 'Funcionário excluído do sistema com sucesso!');
    }

    /**
     * Altera os dados pessoais do usuário autenticado.
     */
    public function alterarDadosPessoais(Request $request)
    {
        $request->validate([
            'nome' => 'string',
            'sobrenome' => 'string',
            'email' => 'email',
        ]);

        Funcionarios::where('id', auth()->id())->update($request->only(['nome', 'sobrenome', 'email']));

        return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
    }

    /**
     * Altera o cargo de um funcionário.
     */
    public function alterarCargos(Request $request)
    {
        $request->validate([
            'cargo' => 'required|string',
        ]);

        Funcionarios::where('id', $request->input('funcionario'))->update(['cargo' => $request->input('cargo')]);

        return redirect()->back()->with('success', 'Cargo alterado com sucesso!');
    }

    /**
     * Altera a senha do usuário autenticado.
     */
    public function alterarSenha(Request $request)
    {
        $request->validate([
            'senhaantiga' => 'required|string',
            'novasenha' => 'required|string|min:8',
            'confirmasenhanova' => 'required|string|same:novasenha',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->input('senhaantiga'), $user->senha)) {
            return redirect()->back()->with('error', 'A senha antiga está incorreta.');
        }

        Funcionarios::where('id', $user->id)->update(['senha' => Hash::make($request->input('novasenha'))]);

        return redirect()->back()->with('success', 'Senha alterada com sucesso!');
    }
}
