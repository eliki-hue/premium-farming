<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_location',
        'review',
        'rating',
        'farm_type',
        'product_name',
        'product_id',
        'is_approved',
        'is_featured',
        'has_photo',
        'photo_path',
        'approved_at'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'has_photo' => 'boolean',
        'approved_at' => 'datetime'
    ];

    /**
     * Scope for approved reviews
     */
    public function scopeApproved($query)
    {
        // Check if column exists before using it
        if (Schema::hasColumn('reviews', 'is_approved')) {
            return $query->where('is_approved', true);
        }
        
        // If column doesn't exist, return all reviews
        return $query;
    }

    /**
     * Scope for featured reviews
     */
    public function scopeFeatured($query)
    {
        if (Schema::hasColumn('reviews', 'is_featured')) {
            return $query->where('is_featured', true);
        }
        
        return $query;
    }

    /**
     * Scope for recent reviews
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for high rating reviews (4-5 stars)
     */
    public function scopeHighRating($query)
    {
        return $query->where('rating', '>=', 4);
    }

    /**
     * Get the product associated with the review
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get star rating as HTML
     */
    public function getStarsAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="bi bi-star-fill text-warning"></i>';
            } else {
                $stars .= '<i class="bi bi-star text-warning"></i>';
            }
        }
        return $stars;
    }

    /**
     * Get farm type badge
     */
    public function getFarmTypeBadgeAttribute()
    {
        $badgeColors = [
            'Dairy' => 'primary',
            'Poultry' => 'warning',
            'Pig' => 'danger',
            'Cattle' => 'success',
            'Goat' => 'info',
            'Rabbit' => 'secondary'
        ];

        $color = $badgeColors[$this->farm_type] ?? 'dark';
        
        return '<span class="badge bg-' . $color . '">' . $this->farm_type . ' Farmer</span>';
    }

    /**
     * Get time ago (e.g., "2 days ago")
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Check if review has been approved
     */
    public function isApproved()
    {
        if (Schema::hasColumn('reviews', 'is_approved')) {
            return $this->is_approved;
        }
        
        // If column doesn't exist, consider all reviews as approved
        return true;
    }

    /**
     * Approve the review
     */
    public function approve()
    {
        if (Schema::hasColumn('reviews', 'is_approved')) {
            $this->update([
                'is_approved' => true,
                'approved_at' => now()
            ]);
        }
    }

    /**
     * Feature the review
     */
    public function feature()
    {
        if (Schema::hasColumn('reviews', 'is_featured')) {
            $this->update(['is_featured' => true]);
        }
    }

    /**
     * Unfeature the review
     */
    public function unfeature()
    {
        if (Schema::hasColumn('reviews', 'is_featured')) {
            $this->update(['is_featured' => false]);
        }
    }
    
    /**
     * Check if table has specific column
     */
    public static function hasColumn($column)
    {
        return Schema::hasColumn((new static)->getTable(), $column);
    }
}