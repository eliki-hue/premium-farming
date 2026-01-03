<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class POSUser extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guard = 'pos';

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'store_id',
        'role',
        'is_active',
        'is_pos_user',
        'can_sell',
        'can_manage_orders',
        'can_manage_stock',
        'can_view_reports',
        'can_manage_prices',
        'daily_sales_limit',
        'transaction_limit',
        'notes',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_pos_user' => 'boolean',
        'can_sell' => 'boolean',
        'can_manage_orders' => 'boolean',
        'can_manage_stock' => 'boolean',
        'can_view_reports' => 'boolean',
        'can_manage_prices' => 'boolean',
        'daily_sales_limit' => 'decimal:2',
        'transaction_limit' => 'decimal:2',
        'last_login_at' => 'datetime',
    ];

    /**
     * Relationship with store
     */
    public function store()
    {
        return $this->belongsTo(POSStore::class, 'store_id');
    }

    /**
     * Relationship with orders
     */
    public function orders()
    {
        return $this->hasMany(POSOrder::class, 'user_id');
    }

    /**
     * Relationship with cash floats
     */
    public function cashFloats()
    {
        return $this->hasMany(POSCashFloat::class, 'user_id');
    }

    /**
     * Check if user can perform action
     */
    public function canPerform($action)
    {
        switch ($action) {
            case 'sell':
                return $this->can_sell;
            case 'manage_orders':
                return $this->can_manage_orders || $this->role === 'manager' || $this->role === 'admin';
            case 'manage_stock':
                return $this->can_manage_stock || $this->role === 'manager' || $this->role === 'admin';
            case 'view_reports':
                return $this->can_view_reports || $this->role === 'manager' || $this->role === 'admin';
            case 'manage_prices':
                return $this->can_manage_prices || $this->role === 'manager' || $this->role === 'admin';
            default:
                return false;
        }
    }

    /**
     * Get user's permissions array
     */
    public function getPermissionsAttribute()
    {
        $permissions = [];
        
        if ($this->can_sell) $permissions[] = 'sell';
        if ($this->can_manage_orders) $permissions[] = 'manage_orders';
        if ($this->can_manage_stock) $permissions[] = 'manage_stock';
        if ($this->can_view_reports) $permissions[] = 'view_reports';
        if ($this->can_manage_prices) $permissions[] = 'manage_prices';
        
        return $permissions;
    }

    /**
     * Record login time
     */
    public function recordLogin()
    {
        $this->last_login_at = now();
        $this->save();
    }

    /**
     * Check if user is within daily sales limit
     */
    public function checkDailySalesLimit($additionalAmount = 0)
    {
        if (!$this->daily_sales_limit) return true;
        
        $todaySales = $this->orders()
            ->whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total_amount');
            
        return ($todaySales + $additionalAmount) <= $this->daily_sales_limit;
    }
}