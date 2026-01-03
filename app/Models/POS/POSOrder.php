<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class POSOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_id',
        'user_id',
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'order_type',
        'payment_method',
        'payment_reference',
        'mpesa_code',
        'subtotal',
        'discount_amount',
        'vat_amount',
        'shipping_amount',
        'total_amount',
        'amount_paid',
        'change_amount',
        'amount_due',
        'status',
        'payment_status',
        'notes',
        'cancellation_reason',
        'return_reason',
        'parent_order_id',
        'approved_by',
        'completed_at',
        'cancelled_at',
        'paid_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'amount_due' => 'decimal:2',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Relationship with store
     */
    public function store()
    {
        return $this->belongsTo(POSStore::class, 'store_id');
    }

    /**
     * Relationship with user (cashier)
     */
    public function user()
    {
        return $this->belongsTo(POSUser::class, 'user_id');
    }

    /**
     * Relationship with order items
     */
    public function items()
    {
        return $this->hasMany(POSOrderItem::class, 'order_id');
    }

    /**
     * Relationship with parent order (for returns)
     */
    public function parentOrder()
    {
        return $this->belongsTo(POSOrder::class, 'parent_order_id');
    }

    /**
     * Relationship with return orders
     */
    public function returnOrders()
    {
        return $this->hasMany(POSOrder::class, 'parent_order_id');
    }

    /**
     * Relationship with approver
     */
    public function approver()
    {
        return $this->belongsTo(POSUser::class, 'approved_by');
    }

    /**
     * Check if order is completed
     */
    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if order is cancelled
     */
    public function getIsCancelledAttribute()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if order is on hold
     */
    public function getIsHoldAttribute()
    {
        return $this->status === 'hold';
    }

    /**
     * Check if order is returned
     */
    public function getIsReturnedAttribute()
    {
        return $this->status === 'returned';
    }

    /**
     * Complete the order
     */
    public function complete()
    {
        $this->status = 'completed';
        $this->completed_at = now();
        $this->save();
    }

    /**
     * Cancel the order
     */
    public function cancel($reason = null)
    {
        $this->status = 'cancelled';
        $this->cancellation_reason = $reason;
        $this->cancelled_at = now();
        $this->save();
    }

    /**
     * Hold the order
     */
    public function hold()
    {
        $this->status = 'hold';
        $this->save();
    }

    /**
     * Release hold
     */
    public function releaseHold()
    {
        $this->status = 'pending';
        $this->save();
    }

    /**
     * Mark as paid
     */
    public function markAsPaid()
    {
        $this->payment_status = 'paid';
        $this->paid_at = now();
        $this->save();
    }

    /**
     * Get items count
     */
    public function getItemsCountAttribute()
    {
        return $this->items()->count();
    }

    /**
     * Calculate totals from items
     */
    public function calculateTotals()
    {
        $subtotal = $this->items()->sum('total_price');
        
        // Calculate VAT based on subtotal
        $vatAmount = $subtotal * 0.16; // 16% VAT
        
        $total = $subtotal + $vatAmount;
        
        $this->update([
            'subtotal' => $subtotal,
            'vat_amount' => $vatAmount,
            'total_amount' => $total,
            'amount_due' => $total - $this->amount_paid,
        ]);
    }
}