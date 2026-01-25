<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestDjangoConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-django-connection';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
public function handle()
    {
        $this->info('🔍 Testing Django API connection...');
        
        try {
            $products = DjangoApiService::getProducts();
            
            if ($products->isNotEmpty()) {
                $count = $products->count();
                $this->info("✅ Connection successful! Found {$count} products.");
                Log::info("Django API connection test: Found {$count} products");
                return 0;
            } else {
                $this->warn('⚠️ Connection successful but no products returned.');
                Log::warning('Django API connection test: No products returned');
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('❌ Connection failed: ' . $e->getMessage());
            Log::error('Django API connection test failed: ' . $e->getMessage());
            return 1;
        }
    }
}
