<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranSkpi extends Model
{
    use HasFactory;

    // Defining the fillable fields that can be mass assigned
    protected $fillable = [
        'mahasiswa_id',
        'peminatan',
        'tempat_tanggal_lahir',
        'skors',  // Will store selected skors from SkorsSkpi
        'skors_translate',  // Will store selected skors from SkorsSkpi
        'dokumen_kegiatan',
        'tanggal_masuk',
        'bulan_masuk',
        'tahun_masuk',
        'tanggal_kelulusan',
        'bulan_kelulusan',
        'tahun_kelulusan',
        'nomor_ijazah_nasional',
        'status_akreditasi',
        'nomor_akreditasi',
        'jenis_program_pendidikan',
        'komentar',
        'status',
    ];

    // Cast 'skors' as an array
    protected $casts = [
        'skors' => 'array',
        'skors_translate' => 'array',
    ];

    // Relationship to MasterMahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(MasterMahasiswa::class, 'mahasiswa_id', 'user_id');
    }

    // Relationship to SkorsSkpi (Many-to-Many Relationship)
  
}
