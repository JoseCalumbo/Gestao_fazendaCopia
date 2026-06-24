<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';

    protected $fillable = [
        'nome',
        'descricao',
        'tipo',
        'quantidade',
        'stock_minimo',
        'unidade',
        'preco_unitario',
        'data_entrada',
        'estado',
        'cooperativa_id',
    ];

    protected $casts = [
        'quantidade' => 'decimal:2',
        'stock_minimo' => 'decimal:2',
        'preco_unitario' => 'decimal:2',
        'data_entrada' => 'date',
    ];

    // relação insumos_cooperativa
    public function cooperativa()
    {
        return $this->belongsTo(Cooperativa::class);
    }

    public function movimentoInsumos()
    {
        return $this->hasMany(MovimentoInsumo::class);
    }
}
