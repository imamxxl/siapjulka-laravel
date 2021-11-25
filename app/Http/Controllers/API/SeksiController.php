<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pertemuan;
use App\Models\Seksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;


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

    function shows(Request $request, $id)
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
    }

    function show(Request $request, $id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "id_seksi" => "required",
                ],
                [
                    'id_seksi.required' => 'User wajib ada',
                ]
            );

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 400);
            }

            $user = DB::table('users')
                ->where('id', $id)
                ->first();

            if ($user == null) {
                return response()->json([
                    "status" => 'Gagal',
                    "message" => "User tidak terdaftar di sistem"
                ]);
            } else {
                // memilih pertemuan berdasarkan seksi dan user yg login
                $deteksi_pertemuan = DB::table('absensis')
                    ->where('id_seksi', $request->id_seksi)
                    ->where('id_user', $id)
                    ->first();

                $pertemuan = DB::table('absensis')
                    ->join('pertemuans', 'pertemuans.id_pertemuan', '=', 'absensis.id_pertemuan')
                    ->where('absensis.id_seksi', $request->id_seksi)
                    ->where('absensis.id_user', $id)
                    ->get();

                if ($deteksi_pertemuan == null) {
                    return response()->json([
                        "status" => 0,
                        "message" => "Tidak ada pertemuan terdeteksi"
                    ]);
                }
                return response()->json(
                    $pertemuan
                );
            }
        } catch (Exception $e) {
            return response()->json(["status" => "Error", "message" => $e->getMessage()], $e->getCode());
        }
    }
}
