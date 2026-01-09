<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
               'name', 'description', 'price', 'unit', 'category', 'image', 'weight_kg',
    'weight_unit'
    ];

    protected $casts = [
    'weight_kg' => 'decimal:2'
];
public function category() { return $this->belongsTo(Category::class); }
public function stockMovements() { return $this->hasMany(StockMovement::class); }
public function saleItems() { return $this->hasMany(SaleItem::class); }

}


