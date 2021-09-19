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

    public function indexDosen()
    {
        $hitung_user = User::where('status', '1')->count();

        $hitung_seksi = Seksi::where('status', '1')
            // 5332 akan diganti dengan Middleware User Dosen yang login
            ->where('kode_dosen', '5322')
            ->count();

        $hitung_matakuliah = Seksi::select('kode_mk')
            ->groupBy('kode_dosen')
            ->where('status', '1')
            // 5332 akan diganti dengan Middleware User Dosen yang login
            ->where('kode_dosen', '5322')
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

    public function indexMahasiswa()
    {
        $hitung_user = User::where('status', '1')->count();

        $hitung_seksi = Participant::where('user_id', '1')
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
