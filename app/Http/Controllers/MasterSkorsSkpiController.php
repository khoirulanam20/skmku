<?php

namespace App\Http\Controllers;

use App\Models\MasterMahasiswa;
use App\Models\MasterUnsurSkpi;
use App\Models\MasterSkorsSkpi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;



class MasterSkorsSkpiController extends Controller
{
   

    public function index()
    {
        $skor = MasterSkorsSkpi::with('unsur')->get();
        return view('pageadmin.master_skors.master_skor_skpi.index', compact('skor'));
    }

    public function create()
    {
        $unsur = MasterUnsurSkpi::all();
        return view('pageadmin.master_skors.master_skor_skpi.create', compact('unsur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sub_unsur' => 'nullable|string|max:255',
            'nama_tingkat' => 'nullable|string|max:255',
            'skor' => 'required|integer|max:255',
            'unsur_id' => 'required',
        ]);

        MasterSkorsSkpi::create([
            'nama_sub_unsur' => $request->nama_sub_unsur,
            'nama_tingkat' => $request->nama_tingkat,
            'skor' => $request->skor,
            'unsur_id' => $request->unsur_id,
        ]);

        Alert::success('Success', 'Skor successfully created!');
        return redirect()->route('skor.index');
    }

    public function edit($id)
    {
        $skor = MasterSkorsSkpi::findOrFail($id);
        $unsur = MasterUnsurSkpi::all();
        return view('pageadmin.master_skors.master_skor_skpi.edit', compact('skor', 'unsur'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sub_unsur' => 'nullable|string|max:255',
            'nama_tingkat' => 'nullable|string|max:255',
            'skor' => 'required|integer|max:255',
            'unsur_id' => 'required',
        ]);

        $skor = MasterSkorsSkpi::findOrFail($id);

        $skor->update([
            'nama_sub_unsur' => $request->nama_sub_unsur,
            'nama_tingkat' => $request->nama_tingkat,
            'skor' => $request->skor,
            'unsur_id' => $request->unsur_id,
        ]);

        Alert::success('Success', 'Skor successfully updated!');
        return redirect()->route('skor.index');
    }

    public function destroy($id)
    {
        $skor = MasterSkorsSkpi::findOrFail($id);

        $skor->delete();


        Alert::success('Deleted', 'Skor successfully deleted!');
        return redirect()->route('skor.index');
    }
}
