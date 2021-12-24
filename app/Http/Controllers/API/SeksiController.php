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

    function show(Request $request, $id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "id_seksi" => "required",
                ],
                [
                    'id_seksi.required' => 'ID Seksi wajib ada',
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
                    'status' => 'Error',
                    "message" => "User tidak terdaftar di sistem",
                    "data" => null
                ]);
            } else {
                // memilih pertemuan berdasarkan seksi dan user yg login
                $deteksi_pertemuan = DB::table('seksis')
                    ->join('matakuliahs', 'matakuliahs.kode_mk', '=', 'seksis.kode_mk')
                    ->where('id', $request->id_seksi)
                    ->first();

                if (!empty($deteksi_pertemuan)) {
                    return response()->json(
                        $deteksi_pertemuan
                    );
                } else {
                    return response()->json([
                        'status' => 'Error',
                        'message' => 'Tidak ada seksi atau kelas yang ditemukan',
                        'data' => null
                    ], 404);
                }
            }
        } catch (Exception $e) {
            return response()->json(["status" => "Error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    function where(Request $request, $user_id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "hari" => "required",
                ],
                [
                    'hari.required' => 'Hari wajib ada',
                ]
            );

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 400);
            }

            $hitung_data = DB::table('seksis')
                ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
                ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
                ->join('participants', 'participants.id_seksi', '=', 'seksis.id')
                ->where('seksis.status', '1')
                ->where('participants.keterangan', '1')
                ->where('participants.user_id', $user_id)
                ->where('seksis.hari', $request->hari)
                ->count();

            if ($hitung_data == null) {
                return response()->json([
                    'status' => 'Error',
                    "message" => "Tidak ada data kelas anda pada hari",
                    "data" => null,
                ]);
            } else {
                // memilih seksi berdasarkan hari yang dipilih user
                $data_hari = DB::table('seksis')
                    ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
                    ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
                    ->join('participants', 'participants.id_seksi', '=', 'seksis.id')
                    ->where('seksis.status', '1')
                    ->where('participants.keterangan', '1')
                    ->where('participants.user_id', $user_id)
                    ->where('seksis.hari', $request->hari)
                    ->orderBy('id', 'DESC')
                    ->get();

                return response()->json([
                    'status' => 'Success',
                    'message' => 'Kelas/seksi berhasil ditemukan',
                    'data' => $data_hari
                ]);
            }
        } catch (Exception $e) {
            return response()->json(["status" => "Error", "message" => $e->getMessage()], $e->getCode());
        }
    }
}
