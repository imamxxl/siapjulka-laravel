<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Participant;

class CariKelasController extends Controller
{
    function get(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'token' => 'required',
                ],
                [
                    'token.required' => 'Token wajib diisi',
                ]
            );

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 400);
            }

            // menangkap data pencarian
            $token = $request->token;

            $count_seksi = DB::table('seksis')
                ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
                ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
                ->where('token', 'like', "%" . $token . "%")
                ->count();

            // mengambil data dari table pegawai sesuai pencarian data
            $seksi = DB::table('seksis')
                ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
                ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
                ->where('token', 'like', "%" . $token . "%")
                ->first();

            if ($count_seksi == 0) {
                return response()->json(["status" => "Gagal", "message" => "Token tidak ditemukan. Silahkan cek token dan isikan token dengan benar.", "data" => null]);
            } else {
                return response()->json(["status" => "Success", "message" => "Data berhasil ditemukan", "data" => $seksi]);
            }
        } catch (Exception $e) {
            return response()->json(["status" => "Error", "message" => $e->getMessage()], $e->getCode());
        }
    }

    function post(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id_seksi' => 'required',
                'user_id' => 'required',
                'device_id' => 'required',
            ],
            [
                'id_seksi.required' => 'Id Seksi Wajib diisi',
                'user_id.required' => 'Id User wajib diisi',
                'device_id' => 'Imei wajib ada',
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first(), 400);
        }

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');


        // get data form csrf
        $id_seksi = $request->id_seksi;
        $user_id = $request->user_id;
        $imei = $request->device_id;

        $hasil_request = DB::table('participants')
            ->where('id_seksi', '=', $id_seksi)
            ->where('user_id', '=', $user_id)
            ->count();
        try {
            if ($hasil_request == 0) {
                $data = [
                    'id_seksi' => $id_seksi,
                    'user_id' => $user_id,
                    'imei_participant' => $imei,
                    'keterangan' => 0,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ];

                Participant::create($data);
                return response()->json(["status" => "Success", "message" => "Selamat, anda berhasil bergabung."]);
            } else {
                return response()->json(["status" => "Error", "message" => "Mohon maaf, anda sudah bergabung di kelas ini."]);
            }
        } catch (Exception $e) {
            return response()->json(["status" => "Error", "message" => $e->getMessage(), "data" => null], $e->getCode(),);
        }
    }

    function search(Request $request, $user_id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'clue' => 'required',
                ],
                [
                    'clue.required' => 'Kolom cari harus diisi',
                ]
            );

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 400);
            }

            // menangkap data pencarian
            $clue = $request->clue;

            $count_clue = DB::table('seksis')
                ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
                ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
                ->join('participants', 'participants.id_seksi', '=', 'seksis.id')
                ->where('participants.user_id', $user_id)
                ->where('matakuliahs.nama_mk', 'like', "%" . $clue . "%")
                ->where('participants.user_id', $user_id)
                ->orWhere('dosens.nama_dosen', 'like', "%" . $clue . "%")
                ->where('participants.user_id', $user_id)
                ->orWhere('seksis.kode_seksi', 'like', "%" . $clue . "%")
                ->where('participants.user_id', $user_id)
                ->orWhere('seksis.hari', 'like', "%" . $clue . "%")
                ->where('participants.user_id', $user_id)
                ->count();

            // mengambil data dari table pegawai sesuai pencarian data
            $clue = DB::table('seksis')
                ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
                ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
                ->join('participants', 'participants.id_seksi', '=', 'seksis.id')
                ->where('participants.user_id', $user_id)
                ->where('matakuliahs.nama_mk', 'like', "%" . $clue . "%")
                ->where('participants.user_id', $user_id)
                ->orWhere('dosens.nama_dosen', 'like', "%" . $clue . "%")
                ->where('participants.user_id', $user_id)
                ->orWhere('seksis.kode_seksi', 'like', "%" . $clue . "%")
                ->where('participants.user_id', $user_id)
                ->orWhere('seksis.hari', 'like', "%" . $clue . "%")
                ->where('participants.user_id', $user_id)
                ->get();

            if ($count_clue == 0) {
                return response()->json(["status" => "Gagal", "message" => "Kelas tidak ditemukan.", "data" => null]);
            } else {
                return response()->json(["status" => "Success", "message" => "Data berhasil ditemukan", "data" => $clue]);
            }
        } catch (Exception $e) {
            return response()->json(["status" => "Error", "message" => $e->getMessage()], $e->getCode());
        }
    }
}
