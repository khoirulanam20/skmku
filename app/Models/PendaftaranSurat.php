<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranSurat extends Model
{
    use HasFactory;
    protected $fillable = [
        'mahasiswa_id',
        'tujuan_surat',
        'judul_skripsi',
        'data_diperlukan_jika_ditujukan_ke_dinkes',
        'surat',
        'sub_surat',
        'mahasiswa_payung',
        'berita_acara',
        'ethical_clearance',
        'status',
        'no_surat',
        'komentar'
    ];

    // Casting kolom mahasiswa_payung menjadi array
    protected $casts = [
        'mahasiswa_payung' => 'array',
    ];
    public function mahasiswa()
    {
        return $this->belongsTo(MasterMahasiswa::class, 'mahasiswa_id', 'user_id');
    }
    
}
