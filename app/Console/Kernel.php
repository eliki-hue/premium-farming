<?php
// app/Console/Kernel.php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // ============================================
        // DJANGO API TOKEN MANAGEMENT
        // ============================================
        
        // Refresh Django API token every 3 minutes (before 5-minute expiry)
        $schedule->command('django:refresh-token')
            ->everyThreeMinutes()
            ->description('Refresh Django API JWT token before expiration')
            ->withoutOverlapping()
            ->runInBackground();
        
        // Clear old product cache every 5 minutes
        $schedule->command('cache:forget django_products_*')
            ->everyFiveMinutes()
            ->description('Clear cached Django products')
            ->runInBackground();
        
        // Test Django API connection every 10 minutes (for monitoring)
        $schedule->command('django:test-connection')
            ->everyTenMinutes()
            ->description('Test Django API connection')
            ->runInBackground();
        
        // ============================================
        // APPLICATION MAINTENANCE
        // ============================================
        
        // Laravel Scheduler (default)
        $schedule->command('inspire')->hourly();
        
        // Clear expired session files daily
        $schedule->command('session:clear')->daily();
        
        // Clear all application caches daily at 3 AM
        $schedule->command('cache:clear')->dailyAt('03:00');
        
        // Clear view cache daily
        $schedule->command('view:clear')->dailyAt('03:30');
        
        // Clear route cache daily
        $schedule->command('route:clear')->dailyAt('04:00');
        
        // Clear config cache daily
        $schedule->command('config:clear')->dailyAt('04:30');
        
        // Backup database daily at 2 AM (if using spatie/laravel-backup)
        // $schedule->command('backup:run')->dailyAt('02:00');
        
        // ============================================
        // E-COMMERCE SPECIFIC SCHEDULES
        // ============================================
        
        // Clear abandoned carts older than 24 hours daily at 1 AM
        $schedule->command('cart:clear-abandoned')
            ->dailyAt('01:00')
            ->description('Clear abandoned guest carts');
        
        // Send cart reminder emails every 2 hours (if implemented)
        // $schedule->command('cart:send-reminders')
        //     ->everyTwoHours()
        //     ->between('8:00', '20:00');
        
        // Update product stock from Django API every 15 minutes during business hours
        $schedule->command('products:sync-stock')
            ->everyFifteenMinutes()
            ->between('6:00', '20:00')
            ->weekdays()
            ->description('Sync product stock from Django API');
        
        // Generate daily sales report at midnight
        $schedule->command('reports:daily-sales')
            ->dailyAt('00:05')
            ->description('Generate daily sales report');
        
        // ============================================
        // APPLICATION HEALTH CHECKS
        // ============================================
        
        // Send health check notification daily at 9 AM
        $schedule->command('health:check')
            ->dailyAt('09:00')
            ->description('Send system health check');
        
        // Cleanup temporary files weekly on Sunday at 2 AM
        $schedule->command('cleanup:temp-files')
            ->weeklyOn(0, '02:00') // Sunday
            ->description('Clean up temporary files');
        
        // ============================================
        // LOG MANAGEMENT
        // ============================================
        
        // Rotate Laravel logs daily
        $schedule->command('log:rotate')
            ->daily()
            ->description('Rotate application logs');
        
        // Clean old log files weekly
        $schedule->command('log:clean')
            ->weekly()
            ->description('Clean old log files');
        
        // ============================================
        // NOTIFICATIONS & REMINDERS
        // ============================================
        
        // Send order status update reminders every hour during business hours
        $schedule->command('orders:send-status-updates')
            ->hourly()
            ->between('8:00', '18:00')
            ->weekdays()
            ->description('Send order status updates');
        
        // Send low stock alerts daily at 10 AM
        $schedule->command('inventory:low-stock-alerts')
            ->dailyAt('10:00')
            ->description('Send low stock alert emails');
        
        // ============================================
        // PERFORMANCE OPTIMIZATION
        // ============================================
        
        // Optimize database tables weekly on Saturday at 3 AM
        $schedule->command('db:optimize')
            ->weeklyOn(6, '03:00') // Saturday
            ->description('Optimize database tables');
        
        // Clear expired password reset tokens daily
        $schedule->command('auth:clear-resets')
            ->daily()
            ->description('Clear expired password reset tokens');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Get the timezone that should be used by default for scheduled events.
     */
    protected function scheduleTimezone(): string
    {
        // Set to your timezone (Africa/Nairobi for Kenya)
        return 'Africa/Nairobi';
    }

    /**
     * Get the schedule's server timezone.
     */
    protected function scheduleServerTimezone(): string
    {
        return 'UTC';
    }
}