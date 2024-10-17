<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrigenAsistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre'
    ];

    // puede tener muchos detalles
    public function detalle_proyectos(): HasMany
    {
        return $this->hasMany(DetalleProyecto::class, 'tipo_id', 'id');
    }

    // puede tener muchos expedientes
    public function expedientes(): HasMany
    {
        return $this->hasMany(Expediente::class, 'tipo_id', 'id');
    }

    // puede tener muchos soportes
    public function soportes(): HasMany
    {
        return $this->hasMany(Soporte::class, 'tipo_id', 'id');
    }
}
