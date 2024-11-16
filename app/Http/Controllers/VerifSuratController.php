<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranSurat;
use App\Models\MasterDosen;
use App\Models\MasterMahasiswa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\PendaftaranSuratExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Routing\Controller;

class VerifSuratController extends Controller
{
    public function exportsurat()
    {
        return Excel::download(new PendaftaranSuratExport, 'pendaftaran_surat.xlsx');
    }
    public function index()
    {
        $pendaftaranSurats = PendaftaranSurat::with(['mahasiswa'])
            ->get();

        return view('pageadmin.surat.index', compact('pendaftaranSurats'));
    }

    public function detail($id)
    {
        $pendaftaransurat = PendaftaranSurat::with(['mahasiswa'])
        ->findOrFail($id);
        return view('pageadmin.surat.detail', compact('pendaftaransurat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'no_surat' => 'nullable',
            'komentar' => 'nullable',
           
        ]);

        $pendaftaranSurat = PendaftaranSurat::findOrFail($id);

      

        // Update the rest of the data
        $pendaftaranSurat->update([
            'status' => $request->status,
            'no_surat' => $request->no_surat,
            'komentar' => $request->komentar,
        ]);

        // Success alert
        Alert::success('Sukses', 'Status pendaftaran Surat berhasil diperbarui.');
        return redirect()->route('verifsurat.index');
    }
}
