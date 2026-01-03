<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class POSStore extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'type',
        'address',
        'location',
        'phone',
        'email',
        'manager_name',
        'manager_phone',
        'opening_time',
        'closing_time',
        'is_active',
        'latitude',
        'longitude',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Relationship with users
     */
    public function users()
    {
        return $this->hasMany(POSUser::class, 'store_id');
    }

    /**
     * Relationship with products
     */
    public function products()
    {
        return $this->hasMany(POSProduct::class, 'store_id');
    }

    /**
     * Relationship with orders
     */
    public function orders()
    {
        return $this->hasMany(POSOrder::class, 'store_id');
    }

    /**
     * Check if store is open
     */
    public function getIsOpenAttribute()
    {
        $now = now()->format('H:i:s');
        return $now >= $this->opening_time && $now <= $this->closing_time;
    }

    /**
     * Get store's current stock value
     */
    public function getStockValueAttribute()
    {
        return $this->products()->sum('stock * buying_price');
    }

    /**
     * Get store's current stock count
     */
    public function getStockCountAttribute()
    {
        return $this->products()->count();
    }

    /**
     * Get today's sales
     */
    public function getTodaySalesAttribute()
    {
        return $this->orders()
            ->whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total_amount');
    }

    /**
     * Get today's transaction count
     */
    public function getTodayTransactionsAttribute()
    {
        return $this->orders()
            ->whereDate('created_at', today())
            ->where('status', 'completed')
            ->count();
    }
}