<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cedula',
        'nombre',
        'contacto',
        'correo',
        'telefono',
        'pais',
    ];

    // pertenecer a un user
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id', 'id');
    }

    // puede pertenecer a muchos expedientes
    public function expedientes(): HasMany
    {
        return $this->hasMany(Expediente::class, 'cliente_id', 'id');
    }

    // puede pertenecer a muchas licencias
    public function licencias(): HasMany
    {
        return $this->hasMany(Licencia::class, 'cliente_id', 'id');
    }

    // puede tener muchas respuestas
    public function respuestas(): HasMany
    {
        return $this->hasMany(Respuesta::class, 'cliente_id', 'id');
    }

    // puede tener muchas soportes
    public function soportes(): HasMany
    {
        return $this->hasMany(Soporte::class, 'cliente_id', 'id');
    }

    // puede tener muchas usuarios del cliente
    public function user_clientes(): HasMany
    {
        return $this->hasMany(UserCliente::class, 'cliente_id', 'id');
    }
}
