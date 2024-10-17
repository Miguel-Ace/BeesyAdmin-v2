<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleProyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyecto_id',
        'nombre_actividad',
        'fecha_inicio',
        'fecha_fin',
        'horas_propuestas',
        'meta_hrs_optimas',
        'horas_reales',
        'colaborador_id',
        'ejecutor_cliente',
        'tipo_id',
        'rendimiento',
        'estado_id',
        'etapa_id',
        'notas',
    ];


    // Un detalle solo tiene un proyecto
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    // Un detalle solo tiene un colaborador
    public function colaborador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'colaborador_id', 'id');
    }

    // Un detalle solo tiene un estado
    public function estado(): BelongsTo
    {
        return $this->belongsTo(State::class, 'estado_id', 'id');
    }

    // Un detalle solo tiene una estapa
    public function estapa(): BelongsTo
    {
        return $this->belongsTo(Etapa::class, 'etapa_id', 'id');
    }

    // Un detalle solo tiene un tipo
    public function tipo(): BelongsTo
    {
        return $this->belongsTo(OrigenAsistencia::class, 'tipo_id', 'id');
    }
}
