<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendas extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'cliente_id',
        'data_venda',
        'valor_total',
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function itens()
    {
        return $this->hasMany(Itens_venda::class);
    }
}
