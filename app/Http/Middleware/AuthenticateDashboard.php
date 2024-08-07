<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateDashboard
{
    public function handle(Request $request, Closure $next)
    {

        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            // Se não estiver autenticado, redireciona para a rota de login
            return redirect()->route('login');
        }

        // Verifica se o usuário autenticado é nulo antes de acessar o ID
        if (auth()->user() === null) {
            return redirect()->route('login');
        }

        // Adiciona a variável de usuário no request para o próximo middleware/rota
        $userId = auth()->user()->id;

        return $next($request);
    }
}
