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
            return redirect('/');
        }

        return $next($request);
    }
}
