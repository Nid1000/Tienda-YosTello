<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'category',
        'description',
        'price',
        'cost_price',
        'discount_percent',
        'image',
        'sizes',
        'colors',
        'stock',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'discount_percent' => 'decimal:2',
            'sizes' => 'array',
            'colors' => 'array',
            'is_featured' => 'boolean',
        ];
    }

    public function catalogCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getCategoryNameAttribute(): string
    {
        return $this->catalogCategory?->name ?? $this->category;
    }

    public function getDiscountAmountAttribute(): float
    {
        return round(((float) $this->price) * ((float) $this->discount_percent / 100), 2);
    }

    public function getFinalPriceAttribute(): float
    {
        return round(((float) $this->price) - $this->discount_amount, 2);
    }

    public function getProfitPerUnitAttribute(): float
    {
        return round($this->final_price - (float) $this->cost_price, 2);
    }

    public function getHasDiscountAttribute(): bool
    {
        return (float) $this->discount_percent > 0;
    }
}
