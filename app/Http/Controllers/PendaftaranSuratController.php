<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranSurat;
use App\Models\MasterMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Routing\Controller;

class PendaftaranSuratController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = auth()->user();
    
        // // Cari data mahasiswa berdasarkan user yang sedang login
        // $mahasiswa = MasterMahasiswa::where('user_id', $user->id)->first();
    
        // // Jika data mahasiswa tidak ditemukan, redirect kembali dengan pesan error
        // if (!$mahasiswa) {
        //     return redirect()->back()->with('error', 'Mahasiswa tidak ditemukan.');
        // }
    
        // Ambil data PendaftaranSurat berdasarkan mahasiswa_id
        $pendaftaranSurats = PendaftaranSurat::where('mahasiswa_id', $user->id)->get();
    
        // Tampilkan view dengan data yang telah diambil
        return view('pagemahasiswa.surat.index', compact('pendaftaranSurats'));
    }
    
    
    public function create()
    {
        // Fetch the currently authenticated user's Mahasiswa
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();


        return view('pagemahasiswa.surat.create', compact('mahasiswa'));
    }


    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'tujuan_surat' => 'required|string|max:255',
            'judul_skripsi' => 'required|string|max:255',
            'data_diperlukan_jika_ditujukan_ke_dinkes' => 'nullable',
            'surat' => 'required|string|max:255',
            'sub_surat' => 'required|string|max:255',
            'mahasiswa_payung' => 'nullable|array',  // Validate as array
            'no_surat' => 'nullable',
            'komentar' => 'nullable',
        ]);

        // Create new PendaftaranSurat record
        $pendaftaranSurat = new PendaftaranSurat();
        $pendaftaranSurat->mahasiswa_id = auth()->user()->id;
        $pendaftaranSurat->tujuan_surat = $request->tujuan_surat;
        $pendaftaranSurat->judul_skripsi = $request->judul_skripsi;
        $pendaftaranSurat->data_diperlukan_jika_ditujukan_ke_dinkes = $request->data_diperlukan_jika_ditujukan_ke_dinkes;
        $pendaftaranSurat->surat = $request->surat;
        $pendaftaranSurat->sub_surat = $request->sub_surat;
        $pendaftaranSurat->mahasiswa_payung = $request->mahasiswa_payung;  // Store as JSON
        $pendaftaranSurat->no_surat = $request->no_surat;
        $pendaftaranSurat->komentar = $request->komentar;
        $pendaftaranSurat->status = 'pending'; // Default to pending

        // Save to database
        $pendaftaranSurat->save();

        // Success alert
        Alert::success('Sukses', 'Data pendaftaran surat berhasil ditambah.');
        return redirect()->route('pendaftaransurat.index');
    }



    public function show($id)
    {
        $pendaftaranSurat = PendaftaranSurat::findOrFail($id);
        return view('pagemahasiswa.surat.show', compact('pendaftaranSurat'));
    }

    public function edit($id)
    {
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();

        $pendaftaransurat = PendaftaranSurat::findOrFail($id);
        return view('pagemahasiswa.surat.edit', compact('pendaftaransurat', 'mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'tujuan_surat' => 'required|string|max:255',
            'judul_skripsi' => 'required|string|max:255',
            'data_diperlukan_jika_ditujukan_ke_dinkes' => 'nullable',
            'surat' => 'required|string|max:255',
            'sub_surat' => 'required|string|max:255',
            'mahasiswa_payung' => 'nullable|array',  // Validate as array
            'no_surat' => 'nullable',
            'komentar' => 'nullable',
        ]);

        // Find the existing record
        $pendaftaranSurat = PendaftaranSurat::findOrFail($id);

        // Update the rest of the data
        $pendaftaranSurat->update([
            'tujuan_surat' => $request->tujuan_surat,
            'judul_skripsi' => $request->judul_skripsi,
            'data_diperlukan_jika_ditujukan_ke_dinkes' => $request->data_diperlukan_jika_ditujukan_ke_dinkes,
            'surat' => $request->surat,
            'sub_surat' => $request->sub_surat,
            'mahasiswa_payung' => $request->mahasiswa_payung,  // Store as JSON
            'no_surat' => $request->no_surat,
            'komentar' => $request->komentar,
            'status' => 'pending',
        ]);

        // Success alert
        Alert::success('Sukses', 'Data pendaftaran surat berhasil diperbarui.');
        return redirect()->route('pendaftaransurat.index');
    }




    public function destroy($id)
    {
        $pendaftaranSurat = PendaftaranSurat::findOrFail($id);



        // Delete the record from the database
        $pendaftaranSurat->delete();

        // Success alert
        Alert::success('Sukses', 'Data pendaftaran surat dan semua dokumen terkait berhasil dihapus.');
        return redirect()->route('pendaftaransurat.index');
    }
}
