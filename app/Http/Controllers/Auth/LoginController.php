<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Funcionarios;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        
        return view('index\login');
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
        if($funcionario){
        return redirect()->back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }else{
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
