<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $level = Auth::user()->level;
        if ($level == "admin") {
            return redirect()->to('/dashboard_admin');
        } else if ($level == "dosen") {
            return redirect()->to('/dashboard_dosen');
        } else if ($level == "mahasiswa") {
            return redirect()->to('/dashboard_mahasiswa');
        } else {
            return redirect()->to('logout');
        }
    }
}
