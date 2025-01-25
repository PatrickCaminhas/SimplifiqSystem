<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reparticao_tributos extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'cpp',
        'csll',
        'icms',
        'irpj',
        'cofins',
        'faixa',
        'pis_pasep',

    ];
}
