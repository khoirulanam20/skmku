<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranSkripsi;
use App\Models\MasterDosen;
use App\Models\MasterLink;
use App\Models\MasterMahasiswa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\PendaftaranSkripsiExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Routing\Controller;

class VerifSkripsiController extends Controller
{
    public function exportskripsi()
    {
        return Excel::download(new PendaftaranSkripsiExport, 'pendaftaran_skripsi.xlsx');
    }
    public function index()
    {
        // Fetch seminar proposals with associated dosen and mahasiswa data
        $pendaftaranSkripsis = PendaftaranSkripsi::with(['dosenpembimbing', 'dosenpenguji', 'dosenketuapenguji','mahasiswa'])
            ->get();

        return view('pageadmin.skripsi.index', compact('pendaftaranSkripsis'));
    }

    public function detail($id)
    {
        $pendaftaranskripsi = PendaftaranSkripsi::with(['dosenpembimbing', 'dosenpenguji', 'dosenketuapenguji'])
        ->findOrFail($id);
        $link = MasterLink::all();

        return view('pageadmin.skripsi.detail', compact('pendaftaranskripsi','link'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'tempat' => 'nullable',
            'tanggal' => 'nullable',
            'waktu' => 'nullable',
            'selesai' => 'nullable',
            'link_spredsheet' => 'nullable',
            'komentar' => 'nullable',
            'nilai' => 'nullable',
        ]);

        $pendaftaranSkripsi = PendaftaranSkripsi::findOrFail($id);

      

        // Update the rest of the data
        $pendaftaranSkripsi->update([
            'status' => $request->status,
            'tempat' => $request->tempat,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'selesai' => $request->selesai,
            'link_spredsheet' => $request->link_spredsheet,
            'komentar' => $request->komentar,
            'nilai' => $request->nilai,
        ]);

        // Success alert
        Alert::success('Sukses', 'Status pendaftaran skripsi berhasil diperbarui.');
        return redirect()->route('verifskripsi.index');
    }
}
