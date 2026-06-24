<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoEstoque extends Model
{
    //use HasFactory;

    protected $table = 'historico_estoques';

 protected $fillable = [
    'cooperativa_id',
    'insumo_id',
    'agricultor_id', // <-- Adiciona aqui
    'movimento_id',
    'tipo_movimento',
    'quantidade',
    'stock_anterior',
    'stock_atual',
    'utilizador',
    'observacao'
];

// Adiciona o relacionamento com o Agricultor
public function agricultor()
{
    return $this->belongsTo(Agricultor::class, 'agricultor_id');
}

    // RELACIONAMENTO: O histórico pertence a um Insumo
    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'insumo_id');
    }

    // RELACIONAMENTO: O histórico pertence a uma Cooperativa
    public function cooperativa()
    {
        return $this->belongsTo(Cooperativa::class, 'cooperativa_id');
    }

    // ─── ADICIONA ESTA RELAÇÃO COM O MOVIMENTO ───
    public function movimento()
    {
        return $this->belongsTo(MovimentoInsumo::class, 'movimento_id');
    }
}


