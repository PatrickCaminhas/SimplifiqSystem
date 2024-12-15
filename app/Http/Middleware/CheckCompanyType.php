<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Empresa_information; // Add this line to import the 'EmpresaInformation' class
use App\Services\AdministradorService;

class CheckCompanyType
{

    protected $administradorService;

    // Injeção de dependência para o serviço do administrador
    public function __construct(AdministradorService $administradorService)
    {
        $this->administradorService = $administradorService;
    }
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
        $empresa = Empresa_information::first();

        if ($empresa) {
            View::share('empresa', $empresa->nome);
            View::share('menu', $empresa->tipo_empresa);
            View::share('padrao_cores', $empresa->padrao_cores);
            View::share('tamanho_empresa', $empresa->tamanho_empresa);


            $administrador = $this->administradorService->privilegiosAdministrativos();
            View::share('Administrador', $administrador);

            $request->merge(['tamanho_empresa' => $empresa->tamanho_empresa]);

        } else {
            View::share('menu', 'not found');
        }

        return $next($request);
    }
}
