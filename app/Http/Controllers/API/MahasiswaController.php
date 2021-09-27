<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    function get()
    {
        $data = Mahasiswa::all();
        return response()->json(
            $data
        );
    }
}
