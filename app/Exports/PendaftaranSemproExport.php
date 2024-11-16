<?php

namespace App\Exports;

use App\Models\PendaftaranSempro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class PendaftaranSemproExport implements FromCollection, WithHeadings, WithStyles, WithMapping, WithColumnWidths
{
    private $rowNumber = 0;

    public function collection()
    {
        return PendaftaranSempro::with(['dosenpembimbing', 'dosenpenguji', 'dosenadvisor', 'mahasiswa'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Mahasiswa',
            'Pembimbing',
            'Penguji',
            'Advisor',
            'Judul Proposal',
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
        $sheet->getStyle('A1:K1')->applyFromArray([
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
            $item->dosenpembimbing->nama ?? '',
            $item->dosenpenguji->nama ?? '',
            $item->dosenadvisor->nama ?? '',
            $item->judul_proposal,
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
            'C' => 20,  // Pembimbing
            'D' => 20,  // Penguji
            'E' => 20,  // Advisor
            'F' => 40,  // Judul Proposal
            'G' => 20,  // Tempat
            'H' => 15,  // Tanggal
            'I' => 10,  // Waktu
            'J' => 10,  // Selesai
            'K' => 30,  // Link Spreadsheet
        ];
    }
}
