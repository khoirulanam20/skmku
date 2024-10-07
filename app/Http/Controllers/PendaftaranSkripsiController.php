<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranSkripsi;
use App\Models\MasterDosen;
use App\Models\MasterMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Routing\Controller;

class PendaftaranSkripsiController extends Controller
{
    public function index()
    {
        // Get the logged-in user
        $user = auth()->user();

        $mahasiswa = MasterMahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa not found.');
        }

        $pendaftaranSkripsis = PendaftaranSkripsi::with(['dosenpembimbing', 'dosenpenguji', 'dosenketuapenguji'])
            ->where('mahasiswa_id', $user->id) // Filter berdasarkan mahasiswa_id
            ->get();



        return view('pagemahasiswa.skripsi.index', compact('pendaftaranSkripsis', 'mahasiswa'));
    }



    public function create()
    {
        // Fetch the currently authenticated user's Mahasiswa
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();

        $dosens = MasterDosen::all(); // Fetch all dosen for select option

        return view('pagemahasiswa.skripsi.create', compact('dosens', 'mahasiswa'));
    }


    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'peminatan' => 'required|string|max:255',
            'judul_skripsi' => 'required|string|max:255',
            'file_persetujuan_pendaftaran_sidang_skripsi' => 'required|file',
            'dokumen_pendaftaran_ujian_skripsi' => 'required|file',
            'kartu_bimbingan' => 'required|file',
            'dokumen_kartu_rencana_studi' => 'required|file',
            'dokumen_transkrip_nilai' => 'required|file',
            'dokumen_bebas_biaya_administrasi' => 'required|file',
            'dokumen_bebas_pinjaman_perpustakaan' => 'required|file',
            'dokumen_ijazah_terakhir' => 'required|file',
            'dokumen_fotocopy_toefl' => 'required|file',
            'dokumen_input_skpi' => 'required|file',
            'draft_skripsi' => 'required|file',
            'dokumen_artikel_ilmiah' => 'required|file',
            'file_turnitin' => 'required|file',
            'bukti_pendaftaran_siadin' => 'required|file',
            'tempat' => 'nullable',
            'tanggal' => 'nullable',
            'waktu' => 'nullable',
            'link_spredsheet' => 'nullable',
            'komentar' => 'nullable',
            'pembimbing_id' => 'required|exists:master_dosens,user_id',
            'ketua_penguji_id' => 'required|exists:master_dosens,user_id',
            'penguji_id' => 'required|exists:master_dosens,user_id',
        ]);

        // Array of documents and their respective directories
        $documents = [
            'file_persetujuan_pendaftaran_sidang_skripsi' => 'dokumen/persetujuan_pendaftaran_sidang_skripsi',
            'dokumen_pendaftaran_ujian_skripsi' => 'dokumen/pendaftaran_ujian_skripsi',
            'kartu_bimbingan' => 'dokumen/kartu_bimbingan',
            'dokumen_kartu_rencana_studi' => 'dokumen/kartu_rencana_studi',
            'dokumen_transkrip_nilai' => 'dokumen/transkrip_nilai',
            'dokumen_bebas_biaya_administrasi' => 'dokumen/bebas_biaya_administrasi',
            'dokumen_bebas_pinjaman_perpustakaan' => 'dokumen/bebas_pinjaman_perpustakaan',
            'dokumen_ijazah_terakhir' => 'dokumen/ijazah_terakhir',
            'dokumen_fotocopy_toefl' => 'dokumen/fotocopy_toefl',
            'dokumen_input_skpi' => 'dokumen/input_skpi',
            'draft_skripsi' => 'dokumen/draft_skripsi',
            'dokumen_artikel_ilmiah' => 'dokumen/artikel_ilmiah',
            'file_turnitin' => 'dokumen/turnitin',
            'bukti_pendaftaran_siadin' => 'dokumen/bukti_pendaftaran_siadin',
        ];


        // Process document uploads
        $uploadedFiles = [];
        foreach ($documents as $inputName => $directory) {
            $uploadedFileName = time() . '_' . $request->file($inputName)->getClientOriginalName();
            $request->file($inputName)->move(public_path($directory), $uploadedFileName);
            $uploadedFiles[$inputName] = $directory . '/' . $uploadedFileName;
        }

        // Create new PendaftaranSempro record
        $pendaftaranSkripsi = new PendaftaranSkripsi();
        $pendaftaranSkripsi->mahasiswa_id = auth()->user()->id;
        $pendaftaranSkripsi->pembimbing_id = $request->pembimbing_id;
        $pendaftaranSkripsi->ketua_penguji_id = $request->ketua_penguji_id;
        $pendaftaranSkripsi->penguji_id = $request->penguji_id;
        $pendaftaranSkripsi->peminatan = $request->peminatan;
        $pendaftaranSkripsi->judul_skripsi = $request->judul_skripsi;
        $pendaftaranSkripsi->file_persetujuan_pendaftaran_sidang_skripsi = $uploadedFiles['file_persetujuan_pendaftaran_sidang_skripsi'];
        $pendaftaranSkripsi->dokumen_pendaftaran_ujian_skripsi = $uploadedFiles['dokumen_pendaftaran_ujian_skripsi'];
        $pendaftaranSkripsi->kartu_bimbingan = $uploadedFiles['kartu_bimbingan'];
        $pendaftaranSkripsi->dokumen_kartu_rencana_studi = $uploadedFiles['dokumen_kartu_rencana_studi'];
        $pendaftaranSkripsi->dokumen_transkrip_nilai = $uploadedFiles['dokumen_transkrip_nilai'];
        $pendaftaranSkripsi->dokumen_bebas_biaya_administrasi = $uploadedFiles['dokumen_bebas_biaya_administrasi'];
        $pendaftaranSkripsi->dokumen_bebas_pinjaman_perpustakaan = $uploadedFiles['dokumen_bebas_pinjaman_perpustakaan'];
        $pendaftaranSkripsi->dokumen_ijazah_terakhir = $uploadedFiles['dokumen_ijazah_terakhir'];
        $pendaftaranSkripsi->dokumen_fotocopy_toefl = $uploadedFiles['dokumen_fotocopy_toefl'];
        $pendaftaranSkripsi->dokumen_input_skpi = $uploadedFiles['dokumen_input_skpi'];
        $pendaftaranSkripsi->draft_skripsi = $uploadedFiles['draft_skripsi'];
        $pendaftaranSkripsi->dokumen_artikel_ilmiah = $uploadedFiles['dokumen_artikel_ilmiah'];
        $pendaftaranSkripsi->file_turnitin = $uploadedFiles['file_turnitin'];
        $pendaftaranSkripsi->bukti_pendaftaran_siadin = $uploadedFiles['bukti_pendaftaran_siadin'];
        $pendaftaranSkripsi->tempat = $request->tempat;
        $pendaftaranSkripsi->tanggal = $request->tanggal;
        $pendaftaranSkripsi->waktu = $request->waktu;
        $pendaftaranSkripsi->link_spredsheet = $request->link_spredsheet;
        $pendaftaranSkripsi->komentar = $request->komentar;
        $pendaftaranSkripsi->status = 'pending'; // Default to pending

        // Save to database
        $pendaftaranSkripsi->save();

        // Success alert
        Alert::success('Sukses', 'Data pendaftaran skripsi berhasil ditambah.');
        return redirect()->route('pendaftaranskripsi.index');
    }


    public function show($id)
    {
        $pendaftaranSkripsi = PendaftaranSkripsi::findOrFail($id);
        return view('pagemahasiswa.skripsi.show', compact('pendaftaranSkripsi'));
    }

    public function edit($id)
    {
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();

        $pendaftaranskripsi = PendaftaranSkripsi::findOrFail($id);
        $dosens = MasterDosen::all();
        return view('pagemahasiswa.skripsi.edit', compact('pendaftaranskripsi', 'dosens', 'mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'peminatan' => 'required|string|max:255',
            'judul_skripsi' => 'required|string|max:255',
            'file_persetujuan_pendaftaran_sidang_skripsi' => 'nullable|file',
            'dokumen_pendaftaran_ujian_skripsi' => 'nullable|file',
            'kartu_bimbingan' => 'nullable|file',
            'dokumen_kartu_rencana_studi' => 'nullable|file',
            'dokumen_transkrip_nilai' => 'nullable|file',
            'dokumen_bebas_biaya_administrasi' => 'nullable|file',
            'dokumen_bebas_pinjaman_perpustakaan' => 'nullable|file',
            'dokumen_ijazah_terakhir' => 'nullable|file',
            'dokumen_fotocopy_toefl' => 'nullable|file',
            'dokumen_input_skpi' => 'nullable|file',
            'draft_skripsi' => 'nullable|file',
            'dokumen_artikel_ilmiah' => 'nullable|file',
            'file_turnitin' => 'nullable|file',
            'bukti_pendaftaran_siadin' => 'nullable|file',

            'tempat' => 'nullable',
            'tanggal' => 'nullable',
            'waktu' => 'nullable',
            'link_spredsheet' => 'nullable',
            'komentar' => 'nullable',
            'pembimbing_id' => 'required|exists:master_dosens,user_id',
            'ketua_penguji_id' => 'required|exists:master_dosens,user_id',
            'penguji_id' => 'required|exists:master_dosens,user_id',
        ]);

        $pendaftaranSkripsi = PendaftaranSkripsi::findOrFail($id);

        // Helper function to update file and delete old one
        function updateFile($request, $fieldName, $directory, $pendaftaranSkripsi)
        {
            if ($request->hasFile($fieldName)) {
                $oldFile = public_path($pendaftaranSkripsi->$fieldName);
                if (file_exists($oldFile) && is_file($oldFile)) {
                    unlink($oldFile);
                }

                $newFileName = time() . '_' . $request->file($fieldName)->getClientOriginalName();
                $request->file($fieldName)->move(public_path($directory), $newFileName);

                $pendaftaranSkripsi->$fieldName = $directory . '/' . $newFileName;
            }
        }

        // Update each document if new files are uploaded
        updateFile($request, 'file_persetujuan_pendaftaran_sidang_skripsi', 'dokumen/persetujuan_pendaftaran_sidang_skripsi', $pendaftaranSkripsi);
        updateFile($request, 'dokumen_pendaftaran_ujian_skripsi', 'dokumen/pendaftaran_ujian_skripsi', $pendaftaranSkripsi);
        updateFile($request, 'kartu_bimbingan', 'dokumen/kartu_bimbingan', $pendaftaranSkripsi);
        updateFile($request, 'dokumen_kartu_rencana_studi', 'dokumen/kartu_rencana_studi', $pendaftaranSkripsi);
        updateFile($request, 'dokumen_transkrip_nilai', 'dokumen/transkrip_nilai', $pendaftaranSkripsi);
        updateFile($request, 'dokumen_bebas_biaya_administrasi', 'dokumen/bebas_biaya_administrasi', $pendaftaranSkripsi);
        updateFile($request, 'dokumen_bebas_pinjaman_perpustakaan', 'dokumen/bebas_pinjaman_perpustakaan', $pendaftaranSkripsi);
        updateFile($request, 'dokumen_ijazah_terakhir', 'dokumen/ijazah_terakhir', $pendaftaranSkripsi);
        updateFile($request, 'dokumen_fotocopy_toefl', 'dokumen/fotocopy_toefl', $pendaftaranSkripsi);
        updateFile($request, 'dokumen_input_skpi', 'dokumen/input_skpi', $pendaftaranSkripsi);
        updateFile($request, 'draft_skripsi', 'dokumen/draft_skripsi', $pendaftaranSkripsi);
        updateFile($request, 'dokumen_artikel_ilmiah', 'dokumen/artikel_ilmiah', $pendaftaranSkripsi);
        updateFile($request, 'file_turnitin', 'dokumen/turnitin', $pendaftaranSkripsi);
        updateFile($request, 'bukti_pendaftaran_siadin', 'dokumen/bukti_pendaftaran_siadin', $pendaftaranSkripsi);


        // Update non-file fields
        $pendaftaranSkripsi->update([
            'judul_skripsi' => $request->judul_skripsi,
            'pembimbing_id' => $request->pembimbing_id,
            'ketua_penguji_id' => $request->ketua_penguji_id,
            'penguji_id' => $request->penguji_id,
            'tempat' => $request->tempat,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'link_spredsheet' => $request->link_spredsheet,
            'komentar' => $request->komentar,
            'status' => 'pending',
        ]);

        Alert::success('Sukses', 'Data pendaftaran skripsi berhasil diperbarui.');
        return redirect()->route('pendaftaranskripsi.index');
    }




    public function destroy($id)
    {
        $pendaftaranSkripsi = PendaftaranSkripsi::findOrFail($id);

        // Function to delete a file if it exists
        function deleteFile($filePath)
        {
            $fullPath = public_path($filePath);
            if (file_exists($fullPath) && is_file($fullPath)) {
                unlink($fullPath);
            }
        }

        // Delete all related files
        deleteFile($pendaftaranSkripsi->file_persetujuan_pendaftaran_sidang_skripsi);
        deleteFile($pendaftaranSkripsi->dokumen_pendaftaran_ujian_skripsi);
        deleteFile($pendaftaranSkripsi->kartu_bimbingan);
        deleteFile($pendaftaranSkripsi->dokumen_kartu_rencana_studi);
        deleteFile($pendaftaranSkripsi->dokumen_transkrip_nilai);
        deleteFile($pendaftaranSkripsi->dokumen_bebas_biaya_administrasi);
        deleteFile($pendaftaranSkripsi->dokumen_bebas_pinjaman_perpustakaan);
        deleteFile($pendaftaranSkripsi->dokumen_ijazah_terakhir);
        deleteFile($pendaftaranSkripsi->dokumen_fotocopy_toefl);
        deleteFile($pendaftaranSkripsi->dokumen_input_skpi);
        deleteFile($pendaftaranSkripsi->draft_skripsi);
        deleteFile($pendaftaranSkripsi->dokumen_artikel_ilmiah);
        deleteFile($pendaftaranSkripsi->file_turnitin);
        deleteFile($pendaftaranSkripsi->bukti_pendaftaran_siadin);


        // Delete the record from the database
        $pendaftaranSkripsi->delete();

        // Success alert
        Alert::success('Sukses', 'Data pendaftaran skripsi dan semua dokumen terkait berhasil dihapus.');
        return redirect()->route('pendaftaranskripsi.index');
    }

    
    // DOWNLOAD
    public function downloadc1($id)
    {
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();

        // Mengambil pendaftaranskripsi beserta dosen-dosennya
        $pendaftaranskripsi = PendaftaranSkripsi::with(['dosenpembimbing', 'dosenpenguji', 'dosenketuapenguji'])
            ->findOrFail($id);

        return view('pagemahasiswa.skripsi.filedownload.c1', compact('pendaftaranskripsi', 'mahasiswa'));
    }
    public function downloadc2($id)
    {
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();

        // Mengambil pendaftaranskripsi beserta dosen-dosennya
        $pendaftaranskripsi = PendaftaranSkripsi::with(['dosenpembimbing', 'dosenpenguji', 'dosenketuapenguji'])
            ->findOrFail($id);

        return view('pagemahasiswa.skripsi.filedownload.c2', compact('pendaftaranskripsi', 'mahasiswa'));
    }

    // DOWNLOAD
}
