<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    function get()
    {
        $data = Ruang::all();
        return response()->json(
            $data
        );
    }
}
