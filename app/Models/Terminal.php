<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Terminal extends Model
{
    use HasFactory;

    protected $fillable = [
        'licencia_id',
        'serial',
        'nombre_equipo',
        'ultimo_acceso',
        'estado',
    ];


    // solo tiene una licencias
    public function licencia(): BelongsTo
    {
        return $this->belongsTo(Licencia::class, 'licencia_id', 'id');
    }
}
