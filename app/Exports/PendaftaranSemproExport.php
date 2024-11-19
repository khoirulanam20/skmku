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
            'Kartu Bimbingan',
            'Kehadiran Seminar',
            'Turnitin',
            'Pendaftaran Seminar',
            'Draf Proposal',
            'Nilai',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style the header row with a background color and bold text
        $sheet->getStyle('A1:Q1')->applyFromArray([
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
            config('app.url').'/'.$item->dokumen_kartu_bimbingan,
            config('app.url').'/'.$item->dokumen_kehadiran_seminar_proposal,
            config('app.url').'/'.$item->dokumen_turnitin,
            config('app.url').'/'.$item->dokumen_pendaftaran_seminar_proposal,
            config('app.url').'/'.$item->draf_proposal,
            $item->nilai,
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
            'L' => 30,  // Kartu Bimbingan
            'M' => 30,  // Kehadiran Seminar
            'N' => 30,  // Turnitin
            'O' => 30,  // Pendaftaran Seminar
            'P' => 30,  // Draf Proposal
            'Q' => 10,  // Nilai
        ];
    }
}
