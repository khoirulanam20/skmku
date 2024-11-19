<?php

namespace App\Http\Controllers;

use App\Models\MasterMahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;



class MasterMahasiswaController extends Controller
{
    // Display list of dinkes
    public function index()
    {
        $mahasiswa = MasterMahasiswa::with('user')->get();
        return view('pageadmin.master_mahasiswa.index', compact('mahasiswa'));
    }

    // Show form for creating new mahasiswa
    public function create()
    {
        return view('pageadmin.master_mahasiswa.create');
    }

    // Store newly created dinkes
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'alamat' => 'nullable',
            'telepon' => 'nullable',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // Create user with role 'mahasiswa'
        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'mahasiswa',
        ]);

        // Create dinkes
        MasterMahasiswa::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'user_id' => $user->id,
        ]);

        Alert::success('Success', 'Mahasiswa successfully created!');
        return redirect()->route('mahasiswa.index');
    }

    // Show form for editing dinkes
    public function edit($id)
    {
        $mahasiswa = MasterMahasiswa::findOrFail($id);
        $user = User::findOrFail($mahasiswa->user_id);

        return view('pageadmin.master_mahasiswa.edit', compact('mahasiswa', 'user'));
    }

    // Update dinkes
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'alamat' => 'nullable',
            'telepon' => 'nullable',
            'email' => 'required|email',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|confirmed|min:6',
        ]);

        // Update mahasiswa
        $mahasiswa = MasterMahasiswa::findOrFail($id);
        $user = User::findOrFail($mahasiswa->user_id);

        $mahasiswa->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
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

        Alert::success('Success', 'Mahasiswa and associated user successfully updated!');
        return redirect()->route('mahasiswa.index');
    }

    // Delete mahasiswa
    public function destroy($id)
    {
        $mahasiswa = MasterMahasiswa::findOrFail($id);
        $user = User::findOrFail($mahasiswa->user_id);

        $mahasiswa->delete();
        $user->delete();

        Alert::success('Deleted', 'Mahasiswa and associated user successfully deleted!');
        return redirect()->route('mahasiswa.index');
    }
}