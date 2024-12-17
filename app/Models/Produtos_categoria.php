<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produtos_categoria extends Model
{
    use HasFactory;
        // Define o nome da tabela para evitar a convenção plural
        protected $table = 'produtos_categoria';

    protected $fillable = [
        'nome', // Não precisa incluir 'id'
    ];

    /**
     * Relacionamento com produtos.
     */
    public function produtos()
    {
        // A chave estrangeira é 'categoria' na tabela 'produtos'
        return $this->hasMany(Produtos::class, 'categoria');
    }
}
