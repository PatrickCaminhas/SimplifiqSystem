<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicos extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nome',
        'nome_cliente',
        'identificacao_cliente',
        'tipo_cliente',
        'valor',
        'tipo_servico',
        'data_inicio',
        'data_fim',
        'estado',
        'descricao',
    ];
    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }
    public function tipo()
    {
        return $this->belongsTo(ServicosTipo::class, 'tipo_id');
    }
}
