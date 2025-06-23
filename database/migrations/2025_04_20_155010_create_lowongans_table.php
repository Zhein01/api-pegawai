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
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('perusahaan');
            $table->string('lokasi');
            $table->string('periode');
            $table->string('deskripsi');
            $table->string('kualifikasi');
            $table->string('batch_soal_id')->nullable();
            $table->boolean('selesai')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }

};
