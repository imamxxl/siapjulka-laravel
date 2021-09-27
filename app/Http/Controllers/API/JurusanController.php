<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    function get()
    {
        $data = Jurusan::all();
        return response()->json(
            $data
        );
    }
}
