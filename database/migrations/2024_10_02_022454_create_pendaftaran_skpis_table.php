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
        Schema::create('pendaftaran_skpis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id');
            $table->string('peminatan');
            $table->string('tempat_tanggal_lahir');
            $table->json('skors');
            $table->json('skors_translate')->nullable();
            $table->string('dokumen_kegiatan');

            // Adding nullable fields for "masuk"
            $table->date('tanggal_masuk')->nullable();
            $table->string('bulan_masuk', 7)->nullable(); // VARCHAR(7) to store 'YYYY-MM'
            $table->string('tahun_masuk', 4)->nullable();  // VARCHAR(4) to store 'YYYY'

            // Adding nullable fields for "kelulusan"
            $table->date('tanggal_kelulusan')->nullable();
            $table->string('bulan_kelulusan', 7)->nullable(); // VARCHAR(7) to store 'YYYY-MM'
            $table->string('tahun_kelulusan', 4)->nullable(); // VARCHAR(4) to store 'YYYY'


            // Adding nullable fields for "nomor ijazah nasional" and "akreditasi"
            $table->string('nomor_ijazah_nasional')->nullable();
            $table->string('status_akreditasi')->nullable();
            $table->string('nomor_akreditasi')->nullable();

            // Adding nullable fields for "jenis pendidikan" and "program pendidikan"
            $table->string('jenis_program_pendidikan')->nullable();

            // Adding nullable fields for "komentar"
            $table->string('komentar')->nullable();

            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_skpis');
    }
};
