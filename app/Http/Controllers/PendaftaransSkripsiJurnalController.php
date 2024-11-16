<?php

namespace App\Http\Controllers;

use App\Models\PendaftaransSkripsiJurnal;
use App\Models\MasterDosen;
use App\Models\MasterMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Routing\Controller;

class PendaftaransSkripsiJurnalController extends Controller
{
    public function index()
    {
        // Get the logged-in user
        $user = auth()->user();

        $mahasiswa = MasterMahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa not found.');
        }

        $pendaftaranSkripsisJurnal = PendaftaransSkripsiJurnal::with(['dosenpembimbing', 'dosenpenguji', 'dosenketuapenguji'])
            ->where('mahasiswa_id', $user->id) // Filter berdasarkan mahasiswa_id
            ->get();



        return view('pagemahasiswa.skripsijurnal.index', compact('pendaftaranSkripsisJurnal', 'mahasiswa'));
    }



    public function create()
    {
        // Fetch the currently authenticated user's Mahasiswa
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();

        $dosens = MasterDosen::all(); // Fetch all dosen for select option

        return view('pagemahasiswa.skripsijurnal.create', compact('dosens', 'mahasiswa'));
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
            'ss_reputasi_jurnal_sinta' => 'nullable|file',
            'bukti_publikasi' => 'nullable|file',
            'bukti_koreapondensi' => 'nullable|file',

            'tempat' => 'nullable',
            'tanggal' => 'nullable',
            'waktu' => 'nullable',
            'selesai' => 'nullable',
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
            'ss_reputasi_jurnal_sinta' => 'dokumen/ss_reputasi_jurnal_sinta',
            'bukti_publikasi' => 'dokumen/bukti_publikasi',
            'bukti_koreapondensi' => 'dokumen/bukti_koreapondensi',
        ];


        // Process document uploads
        $uploadedFiles = [];
        foreach ($documents as $inputName => $directory) {
            $uploadedFileName = time() . '_' . $request->file($inputName)->getClientOriginalName();
            $request->file($inputName)->move(public_path($directory), $uploadedFileName);
            $uploadedFiles[$inputName] = $directory . '/' . $uploadedFileName;
        }

        // Create new PendaftaranSempro record
        $pendaftaranSkripsiJurnal = new PendaftaransSkripsiJurnal();
        $pendaftaranSkripsiJurnal->mahasiswa_id = auth()->user()->id;
        $pendaftaranSkripsiJurnal->pembimbing_id = $request->pembimbing_id;
        $pendaftaranSkripsiJurnal->ketua_penguji_id = $request->ketua_penguji_id;
        $pendaftaranSkripsiJurnal->penguji_id = $request->penguji_id;
        $pendaftaranSkripsiJurnal->peminatan = $request->peminatan;
        $pendaftaranSkripsiJurnal->judul_skripsi = $request->judul_skripsi;
        $pendaftaranSkripsiJurnal->file_persetujuan_pendaftaran_sidang_skripsi = $uploadedFiles['file_persetujuan_pendaftaran_sidang_skripsi'];
        $pendaftaranSkripsiJurnal->dokumen_pendaftaran_ujian_skripsi = $uploadedFiles['dokumen_pendaftaran_ujian_skripsi'];
        $pendaftaranSkripsiJurnal->kartu_bimbingan = $uploadedFiles['kartu_bimbingan'];
        $pendaftaranSkripsiJurnal->dokumen_kartu_rencana_studi = $uploadedFiles['dokumen_kartu_rencana_studi'];
        $pendaftaranSkripsiJurnal->dokumen_transkrip_nilai = $uploadedFiles['dokumen_transkrip_nilai'];
        $pendaftaranSkripsiJurnal->dokumen_bebas_biaya_administrasi = $uploadedFiles['dokumen_bebas_biaya_administrasi'];
        $pendaftaranSkripsiJurnal->dokumen_bebas_pinjaman_perpustakaan = $uploadedFiles['dokumen_bebas_pinjaman_perpustakaan'];
        $pendaftaranSkripsiJurnal->dokumen_ijazah_terakhir = $uploadedFiles['dokumen_ijazah_terakhir'];
        $pendaftaranSkripsiJurnal->dokumen_fotocopy_toefl = $uploadedFiles['dokumen_fotocopy_toefl'];
        $pendaftaranSkripsiJurnal->dokumen_input_skpi = $uploadedFiles['dokumen_input_skpi'];
        $pendaftaranSkripsiJurnal->draft_skripsi = $uploadedFiles['draft_skripsi'];
        $pendaftaranSkripsiJurnal->dokumen_artikel_ilmiah = $uploadedFiles['dokumen_artikel_ilmiah'];
        $pendaftaranSkripsiJurnal->file_turnitin = $uploadedFiles['file_turnitin'];
        $pendaftaranSkripsiJurnal->bukti_pendaftaran_siadin = $uploadedFiles['bukti_pendaftaran_siadin'];
        $pendaftaranSkripsiJurnal->ss_reputasi_jurnal_sinta = $uploadedFiles['ss_reputasi_jurnal_sinta'];
        $pendaftaranSkripsiJurnal->bukti_publikasi = $uploadedFiles['bukti_publikasi'];
        $pendaftaranSkripsiJurnal->bukti_koreapondensi = $uploadedFiles['bukti_koreapondensi'];
        $pendaftaranSkripsiJurnal->tempat = $request->tempat;
        $pendaftaranSkripsiJurnal->tanggal = $request->tanggal;
        $pendaftaranSkripsiJurnal->waktu = $request->waktu;
        $pendaftaranSkripsiJurnal->selesai = $request->selesai;
        $pendaftaranSkripsiJurnal->link_spredsheet = $request->link_spredsheet;
        $pendaftaranSkripsiJurnal->komentar = $request->komentar;
        $pendaftaranSkripsiJurnal->status = 'pending'; // Default to pending

        // Save to database
        $pendaftaranSkripsiJurnal->save();

        // Success alert
        Alert::success('Sukses', 'Data pendaftaran skripsi jurnal berhasil ditambah.');
        return redirect()->route('pendaftaranskripsijurnal.index');
    }


    public function show($id)
    {
        $pendaftaranSkripsiJurnal = PendaftaransSkripsiJurnal::findOrFail($id);
        return view('pagemahasiswa.skripsijurnal.show', compact('pendaftaranSkripsiJurnal'));
    }

    public function edit($id)
    {
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();

        $pendaftaranskripsijurnal = PendaftaransSkripsiJurnal::findOrFail($id);
        $dosens = MasterDosen::all();
        return view('pagemahasiswa.skripsijurnal.edit', compact('pendaftaranskripsijurnal', 'dosens', 'mahasiswa'));
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
            'ss_reputasi_jurnal_sinta' => 'nullable|file',
            'bukti_publikasi' => 'nullable|file',
            'bukti_koreapondensi' => 'nullable|file',

            'tempat' => 'nullable',
            'tanggal' => 'nullable',
            'waktu' => 'nullable',
            'selesai' => 'nullable',
            'link_spredsheet' => 'nullable',
            'komentar' => 'nullable',
            'pembimbing_id' => 'required|exists:master_dosens,user_id',
            'ketua_penguji_id' => 'required|exists:master_dosens,user_id',
            'penguji_id' => 'required|exists:master_dosens,user_id',
        ]);

        $pendaftaranSkripsiJurnal = PendaftaransSkripsiJurnal::findOrFail($id);

        // Helper function to update file and delete old one
        function updateFile($request, $fieldName, $directory, $pendaftaranSkripsiJurnal)
        {
            if ($request->hasFile($fieldName)) {
                $oldFile = public_path($pendaftaranSkripsiJurnal->$fieldName);
                if (file_exists($oldFile) && is_file($oldFile)) {
                    unlink($oldFile);
                }

                $newFileName = time() . '_' . $request->file($fieldName)->getClientOriginalName();
                $request->file($fieldName)->move(public_path($directory), $newFileName);

                $pendaftaranSkripsiJurnal->$fieldName = $directory . '/' . $newFileName;
            }
        }

        // Update each document if new files are uploaded
        updateFile($request, 'file_persetujuan_pendaftaran_sidang_skripsi', 'dokumen/persetujuan_pendaftaran_sidang_skripsi', $pendaftaranSkripsiJurnal);
        updateFile($request, 'dokumen_pendaftaran_ujian_skripsi', 'dokumen/pendaftaran_ujian_skripsi', $pendaftaranSkripsiJurnal);
        updateFile($request, 'kartu_bimbingan', 'dokumen/kartu_bimbingan', $pendaftaranSkripsiJurnal);
        updateFile($request, 'dokumen_kartu_rencana_studi', 'dokumen/kartu_rencana_studi', $pendaftaranSkripsiJurnal);
        updateFile($request, 'dokumen_transkrip_nilai', 'dokumen/transkrip_nilai', $pendaftaranSkripsiJurnal);
        updateFile($request, 'dokumen_bebas_biaya_administrasi', 'dokumen/bebas_biaya_administrasi', $pendaftaranSkripsiJurnal);
        updateFile($request, 'dokumen_bebas_pinjaman_perpustakaan', 'dokumen/bebas_pinjaman_perpustakaan', $pendaftaranSkripsiJurnal);
        updateFile($request, 'dokumen_ijazah_terakhir', 'dokumen/ijazah_terakhir', $pendaftaranSkripsiJurnal);
        updateFile($request, 'dokumen_fotocopy_toefl', 'dokumen/fotocopy_toefl', $pendaftaranSkripsiJurnal);
        updateFile($request, 'dokumen_input_skpi', 'dokumen/input_skpi', $pendaftaranSkripsiJurnal);
        updateFile($request, 'draft_skripsi', 'dokumen/draft_skripsi', $pendaftaranSkripsiJurnal);
        updateFile($request, 'dokumen_artikel_ilmiah', 'dokumen/artikel_ilmiah', $pendaftaranSkripsiJurnal);
        updateFile($request, 'file_turnitin', 'dokumen/turnitin', $pendaftaranSkripsiJurnal);
        updateFile($request, 'bukti_pendaftaran_siadin', 'dokumen/bukti_pendaftaran_siadin', $pendaftaranSkripsiJurnal);
        updateFile($request, 'ss_reputasi_jurnal_sinta', 'dokumen/ss_reputasi_jurnal_sinta', $pendaftaranSkripsiJurnal);
        updateFile($request, 'bukti_publikasi', 'dokumen/bukti_publikasi', $pendaftaranSkripsiJurnal);
        updateFile($request, 'bukti_koreapondensi', 'dokumen/bukti_koreapondensi', $pendaftaranSkripsiJurnal);


        // Update non-file fields
        $pendaftaranSkripsiJurnal->update([
            'judul_skripsi' => $request->judul_skripsi,
            'pembimbing_id' => $request->pembimbing_id,
            'ketua_penguji_id' => $request->ketua_penguji_id,
            'penguji_id' => $request->penguji_id,
            'tempat' => $request->tempat,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'selesai' => $request->selesai,
            'link_spredsheet' => $request->link_spredsheet,
            'komentar' => $request->komentar,
            'status' => 'pending',
        ]);

        Alert::success('Sukses', 'Data pendaftaran skripsi jurnal berhasil diperbarui.');
        return redirect()->route('pendaftaranskripsijurnal.index');
    }




    public function destroy($id)
    {
        $pendaftaranSkripsiJurnal = PendaftaransSkripsiJurnal::findOrFail($id);

        // Function to delete a file if it exists
        function deleteFile($filePath)
        {
            $fullPath = public_path($filePath);
            if (file_exists($fullPath) && is_file($fullPath)) {
                unlink($fullPath);
            }
        }

        // Delete all related files
        deleteFile($pendaftaranSkripsiJurnal->file_persetujuan_pendaftaran_sidang_skripsi);
        deleteFile($pendaftaranSkripsiJurnal->dokumen_pendaftaran_ujian_skripsi);
        deleteFile($pendaftaranSkripsiJurnal->kartu_bimbingan);
        deleteFile($pendaftaranSkripsiJurnal->dokumen_kartu_rencana_studi);
        deleteFile($pendaftaranSkripsiJurnal->dokumen_transkrip_nilai);
        deleteFile($pendaftaranSkripsiJurnal->dokumen_bebas_biaya_administrasi);
        deleteFile($pendaftaranSkripsiJurnal->dokumen_bebas_pinjaman_perpustakaan);
        deleteFile($pendaftaranSkripsiJurnal->dokumen_ijazah_terakhir);
        deleteFile($pendaftaranSkripsiJurnal->dokumen_fotocopy_toefl);
        deleteFile($pendaftaranSkripsiJurnal->dokumen_input_skpi);
        deleteFile($pendaftaranSkripsiJurnal->draft_skripsi);
        deleteFile($pendaftaranSkripsiJurnal->dokumen_artikel_ilmiah);
        deleteFile($pendaftaranSkripsiJurnal->file_turnitin);
        deleteFile($pendaftaranSkripsiJurnal->bukti_pendaftaran_siadin);
        deleteFile($pendaftaranSkripsiJurnal->ss_reputasi_jurnal_sinta);
        deleteFile($pendaftaranSkripsiJurnal->bukti_publikasi);
        deleteFile($pendaftaranSkripsiJurnal->bukti_koreapondensi);


        // Delete the record from the database
        $pendaftaranSkripsiJurnal->delete();

        // Success alert
        Alert::success('Sukses', 'Data pendaftaran skripsi jurnal dan semua dokumen terkait berhasil dihapus.');
        return redirect()->route('pendaftaranskripsijurnal.index');
    }

    
    // DOWNLOAD
    public function downloadc1($id)
    {
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();

        // Mengambil pendaftaranskripsijurnal beserta dosen-dosennya
        $pendaftaranskripsijurnal = PendaftaransSkripsiJurnal::with(['dosenpembimbing', 'dosenpenguji', 'dosenketuapenguji'])
            ->findOrFail($id);

        return view('pagemahasiswa.skripsijurnal.filedownload.c1', compact('pendaftaranskripsijurnal', 'mahasiswa'));
    }
    public function downloadc2($id)
    {
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();

        // Mengambil pendaftaranskripsijurnal beserta dosen-dosennya
        $pendaftaranskripsijurnal = PendaftaransSkripsiJurnal::with(['dosenpembimbing', 'dosenpenguji', 'dosenketuapenguji'])
            ->findOrFail($id);

        return view('pagemahasiswa.skripsijurnal.filedownload.c2', compact('pendaftaranskripsijurnal', 'mahasiswa'));
    }

    // DOWNLOAD
}
