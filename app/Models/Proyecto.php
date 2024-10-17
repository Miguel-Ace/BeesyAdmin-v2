<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
            'nombre',
            'cliente_id',
            'user_cliente_id',
            'responsable_cliente',
            'email_responsable',
            'telefono_responsable',
            'colaborador_id',
            'fecha_inicio',
            'fecha_fin',
            'select_plantilla',
    ];

    // Un proyecto puede tener muchos detalles
    public function detalle_proyectos(): HasMany
    {
        return $this->hasMany(DetalleProyecto::class, 'proyecto_id', 'id');
    }
}
