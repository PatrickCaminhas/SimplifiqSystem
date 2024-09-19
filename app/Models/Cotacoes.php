<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotacoes extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_cotacao',
        'produto_id',
        'preco',
        'fornecedor_id'
    ];
    // Em Cotacoes.php
    public function produto()
    {
        return $this->belongsTo(Produtos::class, 'produto_id');
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedores::class, 'fornecedor_id');
    }

}
