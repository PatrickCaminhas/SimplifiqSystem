<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Funcionarios;
use App\Models\Empresas;


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

        $empresas = Empresas::all();

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

        return redirect('/');
    }
}
