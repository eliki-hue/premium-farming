<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryZone;
use App\Models\DeliveryPricing;

class DeliveryZonesSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        DeliveryZone::truncate();
        DeliveryPricing::truncate();

        // Zone A: 0-5km
        $zoneA = DeliveryZone::create([
            'name' => 'Zone A (0-5km)',
            'description' => 'Within 5km radius - Free distance',
            'base_fee' => 300.00,
            'free_distance_km' => 5,
            'per_km_fee' => 40.00,
            'is_active' => true
        ]);

        // Weight tiers for Zone A
        $zoneA->pricingTiers()->createMany([
            ['min_weight_kg' => 0, 'max_weight_kg' => 50, 'fee' => 0],
            ['min_weight_kg' => 51, 'max_weight_kg' => 100, 'fee' => 200.00],
            ['min_weight_kg' => 101, 'max_weight_kg' => 200, 'fee' => 400.00],
            ['min_weight_kg' => 201, 'max_weight_kg' => 500, 'fee' => 600.00],
            ['min_weight_kg' => 501, 'max_weight_kg' => 1000, 'fee' => 800.00],
            ['min_weight_kg' => 1001, 'max_weight_kg' => 10000, 'fee' => 1500.00], // Large orders
        ]);

        // Zone B: 6-15km
        $zoneB = DeliveryZone::create([
            'name' => 'Zone B (6-15km)',
            'description' => '6-15km radius',
            'base_fee' => 400.00,
            'free_distance_km' => 5,
            'per_km_fee' => 50.00,
            'is_active' => true
        ]);

        $zoneB->pricingTiers()->createMany([
            ['min_weight_kg' => 0, 'max_weight_kg' => 50, 'fee' => 0],
            ['min_weight_kg' => 51, 'max_weight_kg' => 100, 'fee' => 250.00],
            ['min_weight_kg' => 101, 'max_weight_kg' => 200, 'fee' => 500.00],
            ['min_weight_kg' => 201, 'max_weight_kg' => 500, 'fee' => 750.00],
            ['min_weight_kg' => 501, 'max_weight_kg' => 1000, 'fee' => 1000.00],
            ['min_weight_kg' => 1001, 'max_weight_kg' => 10000, 'fee' => 2000.00],
        ]);

        // Zone C: 16-30km
        $zoneC = DeliveryZone::create([
            'name' => 'Zone C (16-30km)',
            'description' => '16-30km radius',
            'base_fee' => 600.00,
            'free_distance_km' => 5,
            'per_km_fee' => 60.00,
            'is_active' => true
        ]);

        $zoneC->pricingTiers()->createMany([
            ['min_weight_kg' => 0, 'max_weight_kg' => 50, 'fee' => 0],
            ['min_weight_kg' => 51, 'max_weight_kg' => 100, 'fee' => 300.00],
            ['min_weight_kg' => 101, 'max_weight_kg' => 200, 'fee' => 600.00],
            ['min_weight_kg' => 201, 'max_weight_kg' => 500, 'fee' => 900.00],
            ['min_weight_kg' => 501, 'max_weight_kg' => 1000, 'fee' => 1200.00],
            ['min_weight_kg' => 1001, 'max_weight_kg' => 10000, 'fee' => 2500.00],
        ]);

        // Zone D: 30km+ (Custom Quote)
        $zoneD = DeliveryZone::create([
            'name' => 'Zone D (30km+)',
            'description' => 'Beyond 30km - Contact for custom quote',
            'base_fee' => 1000.00,
            'free_distance_km' => 5,
            'per_km_fee' => 80.00,
            'is_active' => true
        ]);

        $zoneD->pricingTiers()->createMany([
            ['min_weight_kg' => 0, 'max_weight_kg' => 10000, 'fee' => 0], // Custom quote
        ]);
    }
}