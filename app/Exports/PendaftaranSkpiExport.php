<?php

namespace App\Exports;

use App\Models\PendaftaranSkpi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class PendaftaranSkpiExport implements FromCollection, WithHeadings, WithStyles, WithMapping, WithColumnWidths
{
    private $rowNumber = 0;

    public function collection()
    {
        return PendaftaranSkpi::with(['mahasiswa'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Mahasiswa',
            'Peminatan',
            'Tanggal Masuk',
            'Tanggal Kelulusan',
            'Skors',
            'Total Skor',  // Add new heading for total skor
            'Nomor Ijazah Nasional',
            'Status Akreditasi',
            'Nomor Akreditasi',
            'Jenis Program Pendidikan',
        ];
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4CAF50'],
            ],
        ]);

        return [];
    }

    public function map($item): array
    {
        $this->rowNumber++;

        // Decode JSON strings
        $skors = json_decode($item->skors, true) ?? [];
        $skorsTranslate = json_decode($item->skors_translate, true) ?? [];

        // Format skors
        $formattedSkors = collect($skors)->map(function ($skor, $index) use ($skorsTranslate) {
            $judulKegiatan = $skor['judul_kegiatan'] ?? '-';
            $judulTranslate = $skorsTranslate[$index]['judul_kegiatan_translate'] ?? '-';

            $namaKategori = $skor['nama_kategori'] ?? '-';
            $kategoriTranslate = $skorsTranslate[$index]['nama_kategori_translate'] ?? '-';

            return "{$judulKegiatan}/{$judulTranslate},{$namaKategori}/{$kategoriTranslate}";
        })->implode("\n"); // Use "\n" to insert line breaks for Excel

        // Calculate total score
        $totalSkor = collect($skors)->sum('skor'); // Sum all 'skor' values

        return [
            $this->rowNumber,
            $item->mahasiswa->nama ?? '',
            $item->peminatan,
            $item->tanggal_masuk ? $item->tanggal_masuk . '/' . $item->bulan_masuk . '/' . $item->tahun_masuk : '-',
            $item->tanggal_kelulusan ? $item->tanggal_kelulusan . '/' . $item->bulan_kelulusan . '/' . $item->tahun_kelulusan : '-',
            $formattedSkors,
            $totalSkor, // Add total skor field here
            $item->nomor_ijazah_nasional,
            $item->status_akreditasi,
            $item->nomor_akreditasi,
            $item->jenis_program_pendidikan,
        ];
    }


    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // Mahasiswa
            'C' => 25,  // Peminatan
            'D' => 15,  // Tanggal Masuk
            'E' => 15,  // Tanggal Kelulusan
            'F' => 150, // Skors
            'G' => 10,  // Total Skor (adjusted width)
            'H' => 20,  // Nomor Ijazah Nasional
            'I' => 15,  // Status Akreditasi
            'J' => 20,  // Nomor Akreditasi
            'K' => 25,  // Jenis Program Pendidikan
        ];
    }
}
