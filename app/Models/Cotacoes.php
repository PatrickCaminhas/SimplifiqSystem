<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotacoes extends Model
{
    use HasFactory;
    protected $fillable = [
        'data_cotacao',
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
