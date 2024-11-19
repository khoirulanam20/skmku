<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;

class AdminUpdateProfilController extends Controller
{
    public function index()
    {
        // Get currently logged in user
        $user = auth()->user();
    

        return view('pageadmin.update_profil.index', compact('user'));
    }

    // Update dinkes
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|confirmed|min:6',
        ]);

        // Get user by ID
        $user = User::findOrFail($id);

        // Update User
        $user->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->filled('password') ? bcrypt($request->password) : $user->password,
        ]);

        Alert::success('Success', 'Admin and associated user successfully updated!');
        return redirect()->route('profiladmin.index');
    }
}
