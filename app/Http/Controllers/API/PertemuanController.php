<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pertemuan;
use Illuminate\Http\Request;

class PertemuanController extends Controller
{
    function get()
    {
        $data = Pertemuan::all();
        return response()->json(
            $data
        );
    }
}
