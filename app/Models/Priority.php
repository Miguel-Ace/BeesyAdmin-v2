<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Priority extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre'
    ];

    // puede tener varios expedientes
    public function expedientes(): HasMany
    {
        return $this->hasMany(Expediente::class, 'prioridad_id', 'id');
    }

    // puede tener varios soportes
    public function soportes(): HasMany
    {
        return $this->hasMany(Soporte::class, 'prioridad_id', 'id');
    }
}
