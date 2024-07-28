<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contas extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'credor',
        'valor',
        'tipo',
        'data_vencimento',
        'data_pagamento',
        'estado',


    ];
}
