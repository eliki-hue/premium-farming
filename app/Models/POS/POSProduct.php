<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class POSProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_id',
        'code',
        'name',
        'barcode',
        'category',
        'description',
        'buying_price',
        'selling_price',
        'wholesale_price',
        'stock',
        'min_stock',
        'max_stock',
        'unit',
        'weight',
        'weight_unit',
        'supplier',
        'brand',
        'reorder_quantity',
        'is_active',
        'track_stock',
        'allow_discount',
        'discount_percentage',
        'vat_rate',
        'images',
        'notes',
    ];

    protected $casts = [
        'buying_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'track_stock' => 'boolean',
        'allow_discount' => 'boolean',
        'discount_percentage' => 'decimal:2',
        'weight' => 'decimal:2',
        'images' => 'array',
    ];

    /**
     * Relationship with store
     */
    public function store()
    {
        return $this->belongsTo(POSStore::class, 'store_id');
    }

    /**
     * Relationship with order items
     */
    public function orderItems()
    {
        return $this->hasMany(POSOrderItem::class, 'product_id');
    }

    /**
     * Relationship with stock movements
     */
    public function stockMovements()
    {
        return $this->hasMany(POSStockMovement::class, 'product_id');
    }

    /**
     * Check if product is low on stock
     */
    public function getIsLowStockAttribute()
    {
        return $this->track_stock && $this->stock <= $this->min_stock;
    }

    /**
     * Check if product is out of stock
     */
    public function getIsOutOfStockAttribute()
    {
        return $this->track_stock && $this->stock <= 0;
    }

    /**
     * Get product price with VAT
     */
    public function getPriceWithVatAttribute()
    {
        return $this->selling_price * (1 + ($this->vat_rate / 100));
    }

    /**
     * Get discounted price
     */
    public function getDiscountedPriceAttribute()
    {
        if (!$this->allow_discount || $this->discount_percentage <= 0) {
            return $this->selling_price;
        }
        
        return $this->selling_price * (1 - ($this->discount_percentage / 100));
    }

    /**
     * Get stock value
     */
    public function getStockValueAttribute()
    {
        return $this->stock * $this->buying_price;
    }

    /**
     * Reduce stock quantity
     */
    public function reduceStock($quantity)
    {
        if (!$this->track_stock) return true;
        
        if ($this->stock < $quantity) {
            throw new \Exception('Insufficient stock');
        }
        
        $this->stock -= $quantity;
        return $this->save();
    }

    /**
     * Increase stock quantity
     */
    public function increaseStock($quantity)
    {
        if (!$this->track_stock) return true;
        
        $this->stock += $quantity;
        return $this->save();
    }

    /**
     * Check if product needs reordering
     */
    public function getNeedsReorderAttribute()
    {
        return $this->track_stock && $this->stock <= $this->reorder_quantity;
    }
}