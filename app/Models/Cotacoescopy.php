<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Itens_cotacoes;

class Cotacoescopy extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_cotacao',
    ];

    public function itens()
    {
        return $this->hasMany(Itens_cotacoes::class, 'cotacao_id');
    }
}
