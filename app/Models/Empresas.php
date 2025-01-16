<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Domain;

class Empresas extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'cnpj'; // Define a chave primária como 'cnpj'
    public $incrementing = false;   // Desativa incremento automático, já que CNPJ não é um número sequencial
    protected $keyType = 'string'; // Define que a chave primária é uma string
    protected $fillable = [
        'nome',
        'cnpj',
        'tamanho_empresa',
        'tipo_empresa',
        'telefone',
        'estado',
        'padrao_cores',
        'tenant',
        'dominio',
    ];

    public function funcionarios()
    {
        return $this->hasMany(Funcionarios::class);  // A empresa tem muitos funcionários
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);  // A empresa pertence a um tenant
    }
    public function getDomain()
    {
        $domain = Domain::find($this->dominio);
        return $domain->domain;
    }
}
