<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Funcionarios extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nome',
        'sobrenome',
        'email',
        'cnpj',
        'senha',
        'cargo',
    ];

    protected $hidden = [
        'senha',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
