<?php

namespace App\Http\Controllers;

use App\Models\MasterLink;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;



class MasterLinkController extends Controller
{
    // Display list of dosen
    public function index()
    {
        $link = MasterLink::all();
        return view('pageadmin.master_link.index', compact('link'));
    }

    // Show form for creating new dosen
    public function create()
    {
        return view('pageadmin.master_link.create');
    }

    // Store newly created dosen
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|string|max:255',
           
        ]);

      

        // Create dinkes
        MasterLink::create([
            'nama' => $request->nama,
            'link' => $request->link,
           
        ]);

        Alert::success('Success', 'Link successfully created!');
        return redirect()->route('link.index');
    }

    // Show form for editing dosen
    public function edit($id)
    {
        $link = MasterLink::findOrFail($id);

        return view('pageadmin.master_link.edit', compact('link'));
    }

    // Update dosen
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|string|max:255',
          
        ]);

        // Update dosen
        $dosen = MasterLink::findOrFail($id);

        $dosen->update([
            'nama' => $request->nama,
            'link' => $request->link,
          
           
        ]);

       

        Alert::success('Success', 'Link successfully updated!');
        return redirect()->route('link.index');
    }

    // Delete dosen
    public function destroy($id)
    {
        $link = MasterLink::findOrFail($id);

        $link->delete();
      

        Alert::success('Deleted', 'Link user successfully deleted!');
        return redirect()->route('link.index');
    }
}