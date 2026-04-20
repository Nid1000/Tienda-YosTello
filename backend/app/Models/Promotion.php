<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Promotion extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'code',
        'discount_type',
        'discount_value',
        'target_type',
        'category_id',
        'product_id',
        'badge_text',
        'hero_image',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        $now = Carbon::now();

        return $query
            ->where('is_active', true)
            ->where(function (Builder $builder) use ($now): void {
                $builder->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function (Builder $builder) use ($now): void {
                $builder->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            });
    }

    public function getDiscountLabelAttribute(): string
    {
        $value = rtrim(rtrim(number_format((float) $this->discount_value, 2, '.', ''), '0'), '.');

        return $this->discount_type === 'percentage'
            ? "{$value}% OFF"
            : "S/. {$value} OFF";
    }

    public function getTargetLabelAttribute(): string
    {
        return match ($this->target_type) {
            'category' => 'Categoria: '.($this->category?->name ?? 'sin categoria'),
            'product' => 'Producto: '.($this->product?->name ?? 'sin producto'),
            default => 'Toda la tienda',
        };
    }
}
