<?php

namespace App\Exports;

use App\Models\PendaftaranSurat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class PendaftaranSuratExport implements FromCollection, WithHeadings, WithStyles, WithMapping, WithColumnWidths
{
    private $rowNumber = 0;

    public function collection()
    {
        return PendaftaranSurat::with(['mahasiswa'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Mahasiswa',
            'Tujuan Surat',
            'Judul Skripsi',
            'Data untuk Dinkes',
            'Surat',
            'Sub Surat',
            'Mahasiswa Payung',
            'No Surat',
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
        
        // Extract 'nama' and 'nim' from mahasiswa_payung and format as 'nama (nim)'
        $mahasiswaPayungNames = collect($item->mahasiswa_payung)->map(function ($payung) {
            return $payung['nama'] . ' (' . $payung['nim'] . ')';
        })->implode(', ');

        return [
            $this->rowNumber,
            $item->mahasiswa->nama ?? '',
            $item->tujuan_surat,
            $item->judul_skripsi,
            $item->data_diperlukan_jika_ditujukan_ke_dinkes,
            $item->surat,
            $item->sub_surat,
            $mahasiswaPayungNames, // Formatted 'nama (nim)'
            $item->no_surat,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // Mahasiswa
            'C' => 25,  // Tujuan Surat
            'D' => 30,  // Judul Skripsi
            'E' => 30,  // Data untuk Dinkes
            'F' => 15,  // Surat
            'G' => 15,  // Sub Surat
            'H' => 30,  // Mahasiswa Payung
            'K' => 15,  // No Surat
        ];
    }
}
