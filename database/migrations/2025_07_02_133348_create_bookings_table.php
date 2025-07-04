<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->uuid('tour_id');
            $table->date('booking_date');
            $table->decimal('total_price', 12, 2);
            $table->string('status')->default('pending');
            $table->string('payment_method')->nullable(); // BCA, BNI, dll
            $table->string('payment_proof')->nullable();  // path bukti transfer
            $table->timestamp('paid_at')->nullable();     // waktu pembayaran
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
