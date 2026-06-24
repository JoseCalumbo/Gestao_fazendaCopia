<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cooperativa extends Model
{
    protected $table = 'cooperativas';

    protected $fillable = [

        'nome',
        'nif',
        'data_fundacao',
        'descricao',

        'telefone',
        'email',
        'website',

        'provincia',
        'municipio',
        'comuna',
        'endereco',

        'numero_socios',

        'principal_cultura',
        'numero_talhoes',
        'producao_estimada',
        'area_total_cultivada',

        'safra',
        'inicio_safra',
        'fim_previsto_safra',

        'estado',

        'foto',
    ];

    protected $casts = [

        'data_fundacao' => 'date',

        'inicio_safra' => 'date',

        'fim_previsto_safra' => 'date',

        'numero_socios' => 'integer',

        'numero_talhoes' => 'integer',

        'producao_estimada' => 'decimal:2',

        'area_total_cultivada' => 'decimal:2',
    ];

    // Relacionamento com a tabela pivot para listar os membros desta cooperativa
    public function membros()
    {
        return $this->hasMany(CooperativaMembro::class, 'cooperativa_id');
    }

    // Opcional: Atalho direto para listar apenas os membros que estão atualmente ativos
    public function membrosAtivos()
    {
        return $this->hasMany(CooperativaMembro::class, 'cooperativa_id')->where('activo', true);
    }

    // Relacionamento com a tabela Insumos
    public function insumos()
    {
        return $this->hasMany(Insumo::class);
    }

    // relacionamento com tabela movimento
    public function movimentoInsumos()
    {
        return $this->hasMany(MovimentoInsumo::class);
    }

    public function safras()
    {
        return $this->hasMany(Safra::class);
    }

    public function talhoes()
    {
        return $this->hasMany(Talhao::class);
    }

    /**
     * Uma cooperativa tem muitos agricultores.
     */
    public function agricultores()
    {
        return $this->belongsToMany(
            Agricultor::class,
            'cooperativa_membros',
            'cooperativa_id',
            'agricultor_id'
        )->withPivot('cargo', 'activo');
    }
}
