<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranSkripsi extends Model
{
    use HasFactory;
    protected $fillable = [
        'mahasiswa_id',
        'peminatan',
        'judul_skripsi',
        'ketua_penguji_id',
        'penguji_id',
        'pembimbing_id',
        'file_persetujuan_pendaftaran_sidang_skripsi',
        'dokumen_pendaftaran_ujian_skripsi',
        'kartu_bimbingan',
        'dokumen_kartu_rencana_studi',
        'dokumen_transkrip_nilai',
        'dokumen_bebas_biaya_administrasi',
        'dokumen_bebas_pinjaman_perpustakaan',
        'dokumen_ijazah_terakhir',
        'dokumen_fotocopy_toefl',
        'dokumen_input_skpi',
        'draft_skripsi',
        'dokumen_artikel_ilmiah',
        'file_turnitin',
        'bukti_pendaftaran_siadin',
        'tempat',
        'tanggal',
        'waktu',
        'selesai',
        'link_spredsheet',
        'komentar',
        'status',
    ];

    // Define the relationships
    
    public function dosenketuapenguji()
    {
        return $this->belongsTo(MasterDosen::class, 'ketua_penguji_id', 'user_id'); // Memastikan bahwa 'advisor_id' merujuk ke 'user_id' di MasterDosen
    }
    public function dosenpenguji()
    {
        return $this->belongsTo(MasterDosen::class, 'penguji_id', 'user_id'); // Memastikan bahwa 'penguji_id' merujuk ke 'user_id' di MasterDosen
    }
    public function dosenpembimbing()
    {
        return $this->belongsTo(MasterDosen::class, 'pembimbing_id', 'user_id'); // Memastikan bahwa 'pembimbing_id' merujuk ke 'user_id' di MasterDosen
    }
    

    public function mahasiswa()
    {
        return $this->belongsTo(MasterMahasiswa::class, 'mahasiswa_id', 'user_id');
    }
}
