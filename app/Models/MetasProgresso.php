<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetasProgresso extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'meta_id',
        'valor',
    ];
}
