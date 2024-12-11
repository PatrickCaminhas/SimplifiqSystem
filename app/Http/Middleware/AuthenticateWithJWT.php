<?php
namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateWithJWT
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token invalido ou ausente'], 401);
        }

        // Verifica o tenant associado
        if (!$this->isValidTenant($user)) {
            return response()->json(['error' => 'Acesso negado ao tenant'], 403);
        }

        $request->merge(['user' => $user]);

        return $next($request);
    }

    private function isValidTenant($user)
    {
        $tenant = tenant();
        return $tenant && $tenant->id === $user->tenant_id;
    }
}

