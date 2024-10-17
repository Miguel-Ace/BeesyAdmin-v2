<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Soporte extends Model
{
    use HasFactory;

    protected $fillable = [
        'colaborador_id',
        'fechaInicioAsistencia',
        'fechaFinalAsistencia',
        'fecha_prevista_cumplimiento',
        'cliente_id',
        'software_id',
        'problema',
        'solucion',
        'observaciones',
        'prioridad_id',
        'estado_id',
        'correo_cliente',
        'archivo',
        'tipo_id',
        'user_cliente_id',
        'interno',
        'expediente_id',
        'imagen',
    ];

    // solo tiene un colaborador
    public function colaborador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'colaborador_id', 'id');
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

    // solo tiene un origenAsistencia
    public function tipo(): BelongsTo
    {
        return $this->belongsTo(OrigenAsistencia::class, 'tipo_id', 'id');
    }

    // solo tiene un usuario del cliente
    public function user_cliente(): BelongsTo
    {
        return $this->belongsTo(UserCliente::class, 'user_cliente_id', 'id');
    }

    // solo tiene un expediente
    public function expediente(): BelongsTo
    {
        return $this->belongsTo(Expediente::class, 'expediente_id', 'id');
    }
}
