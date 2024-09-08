<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class TimController extends Controller
{
    public function index(){
        $tim = Tim::all();
        return view('pageadmin.tim.index', compact('tim'));
    }

    public function create(){
        return view('pageadmin.tim.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_tim' => 'required|string|max:255',
            'peran' => 'required|string',
            'tindakan' => 'required|string',
        ]);

        // Membuat kategori baru
        $tim = new Tim();
        $tim->nama_tim = $request->input('nama_tim');
        $tim->peran = $request->input('peran');
        $tim->tindakan = $request->input('tindakan');
        $tim->save();

        // Set success message
        Alert::success('Success', 'Tim berhasil ditambahkan.');

        // Redirect dengan pesan sukses
        return redirect()->route('tim.index');
    }

    public function edit($id)
    {
        $tim = Tim::findOrFail($id);
        return view('pageadmin.tim.edit', compact('tim'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_tim' => 'required|string|max:255',
            'peran' => 'required|string',
            'tindakan' => 'required|string',        
        ]);

        // Update tim
        $tim = Tim::findOrFail($id);
        $tim->nama_tim = $request->input('nama_tim');
        $tim->peran = $request->input('peran');
        $tim->tindakan = $request->input('tindakan');
        $tim->save();

        // Set success message
        Alert::success('Success', 'Tim berhasil diperbarui.');

        // Redirect dengan pesan sukses
        return redirect()->route('tim.index');
    }

    public function destroy($id)
    {
        $tim = Tim::findOrFail($id);
        $tim->delete();

        // Set success message
        Alert::success('Success', 'Tim berhasil dihapus.');

        return redirect()->route('tim.index');
    }
}