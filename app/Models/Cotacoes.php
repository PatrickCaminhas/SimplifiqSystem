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
    public function itens()
    {
        return $this->hasMany(Itens_cotacoes::class, 'id_cotacao');
    }

}
