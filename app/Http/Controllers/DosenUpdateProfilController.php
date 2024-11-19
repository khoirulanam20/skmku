<?php

namespace App\Http\Controllers;

use App\Models\MasterDosen;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;

class DosenUpdateProfilController extends Controller
{
    public function index()
    {
        // Get currently logged in user
        $user = auth()->user();
        
        // Get mahasiswa data associated with logged in user
        $dosen = MasterDosen::where('user_id', $user->id)->firstOrFail();

        return view('pagedosen.update_profil.index', compact('dosen', 'user'));
    }

    // Update dinkes
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nidn' => 'required|string|max:255',
            'alamat' => 'nullable',
            'telepon' => 'nullable',
            'email' => 'required|email',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|confirmed|min:6',
        ]);

        // Update mahasiswa
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
        return redirect()->route('profildosen.index');
    }
}
