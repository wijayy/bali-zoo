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
        Schema::connection('mysql2')->create('coupon_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Coupon::class)->constrained();
            $table->foreignIdFor(Transaction::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('coupon_transactions');
    }
};
