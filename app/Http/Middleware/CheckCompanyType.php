<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\EmpresaInformation; // Add this line to import the 'EmpresaInformation' class
use App\Models\Empresas;

class CheckCompanyType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Supondo que o usuário autenticado tem um relacionamento com a empresa
        $user = Auth::user();
        $empresa = EmpresaInformation::first();

        if ($empresa) {

            View::share('menu', $empresa->tipo_empresa);
            View::share('padrao_cores', $empresa->padrao_cores);

        } else {
            View::share('menu', 'not found');
        }

        return $next($request);
    }
}
