<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Software extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre'
    ];
    
    // puede pertenecer a muchos expedientes
    public function expedientes(): HasMany
    {
        return $this->hasMany(Expediente::class, 'software_id', 'id');
    }
    
    // puede pertenecer a muchas licencias
    public function licencias(): HasMany
    {
        return $this->hasMany(Licencia::class, 'software_id', 'id');
    }

    // puede pertenecer a muchos soportes
    public function soportes(): HasMany
    {
        return $this->hasMany(Soporte::class, 'software_id', 'id');
    }
}
