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
        Schema::create('pendaftaran_surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id');
            $table->string('tujuan_surat');
            $table->string('judul_skripsi');
            $table->string('data_diperlukan_jika_ditujukan_ke_dinkes')->nullable();
            $table->string('surat');
            $table->string('sub_surat');
            $table->json('mahasiswa_payung')->nullable(); // ubah menjadi json
            $table->string('status')->nullable();
            $table->string('no_surat')->nullable();
            $table->string('komentar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_surats');
    }
};
