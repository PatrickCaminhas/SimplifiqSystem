<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administradores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Empresas;


class AdministradoresController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('administracao.loginAdministrativo');
    }
    public function showDashboard()
    {
        $empresas=Empresas::all();
        return view('administracao.dashboardAdministracao',['empresas' => $empresas]);
    }
    public function showCadastroForm()
    {
        return view('administracao.cadastroDeAdministradores');
    }
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string',
            'sobrenome' => 'required|string',
            'email' => 'required|string|email|',
            'senha' => 'required|string|min:8',
        ]);
        do {
            $id_administrador = mt_rand(100, 999);
        } while (Administradores::where('id', $id_administrador)->exists());
        // Criando o administrador
        $administrador = Administradores::create([
            'id' => $id_administrador,
            'nome' => $request->input('nome'),
            'sobrenome' => $request->input('sobrenome'),
            'email' => $request->input('email'),
            'senha' => Hash::make($request->input('senha')),
        ]);
        if ($administrador) {
            return redirect('/')->with('success', 'Cadastro realizado com sucesso!');
        } else {
            return view('index.inicio');
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);
        $credentials = $request->only('email', 'senha');
        // Tentar autenticar o usuário
        $administrador = Administradores::where('email', $credentials['email'])->first();

        if ($administrador && Hash::check($credentials['senha'], $administrador->senha)) {

            Auth::login($administrador);
            session(['administrador' => $administrador]);
            return redirect()->intended('inicioAdministrador');
        }
        if ($administrador) {
            return redirect()->back()->withErrors([
                'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
            ]);
        } else {
            return redirect()->back()->withErrors([
                'email' => 'O e-mail fornecido não corresponde aos nossos registros.',
            ]);
        }
    }

    public function formularioLoginAdmin2(Request $request)
    {
        if (!$request->has('token')) {
            return redirect()->route(route: 'login')->withErrors(['error' => 'Token inválido.']);
        }
        $encryptedToken = $request->query('token');

        try {
            $decryptedData = Crypt::decryptString($encryptedToken);
            $data = json_decode($decryptedData, true);

            $email = $data['email'];
            $timestamp = $data['timestamp'];

            // Verificar se o token expirou (expira em 15 minutos, por exemplo)
            if (now()->timestamp - $timestamp > 300) { // 300 segundos = 5 minutos
                return redirect()->route('login')->json(['error' => 'Token expirado.'], 403);
            }
        } catch (\Exception $e) {
            return redirect()->route(route: 'login')->withErrors(['error' => 'Token inválido ou expirado.']);
        }

        return view('administracao.login3-2Admin', ['email' => $email]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/loginAdministrativo');
    }
}
