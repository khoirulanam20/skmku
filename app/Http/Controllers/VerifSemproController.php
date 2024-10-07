<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranSempro;
use App\Models\MasterDosen;
use App\Models\MasterMahasiswa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Routing\Controller;

class VerifSemproController extends Controller
{
    public function index()
    {
        // Fetch seminar proposals with associated dosen and mahasiswa data
        $pendaftaranSempros = PendaftaranSempro::with(['dosenpembimbing', 'dosenpenguji', 'dosenadvisor','mahasiswa'])
            ->get();

        return view('pageadmin.sempro.index', compact('pendaftaranSempros'));
    }

    public function detail($id)
    {
        $pendaftaransempro = PendaftaranSempro::with(['dosenpembimbing', 'dosenpenguji', 'dosenadvisor'])
        ->findOrFail($id);
        return view('pageadmin.sempro.detail', compact('pendaftaransempro'));
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

        $pendaftaranSempro = PendaftaranSempro::findOrFail($id);

      

        // Update the rest of the data
        $pendaftaranSempro->update([
            'status' => $request->status,
            'tempat' => $request->tempat,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'link_spredsheet' => $request->link_spredsheet,
            'komentar' => $request->komentar,
        ]);

        // Success alert
        Alert::success('Sukses', 'Status pendaftaran seminar proposal berhasil diperbarui.');
        return redirect()->route('verifsempro.index');
    }
}
