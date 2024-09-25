<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicosTipo extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nome',
        'duracao',
        'materiais',
        'quantidade_de_funcionarios',
        'valor_diario',
        'descricao',
    ];
    public function servicos()
    {
        return $this->hasMany(Servicos::class, 'tipo_id');
    }

}
