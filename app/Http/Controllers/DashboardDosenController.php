<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seksi;
use App\Models\Ruang;
use Illuminate\Support\Facades\Auth;

class DashboardDosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hitung_user = User::where('status', '1')->count();

        $hitung_seksi = Seksi::where('status', '1')
            // 5332 akan diganti dengan Middleware User Dosen yang login
            ->where('kode_dosen',  Auth::user()->username)
            ->count();

        $hitung_matakuliah = Seksi::select('kode_mk')
            ->groupBy('kode_dosen')
            ->where('status', '1')
            // 5332 akan diganti dengan Middleware User Dosen yang login
            ->where('kode_dosen',  Auth::user()->username)
            ->count();

        $hitung_ruangan = Ruang::where('status', '1')
            ->count();

        return view('dosen.dashboard.dashboard_dosen', compact(
            'hitung_user',
            'hitung_seksi',
            'hitung_matakuliah',
            'hitung_ruangan'
        ));
    }
}
