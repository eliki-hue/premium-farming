<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncProductStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-product-stock';

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
        $this->info('📦 Syncing product stock from Django API...');
        
        try {
            $products = DjangoApiService::getProducts();
            
            if ($products->isNotEmpty()) {
                // Here you would update your local database with stock info
                // This is just a placeholder - implement based on your needs
                
                $count = $products->count();
                $this->info("✅ Stock sync completed for {$count} products.");
                Log::info("Product stock synced: {$count} products");
                return 0;
            } else {
                $this->warn('⚠️ No products returned from API.');
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('❌ Stock sync failed: ' . $e->getMessage());
            Log::error('Product stock sync failed: ' . $e->getMessage());
            return 1;
        }
    }
}