<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranSkripsi;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DosenPageSkripsiController extends Controller
{
    public function index()
    {
        // Get the logged-in user ID
        $userId = Auth::id();

        // Fetch seminar proposals where the logged-in user is associated as pembimbing, advisor, or penguji
        $dataSkripsi = PendaftaranSkripsi::with(['dosenpembimbing', 'dosenpenguji', 'dosenketuapenguji', 'mahasiswa'])
            ->where(function ($query) use ($userId) {
                $query->where('pembimbing_id', $userId)
                      ->orWhere('ketua_penguji_id', $userId)
                      ->orWhere('penguji_id', $userId);
            })
            ->get();

        return view('pagedosen.skripsi.index', compact('dataSkripsi'));
    }
}
