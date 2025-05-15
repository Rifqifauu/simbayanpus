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
        Schema::create('otp', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('admin_id'); // ID admin pembuat OTP
        $table->string('otp', 6);               // 6 digit kode OTP
        $table->timestamp('start_time');        // Waktu OTP mulai aktif
        $table->timestamp('end_time');          // Waktu OTP kedaluwarsa
        $table->timestamps();
        $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
                Schema::dropIfExists('otps');

    }
};
