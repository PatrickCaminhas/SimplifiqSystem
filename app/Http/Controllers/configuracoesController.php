<?php

namespace App\Http\Controllers;

use App\Models\Empresa_information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Funcionarios;

class configuracoesController extends Controller
{
    public function createConfiguracoes()
    {
        $status_cadastro = $this->verificarFuncionario();
        return view('sistema.configuracoes.configuracaoUsuario',['page'=>'configuracoes'], ['cadastro_funcionario'=>$status_cadastro]);
    }
    public function verificarFuncionario(){
        $status_cadastro = 'permitido';
        $empresa = Empresa_information::first();
        $quantidade_funcionarios = Funcionarios::all()->count();
        if($quantidade_funcionarios == 2 && $empresa->tamanho_empresa == "mei"){
            $status_cadastro = 'negado';
        }
        if($quantidade_funcionarios == 10 && $empresa->tamanho_empresa == "microempresa" && ($empresa->tipo_empresa == "Comércio" || $empresa->tipo_empresa == "Serviços")){
            $status_cadastro = 'negado';
        }
        if($quantidade_funcionarios == 20 && $empresa->tamanho_empresa == "microempresa" && $empresa->tipo_empresa == "Indústria"){
            $status_cadastro = 'negado';
        }
        if($quantidade_funcionarios == 49 && $empresa->tamanho_empresa == "pequenaempresa" && ($empresa->tipo_empresa == "Comércio" || $empresa->tipo_empresa == "Serviços")){
            $status_cadastro = 'negado';
        }
        if($quantidade_funcionarios == 99 && $empresa->tamanho_empresa == "pequenaempresa" && $empresa->tipo_empresa == "Indústria"){
            $status_cadastro = 'negado';
        }
        return $status_cadastro;
    }

    public function createAlterarSenha()
    {
        return view('sistema.configuracoes.alterarSenha',['page'=>'configuracoes']);
    }

    public function createCadastroFuncionario()
    {
        $status_cadastro = $this->verificarFuncionario();
        if($status_cadastro == 'negado'){
            return redirect('configuracoes')->with('error', 'Limite de funcionários atingido!');
        }
        else{
        return view('sistema.configuracoes.cadastrarFuncionario',['page'=>'configuracoes'], ['cadastro_funcionario'=>$status_cadastro]);
        }
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
