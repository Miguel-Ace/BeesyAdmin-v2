<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Licencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'software_id',
        'ruta',
        'cantidad',
        'fechaInicio',
        'fechaFinal',
        'cantidad_usuario',
        'bee_commerce',
        'intervalo',
        'countIntervalo',
        'monto',
        'descripcion',
        'plan_id',
        'subscripcion_id',
    ];

    // puede tener solo un cliente
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    // puede tener solo un software
    public function software(): BelongsTo
    {
        return $this->belongsTo(Software::class, 'software_id', 'id');
    }

    // puede tener varios terminal
    public function terminal(): HasMany
    {
        return $this->hasMany(Terminal::class, 'licencia_id', 'id');
    }
}
