<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\User;
use App\Models\Admin;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Participant;
use App\Models\Ruang;
use App\Models\Seksi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hitung_user = User::where('status', '1')->count();

        $hitung_seksi = Seksi::where('status', '1')->count();

        $hitung_matakuliah = Matakuliah::where('status', '1')->count();

        $hitung_ruangan = Ruang::where('status', '1')->count();

        return view('admin.dashboard.dashboard_admin', compact(
            'hitung_user',
            'hitung_seksi',
            'hitung_matakuliah',
            'hitung_ruangan'
        ));
    }
}
