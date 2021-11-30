<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pertemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class PertemuanController extends Controller
{
    function get()
    {
        $data = Pertemuan::all();
        return response()->json(
            $data
        );
    }

    // menampilkan pertemuan berdasarkan kode_seksi yang di pilih
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
                $deteksi_pertemuan = DB::table('absensis')
                    ->where('id_seksi', $request->id_seksi)
                    ->where('id_user', $id)
                    ->first();

                $pertemuan = DB::table('absensis')
                    ->select('absensis.id_absensi', 'seksis.kode_seksi', 'seksis.kode_jurusan', 'seksis.kode_mk',
                    'seksis.kode_dosen', 'seksis.kode_ruang', 'seksis.hari', 'seksis.jadwal_mulai', 
                    'seksis.jadwal_selesai', 'seksis.status', 'absensis.id_pertemuan', 
                    'absensis.imei_absensi', 'absensis.keterangan', 'absensis.catatan', 'absensis.verifikasi', 
                    'matakuliahs.nama_mk', 'matakuliahs.sks', 'pertemuans.id_pertemuan', 'pertemuans.tanggal', 'pertemuans.materi')
                    ->join('seksis', 'seksis.id', '=', 'absensis.id_seksi')
                    ->join('matakuliahs', 'matakuliahs.kode_mk', '=', 'seksis.kode_mk')
                    ->join('pertemuans', 'pertemuans.id_pertemuan', '=', 'absensis.id_pertemuan')
                    ->where('absensis.id_seksi', $request->id_seksi)
                    ->where('absensis.id_user', $id)
                    ->get();

                if ($deteksi_pertemuan == null) {
                    return response()->json([
                        'status' => 'Error',
                        "message" => "Tidak ada pertemuan terdeteksi",
                        "data" => null
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
