<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'tamanho_empresa',
        'tipo_empresa',
        'telefone',
    ];

    protected $hidden = [
        'senha',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
