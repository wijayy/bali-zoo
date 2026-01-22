<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, Sluggable;

    protected $connection = 'mysql';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPriceAttribute()
    {
        return $this->sell_price;
    }



    protected $with = ['review', 'cart'];
    protected $perPage = 24;
    public function review(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    // Accessor untuk rata-rata rate
    public function getAverageRateAttribute()
    {
        return round($this->review->avg('rate'), 1); // dibulatkan ke 1 angka desimal
    }

    public function scopeFilters(Builder $query, array $filters)
    {
        $query->when($filters["search"] ?? false, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where("name", "like", "%$search%")
                    ->orWhere("description", "LIKE", "%$search%");
            });
        });

        $query->when($filters["min"] ?? false, function ($query, $min) {
            return $query->where("price", ">=", $min);
        });

        $query->when($filters["max"] ?? false, function ($query, $max) {
            return $query->where("price", "<=", $max);
        });

        $query->when($filters["category"] ?? false, function ($query, $category) {
            return $query->whereHas("category", function ($q) use ($category) {
                $q->where("slug", $category);
            });
        });
    }
}
