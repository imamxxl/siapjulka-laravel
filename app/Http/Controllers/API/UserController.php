<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function get()
    {
        $data = User::all();
        return response()->json(
            $data
        );
    }
}