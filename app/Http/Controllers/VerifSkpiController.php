<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranSkpi;
use App\Models\MasterMahasiswa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\PendaftaranSkpiExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Routing\Controller;

class VerifSkpiController extends Controller
{
    public function exportskpi()
    {
        return Excel::download(new PendaftaranSkpiExport, 'pendaftaran_skpi.xlsx');
    }
    public function index()
{
    $PendaftaranSkpis = PendaftaranSkpi::with(['mahasiswa'])
        ->orderBy('created_at', 'desc') // Order by created_at in descending order
        ->get();

    return view('pageadmin.skpi.index', compact('PendaftaranSkpis'));
}


    public function detail($id)
    {
        $pendaftaranskpi = PendaftaranSkpi::with(['mahasiswa'])
            ->findOrFail($id);
        $skors_translate = json_decode($pendaftaranskpi->skors_translate, true);

        return view('pageadmin.skpi.detail', compact('pendaftaranskpi', 'skors_translate'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required|string|max:255',
        'tanggal_masuk' => 'nullable|date',
        'bulan_masuk' => 'nullable',
        'tahun_masuk' => 'nullable|integer',
        'tanggal_kelulusan' => 'nullable|date',
        'bulan_kelulusan' => 'nullable',
        'tahun_kelulusan' => 'nullable|integer',
        'nomor_ijazah_nasional' => 'nullable|string|max:50',
        'status_akreditasi' => 'nullable|string|max:50',
        'nomor_akreditasi' => 'nullable|string|max:50',
        'jenis_program_pendidikan' => 'nullable|string|max:50',
        'komentar' => 'nullable|string',
        'skors_translate' => 'nullable|array', // Ensure it's an array for JSON encoding
    ]);

    try {
        $pendaftaranskpi = PendaftaranSkpi::findOrFail($id);

        // Handle `skors_translate` translations, setting empty values to null
        if ($request->has('skors_translate')) {
            $skors_translate = $request->input('skors_translate');
            foreach ($skors_translate as &$translation) {
                foreach ($translation as $key => $value) {
                    $translation[$key] = $value !== '' ? $value : null;
                }
            }
            $pendaftaranskpi->skors_translate = json_encode($skors_translate);
        }

        // Update other fields
        $pendaftaranskpi->update([
            'status' => $request->status,
            'tanggal_masuk' => $request->tanggal_masuk,
            'bulan_masuk' => $request->bulan_masuk,
            'tahun_masuk' => $request->tahun_masuk,
            'tanggal_kelulusan' => $request->tanggal_kelulusan,
            'bulan_kelulusan' => $request->bulan_kelulusan,
            'tahun_kelulusan' => $request->tahun_kelulusan,
            'nomor_ijazah_nasional' => $request->nomor_ijazah_nasional,
            'status_akreditasi' => $request->status_akreditasi,
            'nomor_akreditasi' => $request->nomor_akreditasi,
            'jenis_program_pendidikan' => $request->jenis_program_pendidikan,
            'komentar' => $request->komentar,
        ]);

        Alert::success('Sukses', 'Status pendaftaran SKPI berhasil diperbarui');
        return redirect()->route('verifskpi.index');

    } catch (\Exception $e) {
        Alert::error('Gagal', 'Gagal memperbarui status: ' . $e->getMessage());
        return redirect()->route('verifskpi.index')->withErrors(['update_failed' => 'Failed to update status: ' . $e->getMessage()]);
    }
}

}
