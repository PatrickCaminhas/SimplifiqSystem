<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoFaturamento extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'ano_mes',
        'renda_bruta',
    ];
}
