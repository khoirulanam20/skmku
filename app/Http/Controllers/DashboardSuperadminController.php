<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegPosyandu;
use App\Models\MasterPuskesmas;
use App\Models\MasterDinasKesehatan;
use Illuminate\Routing\Controller;

class DashboardSuperadminController extends Controller
{
    public function index(){

       
        return view('pageadmin.dashboard.index');
    }
}