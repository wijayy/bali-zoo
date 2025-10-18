<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengirimen', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Transaction::class)->constrained();
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->integer('district_id');
            $table->string('village');
            $table->string('postal_code');
            $table->string(column: 'awb')->nullable();
            $table->string('resi')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimen');
    }
};
