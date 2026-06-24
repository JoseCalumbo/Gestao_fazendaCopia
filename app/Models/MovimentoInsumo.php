<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimentoInsumo extends Model
{
    protected $table = 'movimento_insumos';

    protected $fillable = [
        'cooperativa_id',
        'insumo_id',
        'agricultor_id',
        'tipo',
        'quantidade',
        'modalidade',
        'estado',
    ];

    public function cooperativa()
    {
        return $this->belongsTo(Cooperativa::class);
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class);
    }

    public function agricultor()
    {
        return $this->belongsTo(Agricultor::class);
    }
}