<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\CouponTransactionFactory> */
    use HasFactory;

    protected $connection = 'mysql2';

    protected $guarded = ['id'];
}
