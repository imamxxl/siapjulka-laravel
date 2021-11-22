<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    function post(Request $request)
    {
        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        // get data from client
        $id_seksi = $request->id_seksi;
        $user_id = $request->user_id;
        $imei = $request->imei;

        $hasil_request = DB::table('participants')
            ->where('id_seksi', '=', $id_seksi)
            ->where('user_id', '=', $user_id)
            ->count();

        if ($hasil_request == 0) {
            $data = [
                'id_seksi' => $request->id_seksi,
                'user_id' => $request->user_id,
                'imei_participant' => $imei,
                'keterangan' => '0',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ];

            Participant::create($data);

            return response()->json(
                [
                    "message" => "Selamat, anda berhasil bergabung.",
                    "data" => $data
                ]
            );
        } else {
            return response()->json(
                [
                    "message" => "Maaf, anda sudah bergabung di kelas ini."
                ]
            );
        }
    }

    function get()
    {
        $data = Participant::all();
        return response()->json(
            $data
        );
    }

    function show($user_id)
    {
        $data = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
            ->join('participants', 'participants.id_seksi', '=', 'seksis.id')
            ->where('seksis.status', '1')
            ->where('participants.user_id', $user_id)
            ->get();

        $count_data = $data->count();

        if ($count_data == 0) {
            return response()->json([
                'message' => 'Maaf, data tidak ditemukan',
                'data' => null
            ], 404);
        } else {
            return response()->json(
                $data
            );
        }
    }
}
