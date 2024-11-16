<?php

namespace App\Http\Controllers;

use App\Models\MasterKategoriSkpi;
use App\Models\MasterUnsurSkpi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;



class MasterUnsurSkpiController extends Controller
{
    // Display list of unsur
    public function index()
    {
        $unsur = MasterUnsurSkpi::with('kategori')->get();
        return view('pageadmin.master_skors.master_unsur_skpi.index', compact('unsur'));
    }

    // Show form for creating new unsur
    public function create()
    {
        $kategori = MasterKategoriSkpi::all();
        return view('pageadmin.master_skors.master_unsur_skpi.create', compact('kategori'));
    }

    // Store newly created unsur
    public function store(Request $request)
    {
        $request->validate([
            'nama_unsur' => 'required|string|max:255',
            'kategori_id' => 'required',
           
        ]);

      

        // Create unsur
        MasterUnsurSkpi::create([
            'nama_unsur' => $request->nama_unsur,
            'kategori_id' => $request->kategori_id,
           
        ]);

        Alert::success('Success', 'Unsur successfully created!');
        return redirect()->route('unsur.index');
    }

    // Show form for editing unsur
    public function edit($id)
    {
        $unsur = MasterUnsurSkpi::findOrFail($id);
        $kategori = MasterKategoriSkpi::all();
    
        return view('pageadmin.master_skors.master_unsur_skpi.edit', compact('kategori', 'unsur'));
    }
    

    // Update unsur
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_unsur' => 'required|string|max:255',
            'kategori_id' => 'required',

            
          
        ]);

        // Update unsur
        $unsur = MasterUnsurSkpi::findOrFail($id);

        $unsur->update([
            'nama_unsur' => $request->nama_unsur,
            'kategori_id' => $request->kategori_id,
          
           
        ]);

       

        Alert::success('Success', 'Unsur successfully updated!');
        return redirect()->route('unsur.index');
    }

    // Delete unsur
    public function destroy($id)
    {
        $unsur = MasterUnsurSkpi::findOrFail($id);

        $unsur->delete();
      

        Alert::success('Deleted', 'Unsur successfully deleted!');
        return redirect()->route('unsur.index');
    }
}