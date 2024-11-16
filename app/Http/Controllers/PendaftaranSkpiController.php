<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranSkpi;
use App\Models\MasterKategoriSkpi;
use App\Models\MasterUnsurSkpi;
use App\Models\MasterMahasiswa;
use App\Models\MasterSkorsSkpi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Routing\Controller;

class PendaftaranSkpiController extends Controller
{
    public function getUnsurs($kategoriId)
    {
        return MasterUnsurSkpi::where('kategori_id', $kategoriId)->get();
    }

    public function getSkors($unsurId)
    {
        return MasterSkorsSkpi::where('unsur_id', $unsurId)->get();
    }
    public function index()
    {
        // Get the logged-in user
        $user = auth()->user();
    
        // Find the first MasterMahasiswa record associated with the user
        $mahasiswa = MasterMahasiswa::where('user_id', $user->id)->first();
    
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Mahasiswa not found.');
        }
    
        // Retrieve all PendaftaranSkpi records for the logged-in user, ordered by the latest created
        $pendaftaranSkpis = PendaftaranSkpi::where('mahasiswa_id', $user->id)
                                            ->orderBy('created_at', 'desc')
                                            ->get();
    
        return view('pagemahasiswa.skpi.index', compact('pendaftaranSkpis', 'mahasiswa'));
    }
    




    public function create()
    {
        $categories  = MasterKategoriSkpi::all();
        // Fetch the currently authenticated user's Mahasiswa
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();

        return view('pagemahasiswa.skpi.create', compact('mahasiswa', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'peminatan' => 'required|string|max:255',
            'tempat_tanggal_lahir' => 'required|string|max:255',
            'skors_data' => 'required|string',
            'dokumen_kegiatan' => 'required|file',
        ]);

        $skorsData = json_decode($request->input('skors_data'), true);

        $uploadedFiles = [];
        $uploadedFileName = time() . '_' . $request->file('dokumen_kegiatan')->getClientOriginalName();
        $request->file('dokumen_kegiatan')->move(public_path('dokumen/dokumen_kegiatan'), $uploadedFileName);
        $uploadedFiles['dokumen_kegiatan'] = 'dokumen/dokumen_kegiatan/' . $uploadedFileName;

        $pendaftaranSkpi = new PendaftaranSkpi();
        $pendaftaranSkpi->mahasiswa_id = auth()->user()->id;
        $pendaftaranSkpi->peminatan = $request->peminatan;
        $pendaftaranSkpi->tempat_tanggal_lahir = $request->tempat_tanggal_lahir;
        $pendaftaranSkpi->skors = json_encode($skorsData); // Save as JSON
        $pendaftaranSkpi->dokumen_kegiatan = $uploadedFiles['dokumen_kegiatan'];
        $pendaftaranSkpi->status = 'pending';

        $pendaftaranSkpi->save();

        Alert::success('Sukses', 'Data pendaftaran SKPI berhasil ditambah.');
        return redirect()->route('pendaftaranskpi.index');
    }





    public function show($id)
    {
        $pendaftaranSkpi = PendaftaranSkpi::findOrFail($id);
        return view('pagemahasiswa.skpi.show', compact('pendaftaranSkpi'));
    }

    public function edit($id)
    {
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();

        $pendaftaranskpi = PendaftaranSkpi::findOrFail($id);
        return view('pagemahasiswa.skpi.edit', compact('pendaftaranskpi', 'mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'peminatan' => 'required|string|max:255',
            'tempat_tanggal_lahir' => 'required|string|max:255',
            'skors' => 'required|string|max:255',
        ]);

        $pendaftaranSkpi = PendaftaranSkpi::findOrFail($id);

        // Function to delete old file if new one is uploaded
        function updateFile($request, $fieldName, $directory, $pendaftaranSkpi)
        {
            if ($request->hasFile($fieldName)) {
                // Delete the old file if it exists
                $oldFile = public_path($pendaftaranSkpi->$fieldName);
                if (file_exists($oldFile) && is_file($oldFile)) {
                    unlink($oldFile);
                }

                // Save new file
                $newFileName = time() . '_' . $request->file($fieldName)->getClientOriginalName();
                $request->file($fieldName)->move(public_path($directory), $newFileName);

                // Update the path in the database
                $pendaftaranSkpi->$fieldName = $directory . '/' . $newFileName;
            }
        }

        // Update files if present and delete old ones
        updateFile($request, 'dokumen_kegiatan', 'dokumen/dokumen_kegiatan', $pendaftaranSkpi);


        // Update the rest of the data
        $pendaftaranSkpi->update([
            'peminatan' => $request->peminatan,
            'tempat_tanggal_lahir' => $request->tempat_tanggal_lahir,
            'skors' => $request->skors,
            'status' => 'pending',
        ]);

        // Success alert
        Alert::success('Sukses', 'Data pendaftaran SKPI berhasil diperbarui.');
        return redirect()->route('pendaftaranskpi.index');
    }



    public function destroy($id)
    {
        $pendaftaranSkpi = PendaftaranSkpi::findOrFail($id);

        // Function to delete a file if it exists
        function deleteFile($filePath)
        {
            $fullPath = public_path($filePath);
            if (file_exists($fullPath) && is_file($fullPath)) {
                unlink($fullPath);
            }
        }

        // Delete all related files
        deleteFile($pendaftaranSkpi->dokumen_kegiatan);


        // Delete the record from the database
        $pendaftaranSkpi->delete();

        // Success alert
        Alert::success('Sukses', 'Data pendaftaran SKPI dan semua dokumen terkait berhasil dihapus.');
        return redirect()->route('pendaftaranskpi.index');
    }

    // DOWNLOAD
    public function downloadskpi($id)
    {
        $mahasiswa = MasterMahasiswa::where('user_id', auth()->id())->first();

        // Mengambil pendaftaranskripsi beserta dosen-dosennya
        $pendaftaranskpi = PendaftaranSkpi::with(['mahasiswa'])
            ->findOrFail($id);
        $skors_translate = json_decode($pendaftaranskpi->skors_translate, true);
        $skors_non_translate = json_decode($pendaftaranskpi->skors, true);

        return view('pagemahasiswa.skpi.filedownload.skpi', compact('pendaftaranskpi', 'mahasiswa', 'skors_translate','skors_non_translate'));
    }


    // DOWNLOAD
}
