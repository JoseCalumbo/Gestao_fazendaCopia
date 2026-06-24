<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talhao extends Model
{
    protected $table = 'talhoes';

    protected $fillable = [
        'designacao',
        'area',
        'cultura_actual',
        'localizacao',
        'estado',
        'agricultor_id',
        'cooperativa_id',
    ];

    protected $casts = [
        'area' => 'decimal:2',
    ];

    public function agricultor()
    {
        return $this->belongsTo(Agricultor::class);
    }

    public function cooperativa()
    {
        return $this->belongsTo(Cooperativa::class, 'cooperativa_id');
    }
}
