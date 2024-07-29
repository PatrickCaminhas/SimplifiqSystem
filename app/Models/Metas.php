<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metas extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'valor',
        'valor_atual',
        'ending_at',
    ];
}
