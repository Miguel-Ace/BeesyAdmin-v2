<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'pv_po_id',
        'po_id',
        'status',
        'amount',
        'pv_checksum',
        'renovacion',
    ];
}
