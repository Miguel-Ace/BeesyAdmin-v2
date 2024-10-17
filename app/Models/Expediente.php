<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expediente extends Model
{
    use HasFactory;

    protected $fillabel = [
        'colaborador_pertenece_id',
        'colaborador_soluciona_id',
        'tipo_id',
        'num_expediente',
        'expediente',
        'archivo',
        'prioridad_id',
        'estado_id',
        'fecha_entrada',
        'fecha_programada',
        'fecha_salida',
        'fecha_revision',
        'cliente_id',
        'software_id',
    ];

    // solo tiene un colaborador que hizo el lab
    public function c_pertenece(): BelongsTo
    {
        return $this->belongsTo(User::class, 'colaborador_pertenece_id', 'id');
    }

    // solo tiene un colaborador que realizará el lab
    public function c_realizo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'colaborador_soluciona_id', 'id');
    }

    // solo tiene un origenAsistencia
    public function tipo(): BelongsTo
    {
        return $this->belongsTo(OrigenAsistencia::class, 'tipo_id', 'id');
    }

    // solo tiene una prioridad
    public function prioridad(): BelongsTo
    {
        return $this->belongsTo(Priority::class, 'prioridad_id', 'id');
    }

    // solo tiene un estado
    public function estado(): BelongsTo
    {
        return $this->belongsTo(State::class, 'estado_id', 'id');
    }

    // solo tiene un cliente
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    // solo tiene un software
    public function software(): BelongsTo
    {
        return $this->belongsTo(Software::class, 'software_id', 'id');
    }

    // solo tiene un soporte
    public function soporte(): BelongsTo
    {
        return $this->belongsTo(Soporte::class, 'expediente_id', 'id');
    }
}
