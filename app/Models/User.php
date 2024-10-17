<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'con_laboratorio',
        'con_especializacion',
        'con_mejora',
        'password',
        'interno',
        'cliente_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // pertenecer a un cliente
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    // puede tener muchos detalles
    public function detalle_proyectos(): HasMany
    {
        return $this->hasMany(DetalleProyecto::class, 'colaborador_id', 'id');
    }

    // muchos colaboradores les pertence labs
    public function pertenece_expedientes(): HasMany
    {
        return $this->hasMany(Expediente::class, 'colaborador_pertenece_id', 'id');
    }

    // muchos colaboradores han realizado labs
    public function realizo_expedientes(): HasMany
    {
        return $this->hasMany(Expediente::class, 'colaborador_soluciona_id', 'id');
    }

    // muchos colaboradores han hecho soportes
    public function soportes(): HasMany
    {
        return $this->hasMany(Soporte::class, 'colaborador_id', 'id');
    }
}
