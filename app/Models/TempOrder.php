<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempOrder extends Model
{
    use HasFactory;

    protected $table = 'temp_orders';

    protected $fillable = [
        'session_id',
        'order_ref',
        'django_user_id',
        'cart_items',
        'subtotal',
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_address',
        'county',
        'town',
        'delivery_type',
        'delivery_charge',
        'whatsapp_message',
        'whatsapp_message_id',
        'status',
        'whatsapp_sent_at',
        'expires_at'
    ];

    protected $casts = [
        'cart_items' => 'array',
        'subtotal' => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'whatsapp_sent_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    const STATUS_WHATSAPP_INITIATED = 'whatsapp_initiated';
    const STATUS_WHATSAPP_SENT = 'whatsapp_sent';
    const STATUS_RETURNED_FOR_CHECKOUT = 'returned_for_checkout';
    const STATUS_COMPLETED = 'completed';
    const STATUS_EXPIRED = 'expired';

    public function isValid()
    {
        return !$this->expires_at || $this->expires_at->isFuture();
    }

    public function getTotalAttribute()
    {
        return $this->subtotal + ($this->delivery_charge ?? 0);
    }
}