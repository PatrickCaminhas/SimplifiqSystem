<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Metas;

class CheckMetas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ajustar a query para considerar corretamente as condições
        $metas = Metas::where(function ($query) {
            $query->where('estado', 'Pendente')
                  ->orWhere('estado', 'Cumprida');
        })->where('ending_at', '<', now())->get();

        foreach ($metas as $meta) {
            if ($meta->valor_atual < $meta->valor) {
                $meta->estado = 'Não cumprida';
            } else if ($meta->valor_atual >= $meta->valor) {
                $meta->estado = 'Finalizada';
            }
            else if ($meta->valor_atual >= $meta->valor) {
                $meta->estado = 'Cumprida';
            }
            $meta->save();
        }

        return $next($request);
    }
}
