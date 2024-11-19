<?php

namespace App\Exports;

use App\Models\PendaftaransSkripsiJurnal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class PendaftaranSkripsiJurnalExport implements FromCollection, WithHeadings, WithStyles, WithMapping, WithColumnWidths
{
    private $rowNumber = 0;

    public function collection()
    {
        return PendaftaransSkripsiJurnal::with(['dosenketuapenguji', 'dosenpenguji', 'dosenpembimbing', 'mahasiswa'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Mahasiswa',
            'Peminatan',
            'Judul Skripsi',
            'Ketua Penguji',
            'Penguji',
            'Pembimbing',
            'Tempat',
            'Tanggal',
            'Waktu',
            'Selesai',
            'Link Spreadsheet',
            'File Persetujuan Pendaftaran',
            'Dokumen Pendaftaran Ujian',
            'Kartu Bimbingan',
            'Kartu Rencana Studi',
            'Transkrip Nilai',
            'Bebas Biaya Administrasi',
            'Bebas Pinjaman Perpustakaan',
            'Ijazah Terakhir',
            'Fotocopy TOEFL',
            'Input SKPI',
            'Draft Skripsi',
            'Artikel Ilmiah',
            'File Turnitin',
            'Bukti Pendaftaran SIADIN',
            'Nilai'
          
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style the header row with a background color and bold text
        $sheet->getStyle('A1:AA1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4CAF50'], // Example: green background
            ],
        ]);

        return [];
    }

    public function map($item): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $item->mahasiswa->nama ?? '',
            $item->peminatan,
            $item->judul_skripsi,
            $item->dosenketuapenguji->nama ?? '',
            $item->dosenpenguji->nama ?? '',
            $item->dosenpembimbing->nama ?? '',
            $item->tempat,
            $item->tanggal,
            $item->waktu,
            $item->selesai,
            $item->link_spredsheet,
            $item->file_persetujuan_pendaftaran_sidang_skripsi ? config('app.url') . '/' . $item->file_persetujuan_pendaftaran_sidang_skripsi : '',
            $item->dokumen_pendaftaran_ujian_skripsi ? config('app.url') . '/' . $item->dokumen_pendaftaran_ujian_skripsi : '',
            $item->kartu_bimbingan ? config('app.url') . '/' . $item->kartu_bimbingan : '',
            $item->dokumen_kartu_rencana_studi ? config('app.url') . '/' . $item->dokumen_kartu_rencana_studi : '',
            $item->dokumen_transkrip_nilai ? config('app.url') . '/' . $item->dokumen_transkrip_nilai : '',
            $item->dokumen_bebas_biaya_administrasi ? config('app.url') . '/' . $item->dokumen_bebas_biaya_administrasi : '',
            $item->dokumen_bebas_pinjaman_perpustakaan ? config('app.url') . '/' . $item->dokumen_bebas_pinjaman_perpustakaan : '',
            $item->dokumen_ijazah_terakhir ? config('app.url') . '/' . $item->dokumen_ijazah_terakhir : '',
            $item->dokumen_fotocopy_toefl ? config('app.url') . '/' . $item->dokumen_fotocopy_toefl : '',
            $item->dokumen_input_skpi ? config('app.url') . '/' . $item->dokumen_input_skpi : '',
            $item->draft_skripsi ? config('app.url') . '/' . $item->draft_skripsi : '',
            $item->dokumen_artikel_ilmiah ? config('app.url') . '/' . $item->dokumen_artikel_ilmiah : '',
            $item->file_turnitin ? config('app.url') . '/' . $item->file_turnitin : '',
            $item->bukti_pendaftaran_siadin ? config('app.url') . '/' . $item->bukti_pendaftaran_siadin : '',
            $item->nilai,
        
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // Mahasiswa
            'C' => 15,  // Peminatan
            'D' => 40,  // Judul Skripsi
            'E' => 20,  // Ketua Penguji
            'F' => 20,  // Penguji
            'G' => 20,  // Pembimbing
            'H' => 15,  // Tempat
            'I' => 15,  // Tanggal
            'J' => 10,  // Waktu
            'K' => 10,  // Selesai
            'L' => 30,  // Link Spreadsheet
            'M' => 10,  // Nilai
            'N' => 50,  // File Persetujuan
            'O' => 50,  // Dokumen Pendaftaran
            'P' => 50,  // Kartu Bimbingan
            'Q' => 50,  // KRS
            'R' => 50,  // Transkrip
            'S' => 50,  // Bebas Biaya
            'T' => 50,  // Bebas Perpus
            'U' => 50,  // Ijazah
            'V' => 50,  // TOEFL
            'W' => 50,  // SKPI
            'X' => 50,  // Draft
            'Y' => 50,  // Artikel
            'Z' => 50,  // Turnitin
            'AA' => 50, // SIADIN
           
        ];
    }
}
