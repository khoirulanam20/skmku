<?php

namespace App\Exports;

use App\Models\PendaftaranSkripsi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class PendaftaranSkripsiExport implements FromCollection, WithHeadings, WithStyles, WithMapping, WithColumnWidths
{
    private $rowNumber = 0;

    public function collection()
    {
        return PendaftaranSkripsi::with(['dosenketuapenguji', 'dosenpenguji', 'dosenpembimbing', 'mahasiswa'])->get();
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
          
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style the header row with a background color and bold text
        $sheet->getStyle('A1:N1')->applyFromArray([
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
           
        ];
    }
}
