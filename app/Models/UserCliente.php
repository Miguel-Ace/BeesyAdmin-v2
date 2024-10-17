<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'cliente_id',
    ];

    // pertenece a un solo soporte
    public function soporte(): BelongsTo
    {
        return $this->belongsTo(Soporte::class, 'user_cliente_id', 'id');
    }

    // pertenece a un solo cliente
    public function clientes(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }
}
