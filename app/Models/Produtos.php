<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nome',
        'marca',
        'modelo',
        'categoria',
        'unidade_medida',
        'medida',
        'descricao',
        'quantidade',
        'ultimo_fornecedor',
        'preco_compra',
        'preco_venda',
    ];
    public function itensVenda()
    {
        return $this->hasMany(Itens_venda::class);
    }
}
