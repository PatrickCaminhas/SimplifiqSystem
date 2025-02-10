<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;
    protected $table = 'estoque';
    protected $fillable = [
        'id_produto',
        'quantidade',
        'acao',
        'mes',
        'ano',
        'usuario',
    ];

    public function produto()
    {
        return $this->belongsTo(Produtos::class, 'id_produto');
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionarios::class, 'usuario');
    }
}
