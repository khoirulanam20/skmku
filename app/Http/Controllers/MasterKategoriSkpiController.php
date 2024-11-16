<?php

namespace App\Http\Controllers;

use App\Models\MasterKategoriSkpi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;



class MasterKategoriSkpiController extends Controller
{
    // Display list of kategori
    public function index()
    {
        $kategori = MasterKategoriSkpi::all();
        return view('pageadmin.master_skors.master_kategori_skpi.index', compact('kategori'));
    }

    // Show form for creating new kategori
    public function create()
    {
        return view('pageadmin.master_skors.master_kategori_skpi.create');
    }

    // Store newly created kategori
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
           
        ]);

      

        // Create kategori
        MasterKategoriSkpi::create([
            'nama_kategori' => $request->nama_kategori,
           
        ]);

        Alert::success('Success', 'Kategori SKPI successfully created!');
        return redirect()->route('kategori.index');
    }

    // Show form for editing kategori
    public function edit($id)
    {
        $kategori = MasterKategoriSkpi::findOrFail($id);

        return view('pageadmin.master_skors.master_kategori_skpi.edit', compact('kategori'));
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
          
        ]);

        // Update kategori
        $kategori = MasterKategoriSkpi::findOrFail($id);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
          
           
        ]);

       

        Alert::success('Success', 'Kategori SKPI successfully updated!');
        return redirect()->route('kategori.index');
    }

    // Delete kategori
    public function destroy($id)
    {
        $kategori = MasterKategoriSkpi::findOrFail($id);

        $kategori->delete();
      

        Alert::success('Deleted', 'Kategori SKPI successfully deleted!');
        return redirect()->route('kategori.index');
    }
}