<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacoes extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'mensagem',
        'remetente',
        'destinatario',
        'created_at',
        'lido',
    ];
}
