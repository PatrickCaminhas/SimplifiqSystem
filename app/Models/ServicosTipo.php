<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicosTipo extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nome',
        'duracao',
        'materiais_necessarios',
        'quantidade_de_funcionarios',
        'valor_diario',
        'descricao',
    ];
}