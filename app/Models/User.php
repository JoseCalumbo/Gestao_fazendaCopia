<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'telefone',
        'password',
        'foto',
        'nivel',
        'estado',
        'ultimo_acesso'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'ultimo_acesso' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Acessor para obter URL da foto do utilizador
     */
    public function getFotoUrlAttribute()
    {
        if (!empty($this->foto) && file_exists(public_path('uploads/users/' . $this->foto))) {
            return asset('uploads/users/' . $this->foto);
        }
        return asset('uploads/users/default-user.png');
    }

    /**
     * Acessor para obter iniciais do nome
     */
    public function getIniciaisAttribute()
    {
        return strtoupper(substr($this->name, 0, 1));
    }

    /**
     * Atualizar último acesso quando faz login
     */
    public static function boot()
    {
        parent::boot();
    }

}
