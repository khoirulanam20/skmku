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
        Schema::create('pendaftaran_skripsis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id');
            $table->string('peminatan');
            $table->string('judul_skripsi');
            $table->foreignId('ketua_penguji_id');
            $table->foreignId('penguji_id');
            $table->foreignId('pembimbing_id');
            $table->string('file_persetujuan_pendaftaran_sidang_skripsi')->nullable();
            $table->string('dokumen_pendaftaran_ujian_skripsi')->nullable();
            $table->string('kartu_bimbingan')->nullable();
            $table->string('dokumen_kartu_rencana_studi')->nullable();
            $table->string('dokumen_transkrip_nilai')->nullable();
            $table->string('dokumen_bebas_biaya_administrasi')->nullable();
            $table->string('dokumen_bebas_pinjaman_perpustakaan')->nullable();
            $table->string('dokumen_ijazah_terakhir')->nullable();
            $table->string('dokumen_fotocopy_toefl')->nullable();
            $table->string('dokumen_input_skpi')->nullable();
            $table->string('draft_skripsi')->nullable();
            $table->string('dokumen_artikel_ilmiah')->nullable();
            $table->string('file_turnitin')->nullable();
            $table->string('bukti_pendaftaran_siadin')->nullable();
            $table->string('tempat')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('waktu')->nullable();
            $table->string('selesai')->nullable();
            $table->string('link_spredsheet')->nullable();
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
        Schema::dropIfExists('pendaftaran_skripsis');
    }
};
