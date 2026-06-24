<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CooperativaMembro extends Model
{
    protected $table = 'cooperativa_membros';

    protected $fillable = [
        'cooperativa_id',
        'agricultor_id',
        'cargo',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function cooperativa()
    {
        return $this->belongsTo(Cooperativa::class);
    }

    public function agricultor()
    {
        return $this->belongsTo(Agricultor::class);
    }
}
