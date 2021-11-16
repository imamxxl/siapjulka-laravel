<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Seksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnValue;

class SeksiController extends Controller
{
    function get()
    {
        $data = DB::table('participants')
            ->join('users', 'users.id', '=', 'participants.user_id')
            ->join('seksis', 'seksis.id', '=', 'participants.id_seksi')
            ->get();
        return response()->json(
            $data
        );
    }

    function show($id)
    {
        $data = DB::table('participants')
        ->join('users', 'users.id', '=', 'participants.user_id')
        ->join('seksis', 'seksis.id', '=', 'participants.id_seksi')
        ->where('participants.user_id', $id)
        ->get();
        if (!empty($data)) {
            return response()->json(
                $data
            );
        } else {
            return response()->json([
                'message' => 'Gagal menemukan data',
                'data' => null
            ], 404);
        }
        // return response()->json($data);
    }
}
