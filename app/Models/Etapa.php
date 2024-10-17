<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre'    
    ];

    // Una etapa puede tener muchos detalles
    public function detalle_proyectos(): HasMany
    {
        return $this->hasMany(DetalleProyecto::class, 'etapa_id', 'id');
    }
}
