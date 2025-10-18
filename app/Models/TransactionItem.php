<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionItemFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function transacction() {
        return $this->belongsTo(Transaction::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
