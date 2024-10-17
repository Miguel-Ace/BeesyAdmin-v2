<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Respuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregunta_id',
        'num_respuesta',
        'cedula_cliente',
        'cliente_id',
        'pais',
        'usuario',
        'fecha_hora',
        'intento',
        'notas',
    ];


    // solo tiene una pregunta
    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id', 'id');
    }

    // solo tiene un cliente
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }
}
