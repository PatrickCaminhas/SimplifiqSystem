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
}
