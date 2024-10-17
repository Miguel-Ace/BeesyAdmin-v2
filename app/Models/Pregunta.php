<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pregunta extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregunta',
        'fecha_creacion',
        'intentos',
        'activo',
        'opcion_mult',
    ];

    // puede tener muchas respuestas
    public function respuestas(): HasMany
    {
        return $this->hasMany(Respuesta::class, 'pregunta_id', 'id');
    }
}
