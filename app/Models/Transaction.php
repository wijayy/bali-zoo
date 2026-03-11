<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, Sluggable;

    protected $connection = 'mysql';

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'transaction_number'
            ]
        ];
    }

    protected $guarded = ['id'];

    public static function transactionNumberGenerator()
    {
        $date = Carbon::now()->format('Ymd');
        $prefix = 'TRX' . $date;

        // Hitung jumlah transaksi yang sudah ada hari ini
        $lastTransaction = self::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->number, -4);
            $nextNumber = $lastNumber + 1;
        }

        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return $prefix . $formattedNumber;
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function couponUsage()
    {
        return $this->hasOne(CouponTransaction::class);
    }

    

    /**
     * Apply array-based filters (mimicking product.scopeFilters template).
     * Allowed keys: 'date' (created_at), 'number' (transaction_number contains).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilters($query, array $filters)
    {
        $query->when($filters['date'] ?? false, function ($q, $date) {
            return $q->whereDate('created_at', $date);
        });

        $query->when($filters['number'] ?? false, function ($q, $number) {
            return $q->where('transaction_number', 'like', "%{$number}%");
        });
    }
}
