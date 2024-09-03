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
        Schema::create('izin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('jenis_izin');
            $table->string('alasan');
            $table->string('komentar')->nullable();
            $table->enum('status', ['diajukan', 'ditolak', 'direvisi', 'diterima', 'dibatalkan'])->default('diajukan');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin');
    }
};
