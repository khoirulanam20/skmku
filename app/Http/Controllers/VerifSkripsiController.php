<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranSkripsi;
use App\Models\MasterDosen;
use App\Models\MasterMahasiswa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Routing\Controller;

class VerifSkripsiController extends Controller
{
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
        return view('pageadmin.skripsi.detail', compact('pendaftaranskripsi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'tempat' => 'nullable',
            'tanggal' => 'nullable',
            'waktu' => 'nullable',
            'link_spredsheet' => 'nullable',
            'komentar' => 'nullable',
           
        ]);

        $pendaftaranSkripsi = PendaftaranSkripsi::findOrFail($id);

      

        // Update the rest of the data
        $pendaftaranSkripsi->update([
            'status' => $request->status,
            'tempat' => $request->tempat,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'link_spredsheet' => $request->link_spredsheet,
            'komentar' => $request->komentar,
        ]);

        // Success alert
        Alert::success('Sukses', 'Status pendaftaran skripsi berhasil diperbarui.');
        return redirect()->route('verifskripsi.index');
    }
}
