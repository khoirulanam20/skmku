<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;



class WilayahController extends Controller
{
    public function index()
    {
        $kec = Kecamatan::all();
        $kel = Kelurahan::all();
        return view('pageadmin.master_wilayah.index', compact('kec', 'kel'));
    }

    public function deleteAll()
    {
        // Delete all Kelurahan and Kecamatan data
        Kelurahan::truncate();
        Kecamatan::truncate();

        // Redirect back with a success message
        Alert::success('Deleted', 'Semua data kecamatan dan kelurahan telah dihapus.!');
        return redirect()->route('wilayah.index');
    }
}