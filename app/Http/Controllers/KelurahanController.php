<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;


class KelurahanController extends Controller
{


    public function storeKelurahanData()
    {
        // Fetch all kecamatan records from the database
        $kecamatans = Kecamatan::all();
        
        foreach ($kecamatans as $kecamatan) {
            // Fetch kelurahan data for each kecamatan
            $response = Http::withoutVerifying()->get('https://alamat.thecloudalert.com/api/kelurahan/get/', [
                'd_kecamatan_id' => $kecamatan->kecamatan_id
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                foreach ($data['result'] as $kelurahan) {
                    // Store each kelurahan in the database
                    Kelurahan::updateOrCreate(
                        ['kelurahan_id' => $kelurahan['id']],
                        ['name' => $kelurahan['text'], 'kecamatan_id' => $kecamatan->kecamatan_id]
                    );
                }
            } else {
                // Log or handle the error for the specific kecamatan
                Log::error('Failed to fetch kelurahan data for kecamatan_id: ' . $kecamatan->kecamatan_id);
            }
        }
        
        Alert::success('Success', 'Data Kelurahan berhasil di tambahkan.!');
        return redirect()->route('wilayah.index');
    }
}