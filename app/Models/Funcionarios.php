<?php

namespace App\Models;

use App\Notifications\RedefinirSenhaNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\ResetPasswordNotification;
use App\Models\Empresa_information;

class Funcionarios extends Authenticatable implements JWTSubject
{
    use HasFactory,  Notifiable;

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



    public function empresa()
    {
        return $this->belongsTo(Empresas::class, 'cnpj');  // Associa a chave estrangeira empresa_id
    }
    public function getAuthPassword()
    {
        return $this->senha;
    }
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Retorna a chave primária do modelo
    }

    public function getJWTCustomClaims()
    {
        return []; // Retorna um array de claims customizadas (opcional)
    }

    public function sendPasswordResetNotification($token)
    {
        $dominio = tenant('id');

        $this->notify( new RedefinirSenhaNotification($token, $this->email,$this->nome,$dominio) );
    }
}
