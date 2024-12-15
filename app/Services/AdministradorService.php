<?php
namespace App\Services;
use App\Models\Funcionarios;

class AdministradorService {

    public function privilegiosAdministrativos()
    {
        $usuarioAtual = auth()->user();
        if ($usuarioAtual->cargo == 'Administrador' || $usuarioAtual->cargo == 'Gerente' || $usuarioAtual->cargo == 'Proprietario') {
            return true;
        } else {
            return false;
        }
    }
}
