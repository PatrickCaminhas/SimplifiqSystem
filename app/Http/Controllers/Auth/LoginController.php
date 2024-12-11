<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Funcionarios;
use App\Models\Empresas;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;


class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        $empresa = $request->input('empresa');
        $domain = $empresa . '.localhost';
        if ($empresa) {
            echo $domain;
            return redirect()->away('http://' . $domain . ':8000/login');
        }


        return redirect()->away('http://localhost:8000/empresas');
    }

    public function buscar(Request $request)
    {
        $termo = $request->input('query');
        $empresas = Empresas::where('nome', 'LIKE', "%{$termo}%")->limit(10)->get();

        return response()->json($empresas);
    }
    private function sanitizeString($string)
    {
        $string = trim($string); // Remove espaços em branco do início e do fim
        $string = str_replace(
            ['ç', 'ã', 'õ', 'á', 'é', 'í', 'ó', 'ú', 'â', 'ê', 'î', 'ô', 'û', 'à', 'è', 'ì', 'ò', 'ù', 'ä', 'ë', 'ï', 'ö', 'ü', 'ñ'],
            ['c', 'a', 'o', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'n'],
            $string
        ); // Substitui caracteres especiais
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Remove caracteres especiais
        $string = preg_replace('/\s+/', '', $string); // Remove espaços em branco no meio

        return strtolower($string);
    }
    public function showLoginFormTenant()
    {
        return view('index.login');
    }
    public function showEmpresas()
    {

        $empresas = Empresas::all()->where('estado', 'ativa');

        // Sanitiza o nome de cada empresa
        $empresasSanitizadas = [];
        foreach ($empresas as $empresa) {
            $empresa->nome = $this->sanitizeString($empresa->nome);
            $empresasSanitizadas[] = $empresa;
        }

        if ($empresasSanitizadas) {
            return view('index.empresas', ['empresas' => $empresasSanitizadas]);
        } else {
            return redirect('index.empresas')->with('error', 'Empresa não encontrada.');
        }
    }

    public function showEmpresas2()
    {

        $empresas = Empresas::all()->where('estado', 'ativa');

        // Sanitiza o nome de cada empresa
        $empresasSanitizadas = [];
        foreach ($empresas as $empresa) {
            $empresa->nome = $this->sanitizeString($empresa->nome);
            $empresasSanitizadas[] = $empresa;
        }

        if ($empresasSanitizadas) {
            return view('index.empresas2');
        } else {
            return redirect('index.empresas')->with('error', 'Empresa não encontrada.');
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Tentar autenticar o usuário
        $funcionario = Funcionarios::where('email', $credentials['email'])->first();

        if ($funcionario && Hash::check($credentials['password'], $funcionario->senha)) {

            Auth::login($funcionario);
            session(['funcionario' => $funcionario]);
            return redirect()->intended('dashboard');
        }
        if ($funcionario) {
            return redirect()->back()->withErrors([
                'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
            ]);
        } else {
            return redirect()->back()->withErrors([
                'email' => 'O e-mail fornecido não corresponde aos nossos registros.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
/*
    public function centralLogin(Request $request)
    {
        // Valida os dados de entrada
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        // Tenta autenticar o usuário
           $funcionario = Funcionarios::where('email', $request['email'])->first();
           if ($funcionario) {
               $subdominio = $this->sanitizeString($funcionario->empresa->nome);
               return redirect()->away('http://' . $subdominio . '.localhost:8000/handle-login?email=' . $request['email'] . '&senha=' . $request['senha'])
               ->with('email', $request['email'])->with('senha', $request['senha']);
           }



        $funcionario = Funcionarios::where('email', $request['email'])->first();


        if ($funcionario) {
            $subdominio = $this->sanitizeString($funcionario->empresa->nome);
            $url = 'http://' . $subdominio . '.localhost:8000/handle-login';

            // Envia os dados via POST para o subdomínio
            $response = Http::post($url, [
                'email' => $request['email'],
                'senha' => $request['senha'],
            ]);

            // Processa a resposta
            if ($response->successful()) {
                // Redireciona ou lida com a resposta do tenant
                return redirect()->route('tenant.dashboard');
            } else {
                return redirect()->route('login')->withErrors(['message' => 'Falha ao enviar dados ao tenant']);
            }
        }
    }



    public function handleSubdomainLogin(Request $request)
    {



        // Autentica o funcionário no subdomínio
        $funcionario = Funcionarios::where('email', $request['email'])->first();

        if ($funcionario && Hash::check($request['senha'], $funcionario->senha)) {
            Auth::login($funcionario);
            return redirect()->intended('dashboard'); // Redireciona para o dashboard do subdomínio
        } elseif ($funcionario) {
            return redirect()->away('http://localhost:8000/login3')->withErrors([
                'email' => 'Senha incorreta.'
            ]);
        }
        return redirect()->away('http://localhost:8000/login3')->withErrors([
            'email' => 'E-mail incorreto.',
        ]);
    }


    public function login3()
    {
        return view('index.login3');
    }
    public function redirectPost()
    {
        return view('index.redirect-post');
    }*/

}
