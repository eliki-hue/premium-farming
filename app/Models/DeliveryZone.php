<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'base_fee',
        'free_distance_km',
        'per_km_fee',
        'weight_tiers',
        'is_active'
    ];

    protected $casts = [
        'weight_tiers' => 'array',
        'is_active' => 'boolean',
        'base_fee' => 'decimal:2',
        'per_km_fee' => 'decimal:2',
        'free_distance_km' => 'integer'
    ];

    public function pricingTiers()
    {
        return $this->hasMany(DeliveryPricing::class)->orderBy('min_weight_kg');
    }

    public function calculateDeliveryFee($distance, $weight)
    {
        $total = $this->base_fee;
        
        // Calculate distance fee
        if ($distance > $this->free_distance_km) {
            $extraDistance = $distance - $this->free_distance_km;
            $total += $extraDistance * $this->per_km_fee;
        }
        
        // Calculate weight fee
        $total += $this->calculateWeightFee($weight);
        
        return round($total, 2);
    }

    public function calculateWeightFee($weight)
    {
        // Check weight tiers
        $weightTiers = $this->pricingTiers;
        
        foreach ($weightTiers as $tier) {
            if ($weight >= $tier->min_weight_kg && $weight <= $tier->max_weight_kg) {
                return $tier->fee;
            }
        }
        
        // If no tier matches, calculate based on default pricing
        return max(0, ceil(($weight - 50) / 50) * 150);
    }

    public static function getZonesForSelect()
    {
        return self::where('is_active', true)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('Select Delivery Zone', '');
    }
}