<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Funcionarios;

class ConfiguracoesController extends Controller
{
    public function createConfiguracoes()
    {
        return view('configuracoes.configuracaoUsuario');
    }

    public function createAlterarSenha()
    {
        return view('configuracoes.alterarSenha');
    }

    public function createCadastroFuncionario()
    {
        return view('configuracoes.cadastrarFuncionario');
    }
     
    public function update(Request $request)
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
            return redirect('dashboard')->with('success', 'Senha alterada com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao alterar a senha.');
        }
    }

    public function storeFuncionario(Request $request){
        $request->validate([
            'nome' => 'required|string',
            'sobrenome' => 'required|string',
            'cargo' => 'required|string',
         
            'email' => 'required|string|email|unique:funcionarios,email',
        ]);
        do {
            $id_funcionario = mt_rand(100, 999);
        } while (Funcionarios::where('id', $id_funcionario)->exists());
        $user = Auth::user();
        $nome = $request->input('nome');
        $sobrenome = $request->input('sobrenome');
        $senha = strtoupper(substr($nome, 0, 3) . substr($sobrenome, 0, 3) . '12');
        $funcionario = Funcionarios::create([
            'id' => $id_funcionario,
            'nome' => $request->input('nome'),
            'sobrenome' => $request->input('sobrenome'),
            'cargo' => 'Administrador',
            'email' => $request->input('email'),
            'senha' => Hash::make($senha),
        ]);
        if ($funcionario) {
            return redirect('configuracoes')->with('success', 'Cadastro realizado com sucesso!');
        } else {
            return view('index/inicio');
        }
    }
    
}
