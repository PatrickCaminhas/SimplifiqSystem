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
        'categoria_id',
        'unidade_medida',
        'medida',
        'descricao',
        'quantidade',
        'ultimo_fornecedor',
        'preco_compra',
        'preco_venda',
        'desconto_maximo',
    ];
    public function itensVenda()
    {
        return $this->hasMany(Itens_venda::class);
    }
    public function itensCotacoes()
    {
        return $this->hasMany(Itens_cotacoes::class);
    }
    public function estoque()
    {
        return $this->hasMany(Estoque::class, 'id_produto');
    }
    public function fornecedores()
    {
        return $this->belongsToMany(Fornecedores::class, 'produtos_fornecedores', 'produto_id', 'fornecedor_id');
    }
    public function vendas()
    {
        return $this->hasManyThrough(Vendas::class, Itens_venda::class, 'produto_id', 'id', 'id', 'venda_id');
    }

    public function categoria()
    {
        // Defina o relacionamento correto, onde 'categoria' é a chave estrangeira na tabela 'produtos'
        return $this->belongsTo(Produtos_categoria::class, 'categoria_id', 'id');
    }
}
