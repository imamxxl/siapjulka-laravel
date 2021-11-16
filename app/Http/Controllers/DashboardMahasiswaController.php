<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seksi;
use App\Models\Ruang;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hitung_user = User::where('status', '1')->count();

        $hitung_seksi = Participant::where('user_id', Auth::user()->id)
            // 1 akan diganti dengan Middleware User Mahasiswa yang login
            ->count();

        $hitung_matakuliah = Seksi::select('kode_mk')
            ->groupBy('kode_dosen')
            ->where('status', '1')
            // 1 akan diganti dengan Middleware User Mahasiswa yang login
            ->where('kode_dosen', '5322')
            ->count();

        $hitung_ruangan = Ruang::where('status', '1')
            ->count();

        return view('mahasiswa.dashboard.dashboard', compact(
            'hitung_user',
            'hitung_seksi',
            'hitung_matakuliah',
            'hitung_ruangan'
        ));
    }
}
