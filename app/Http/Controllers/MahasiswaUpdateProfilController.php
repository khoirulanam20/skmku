<?php

namespace App\Http\Controllers;

use App\Models\MasterMahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;

class MahasiswaUpdateProfilController extends Controller
{
    public function index()
    {
        // Get currently logged in user
        $user = auth()->user();
        
        // Get mahasiswa data associated with logged in user
        $mahasiswa = MasterMahasiswa::where('user_id', $user->id)->firstOrFail();

        return view('pagemahasiswa.update_profil.index', compact('mahasiswa', 'user'));
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
        return redirect()->route('profilmahasiswa.index');
    }
}
