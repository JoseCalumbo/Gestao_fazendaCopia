<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Agricultor extends Model
{
    protected $table = 'agricultores';

    protected $fillable = [
        'nome_completo',
        'sexo',
        'data_nascimento',
        'bilhete',
        'nif',
        'estado',
        'foto',
        'telefone_principal',
        'telefone_alternativo',
        'email',
        'endereco',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function cooperativas()
    {
        return $this->hasMany(CooperativaMembro::class);
    }

    public function talhoes()
    {
        return $this->hasMany(Talhao::class);
    }

    public function movimentoInsumos()
    {
        return $this->hasMany(MovimentoInsumo::class);
    }


    /**
     * Relacionamento com Insumos (Estoque)
     */
    public function insumos()
    {
        return $this->hasMany(Insumo::class, 'agricultor_id');
    }

    // Relacionamento com a tabela pivot (Um agricultor pode ter vários registos ou históricos de associação)
    public function associacoes()
    {
        return $this->hasMany(CooperativaMembro::class, 'agricultor_id');
    }

    // Atalho direto: Retorna a associação ativa atual do Agricultor (se houver)
    public function associacaoAtiva()
    {
        return $this->hasOne(CooperativaMembro::class, 'agricultor_id')->where('activo', true);
    }

    public function getIdadeAttribute()
    {
        return $this->data_nascimento
            ? $this->data_nascimento->age
            : null;
    }

    public function getInicialAttribute()
    {
        return strtoupper(substr($this->nome_completo, 0, 1));
    }

  public function getFotoUrlAttribute()
{
    if (!$this->foto) {
        return asset('image/user-default.png');
    }

    return asset('storage/' . $this->foto);
}

}
