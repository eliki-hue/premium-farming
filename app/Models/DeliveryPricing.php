<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryPricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_zone_id',
        'min_weight_kg',
        'max_weight_kg',
        'fee'
    ];

    protected $casts = [
        'min_weight_kg' => 'decimal:2',
        'max_weight_kg' => 'decimal:2',
        'fee' => 'decimal:2'
    ];

    public function zone()
    {
        return $this->belongsTo(DeliveryZone::class);
    }
}