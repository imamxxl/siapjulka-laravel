<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FAQMahasiswaController extends Controller
{
    public function index()
    {
        return view('mahasiswa.faq.faq-mahasiswa');
    }
}
