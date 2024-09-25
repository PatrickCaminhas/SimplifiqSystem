<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itens_cotacoes extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cotacao',
        'produto_id',
        'preco',
        'fornecedor_id',
    ];

    public function produto()
    {
        return $this->belongsTo(Produtos::class, 'produto_id');
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedores::class, 'fornecedor_id');
    }

    public function cotacao()
    {
        return $this->belongsTo(Cotacoes::class, 'cotacao_id');
    }
}
