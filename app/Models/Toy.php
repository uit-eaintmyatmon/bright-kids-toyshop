<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'category_id',
        'status_id',
        'location_id',
        'description',
        'price',
        'quantity',
        'image_url',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function images()
    {
        return $this->hasMany(ToyImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ToyImage::class)->where('is_primary', true);
    }

    /**
     * Get the display image URL (primary image, first image, or legacy image_url)
     */
    public function getDisplayImageAttribute(): ?string
    {
        // First check for primary image in the new system
        if ($this->relationLoaded('images') && $this->images->isNotEmpty()) {
            $primary = $this->images->firstWhere('is_primary', true);
            return $primary ? $primary->image_url : $this->images->first()->image_url;
        }
        
        // Fall back to legacy image_url field
        return $this->image_url;
    }

    public function scopeAvailable($query)
    {
        return $query->where('quantity', '>', 0);
    }
}
