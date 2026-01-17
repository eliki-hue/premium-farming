<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshDjangoToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-django-token';

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
        $this->info('Refreshing Django API token...');
        
        try {
            // This will force a token refresh
            Cache::forget('django_api_token');
            $token = DjangoApiService::getToken();
            
            if ($token) {
                $this->info('✅ Token refreshed successfully');
                return 0;
            } else {
                $this->error('❌ Failed to refresh token');
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}
