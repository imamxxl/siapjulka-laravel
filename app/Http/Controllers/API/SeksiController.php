<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Seksi;
use Illuminate\Http\Request;

class SeksiController extends Controller
{
    function get()
    {
        $data = Seksi::all();
        return response()->json(
            $data
        );
    }
}
