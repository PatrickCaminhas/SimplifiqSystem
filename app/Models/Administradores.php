<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Administradores extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nome',
        'sobrenome',
        'email',
        'senha',
    ];

    protected $hidden = [
        'senha',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

}
