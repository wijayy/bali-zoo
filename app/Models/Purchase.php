<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseFactory> */
    use HasFactory,  Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'purchase_number'
            ]
        ];
    }

    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public static function generatePurchaseNumber()
    {
        $date = now()->format('Ymd');
        $lastPurchase = self::where('purchase_number', 'like', "PO-{$date}-%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastPurchase) {
            $lastNumber = (int) substr($lastPurchase->purchase_number, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "PO-{$date}-{$newNumber}";
    }
}
