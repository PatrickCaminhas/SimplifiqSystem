<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itens_venda extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'venda_id',
        'produto_id',
        'quantidade',
        'preco_unitario',
        'subtotal',
    ];
    public function produto()
    {
        return $this->belongsTo(Produtos::class);
    }
    public function venda()
    {
        return $this->belongsTo(Vendas::class);
    }

}
