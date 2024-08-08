<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_servico extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nome',
        'categoria',
        'duracao',
        'materiais_necessarios',
        'quantidade_de_pessoas',
        'valor',
        'descricao',
    ];
}
