<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\POS\POSStore;
use App\Models\POS\POSUser;
use App\Models\POS\POSProduct;
use Illuminate\Support\Facades\Hash;

class POSDataSeeder extends Seeder
{
    public function run()
    {
        // Create main store
        $mainStore = POSStore::create([
            'code' => 'ST001',
            'name' => 'Premium Feeds Main Store',
            'type' => 'retail',
            'address' => 'Nairobi, Kenya',
            'location' => 'Nairobi CBD',
            'phone' => '+254700123456',
            'email' => 'store@premiumfeeds.com',
            'manager_name' => 'John Manager',
            'manager_phone' => '+254711223344',
            'opening_time' => '08:00:00',
            'closing_time' => '18:00:00',
            'is_active' => true,
        ]);

        // Create POS Admin
        POSUser::create([
            'name' => 'POS Admin',
            'username' => 'posadmin',
            'email' => 'posadmin@premiumfeeds.com',
            'phone' => '+254722334455',
            'password' => Hash::make('password123'),
            'store_id' => $mainStore->id,
            'role' => 'admin',
            'is_active' => true,
            'can_sell' => true,
            'can_manage_orders' => true,
            'can_manage_stock' => true,
            'can_view_reports' => true,
            'can_manage_prices' => true,
        ]);

        // Create POS Cashier
        POSUser::create([
            'name' => 'POS Cashier',
            'username' => 'poscashier',
            'email' => 'poscashier@premiumfeeds.com',
            'phone' => '+254733445566',
            'password' => Hash::make('password123'),
            'store_id' => $mainStore->id,
            'role' => 'cashier',
            'is_active' => true,
            'can_sell' => true,
            'can_manage_orders' => false,
            'can_manage_stock' => false,
            'can_view_reports' => false,
            'can_manage_prices' => false,
        ]);

        // Create sample products
        $products = [
            [
                'code' => 'PROD001',
                'name' => 'Chick Mash 50kg',
                'category' => 'poultry',
                'buying_price' => 1500,
                'selling_price' => 1700,
                'wholesale_price' => 1600,
                'stock' => 45,
                'min_stock' => 10,
                'max_stock' => 100,
                'unit' => 'bag',
                'weight' => 50,
                'weight_unit' => 'kg',
                'supplier' => 'Unga Feeds',
                'brand' => 'Unga',
                'vat_rate' => 16,
            ],
            [
                'code' => 'PROD002',
                'name' => 'Layers Mash 50kg',
                'category' => 'poultry',
                'buying_price' => 1650,
                'selling_price' => 1850,
                'wholesale_price' => 1750,
                'stock' => 3,
                'min_stock' => 5,
                'max_stock' => 80,
                'unit' => 'bag',
                'weight' => 50,
                'weight_unit' => 'kg',
                'supplier' => 'Unga Feeds',
                'brand' => 'Unga',
                'vat_rate' => 16,
            ],
            [
                'code' => 'PROD003',
                'name' => 'Pig Fattener 50kg',
                'category' => 'pig',
                'buying_price' => 2400,
                'selling_price' => 2600,
                'wholesale_price' => 2500,
                'stock' => 120,
                'min_stock' => 20,
                'max_stock' => 200,
                'unit' => 'bag',
                'weight' => 50,
                'weight_unit' => 'kg',
                'supplier' => 'Farmers Choice',
                'brand' => 'Farmers Choice',
                'vat_rate' => 16,
            ],
            [
                'code' => 'PROD004',
                'name' => 'Dog Meal 25kg',
                'category' => 'pet',
                'buying_price' => 2000,
                'selling_price' => 2200,
                'wholesale_price' => 2100,
                'stock' => 8,
                'min_stock' => 5,
                'max_stock' => 50,
                'unit' => 'bag',
                'weight' => 25,
                'weight_unit' => 'kg',
                'supplier' => 'Pedigree',
                'brand' => 'Pedigree',
                'vat_rate' => 16,
            ],
        ];

        foreach ($products as $productData) {
            $productData['store_id'] = $mainStore->id;
            $productData['is_active'] = true;
            $productData['track_stock'] = true;
            $productData['allow_discount'] = true;
            
            POSProduct::create($productData);
        }

        $this->command->info('POS data seeded successfully!');
    }
}