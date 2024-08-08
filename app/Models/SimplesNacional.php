<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimplesNacional extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nome_anexo',
        'faixa_anexo',
        'receita_bruta_anual',
        'aliquota',
        'deducao',

    ];
}
