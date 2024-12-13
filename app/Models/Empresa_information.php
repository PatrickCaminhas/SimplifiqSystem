<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa_information extends Model
{
    use HasFactory;
    protected $fillable = [
        'cnpj',
        'nome',
        'tamanho_empresa',
        'tipo_empresa',
        'area_atuacao',
        'telefone',
        'estado',
        'padrao_cores',
        'dominio',
    ];
    public function funcionarios()
    {
        return $this->hasMany(Funcionarios::class);  // A empresa tem muitos funcionários
    }

}
