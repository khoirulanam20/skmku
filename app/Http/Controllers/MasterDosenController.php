<?php

namespace App\Http\Controllers;

use App\Models\MasterDosen;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;



class MasterDosenController extends Controller
{
    // Display list of dosen
    public function index()
    {
        $dosen = MasterDosen::with('user')->get();
        return view('pageadmin.master_dosen.index', compact('dosen'));
    }

    // Show form for creating new dosen
    public function create()
    {
        return view('pageadmin.master_dosen.create');
    }

    // Store newly created dosen
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nidn' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'alamat' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // Create user with role 'dosen'
        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'dosen',
        ]);

        // Create dinkes
        MasterDosen::create([
            'nama' => $request->nama,
            'nidn' => $request->nidn,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'user_id' => $user->id,
        ]);

        Alert::success('Success', 'Dosen successfully created!');
        return redirect()->route('dosen.index');
    }

    // Show form for editing dosen
    public function edit($id)
    {
        $dosen = MasterDosen::findOrFail($id);
        $user = User::findOrFail($dosen->user_id);

        return view('pageadmin.master_dosen.edit', compact('dosen', 'user'));
    }

    // Update dosen
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nidn' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|confirmed|min:6',
        ]);

        // Update dosen
        $dosen = MasterDosen::findOrFail($id);
        $user = User::findOrFail($dosen->user_id);

        $dosen->update([
            'nama' => $request->nama,
            'nidn' => $request->nidn,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
           
        ]);

        // Update User
        $user->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
        ]);

        Alert::success('Success', 'Dosen and associated user successfully updated!');
        return redirect()->route('dosen.index');
    }

    // Delete dosen
    public function destroy($id)
    {
        $dosen = MasterDosen::findOrFail($id);
        $user = User::findOrFail($dosen->user_id);

        $dosen->delete();
        $user->delete();

        Alert::success('Deleted', 'Dosen and associated user successfully deleted!');
        return redirect()->route('dosen.index');
    }
}