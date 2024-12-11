<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class EmpresaCadastro extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cnpj',
        'tamanho_empresa',
        'tipo_empresa',
        'area_atuacao',
        'telefone',
    ];

}
