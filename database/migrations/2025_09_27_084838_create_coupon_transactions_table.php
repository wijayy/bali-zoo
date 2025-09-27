<?php

use App\Models\Coupon;
use App\Models\Transaction;
use App\Models\Transaksi;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupon_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Coupon::class)->constrained();
            $table->foreignIdFor(Transaction::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_transactions');
    }
};
