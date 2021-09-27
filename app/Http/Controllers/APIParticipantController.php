<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;

class APIParticipantController extends Controller
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

    function getById($id_participant)
    {
        $data = Participant::where('id_participant', $id_participant)->get();

        $count_data = $data->count();

        if ($count_data == 0) {
            return response()->json(
                "Data tidak ditemukan"
            );
        } else {
            return response()->json(
                $data
            );
        }
    }
}
