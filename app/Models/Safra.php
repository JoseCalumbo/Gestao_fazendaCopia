<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Safra extends Model
{
    protected $fillable = [
        'cooperativa_id',
        'nome',
        'ano',
        'data_inicio',
        'data_fim',
        'safra_actual',
        'estado',
        'descricao',
    ];

    public function cooperativa()
    {
        return $this->belongsTo(Cooperativa::class);
    }
}
