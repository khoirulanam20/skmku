<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Kecamatan;
use Illuminate\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;


class KecamatanController extends Controller
{
  
    public function storeKecamatanData()
    {
        // Fetch data from the API
        $response = Http::withoutVerifying()->get('https://alamat.thecloudalert.com/api/kecamatan/get/?d_kabkota_id=362');
        
        if ($response->successful()) {
            $data = $response->json();
            
            foreach ($data['result'] as $kecamatan) {
                // Store each kecamatan in the database
                Kecamatan::updateOrCreate(
                    ['kecamatan_id' => $kecamatan['id']],
                    ['name' => $kecamatan['text']]
                );
            }
            
            Alert::success('Success', 'Data kecamatan berhasil di tambahkan.!');
            return redirect()->route('wilayah.index');
        }
        
        Alert::success('Error', 'Data kecamatan gagal di tambahkan.!');
        return redirect()->route('wilayah.index');
    }
}