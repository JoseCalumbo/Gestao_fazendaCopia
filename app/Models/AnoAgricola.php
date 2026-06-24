<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnoAgricola extends Model
{
    protected $table = 'anos_agricolas';

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'estado'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim'    => 'date'
    ];
}