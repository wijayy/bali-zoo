<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Banner extends Model
{
    /** @use HasFactory<\Database\Factories\BannerFactory> */
    use HasFactory, Sluggable;

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

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'name',
        'slug',
        'image',
        'startShow',
        'endShow',
    ];

    protected $casts = [
        'startShow' => 'datetime',
        'endShow' => 'datetime',
    ];

    public function isActive(): bool
    {
        $now = now();
        return $this->startShow <= $now && $this->endShow >= $now;
    }

    public function scopeFilters(Builder $query, array $filters)
    {
        $query->when($filters['name'] ?? false, function (Builder $query, $name) {
            return $query->where('name', 'like', "%{$name}%");
        });

        $query->when($filters['active'] ?? false, function (Builder $query, $active) {
            if ($active === 'active') {
                return $query->where('startShow', '<=', now())
                    ->where('endShow', '>=', now());
            }

            if ($active === 'inactive') {
                return $query->where(function (Builder $query) {
                    $query->where('startShow', '>', now())
                        ->orWhere('endShow', '<', now());
                });
            }

            return $query;
        });
    }
}
