<?php
namespace App\Services;
use App\Models\Funcionarios;

class AuxiliarService {

    public function generateUniqueFuncionarioId()
    {
        do {
            $id = mt_rand(100, 99999);
        } while (Funcionarios::where('id', $id)->exists());
        return $id;
    }
}
