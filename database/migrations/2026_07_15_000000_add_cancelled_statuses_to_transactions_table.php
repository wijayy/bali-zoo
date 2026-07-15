<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql')->table('transactions', function (Blueprint $table) {
            $table->enum('status', ['ordered', 'paid', 'shipping', 'received', 'canceled', 'expired'])->change();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->table('transactions', function (Blueprint $table) {
            $table->enum('status', ['ordered', 'paid', 'shipping', 'received'])->change();
        });
    }
};
