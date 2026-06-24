<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = [
        'cooperativa_id',
        'agricultor_id',
        'data_venda',
        'cliente',
        'valor_total',
        'forma_pagamento',
        'observacoes'
    ];

    public function cooperativa()
    {
        return $this->belongsTo(Cooperativa::class);
    }

    public function agricultor()
    {
        return $this->belongsTo(Agricultor::class);
    }

    public function itens()
    {
        return $this->hasMany(VendaItem::class);
    }
}