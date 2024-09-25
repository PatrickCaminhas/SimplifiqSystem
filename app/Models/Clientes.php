<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nome',
        'cpfOuCnpj',
        'telefone',
        'email',
        'endereco_completo',
        'debitos',
        'observacoes',
    ];

    public function vendas()
{
    return $this->hasMany(Vendas::class, 'cliente_id');
}
}
