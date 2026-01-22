<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponProduct extends Model
{
    /** @use HasFactory<\Database\Factories\CouponProductFactory> */
    use HasFactory;

    protected $connection = 'mysql2';

    protected $guarded = ['id'];
}
