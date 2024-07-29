<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefas extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_servico',
        'nome',
        'funcionario_atribuido',
        'estado_tarefa',
        'data_inicio',
        'data_fim',
        'descricao',
        'observacoes',
    ];
}
