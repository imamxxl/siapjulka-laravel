<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class LaporanController extends Controller
{
    function show(Request $request, $id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "id_seksi" => "required",
                ],
                [
                    'id_seksi.required' => 'Seksi wajib ada',
                ]
            );

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 400);
            }

            $seksi = DB::table('absensis')
                ->select(
                    'absensis.id_seksi',
                    'seksis.kode_seksi',
                    'matakuliahs.nama_mk',
                    'dosens.nama_dosen',
                    'seksis.hari',
                    'seksis.jadwal_mulai',
                    'seksis.jadwal_selesai',
                    'matakuliahs.sks',
                    'seksis.kode_ruang',
                )
                ->join('seksis', 'seksis.id', '=', 'absensis.id_seksi')
                ->join('matakuliahs', 'matakuliahs.kode_mk', '=', 'seksis.kode_mk')
                ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
                ->where('absensis.id_user', $id)
                ->where('absensis.id_seksi', '=', $request->id_seksi)
                ->first();

            if ($seksi != null) {
                $mahasiswa = DB::table('users')->where('id', $id)->pluck('nama')->first();
                $nim = DB::table('users')->where('id', $id)->pluck('username')->first();

                $pertemuan = DB::table('absensis')
                    ->where('id_user', $id)
                    ->where('id_seksi', $request->id_seksi)
                    ->count();

                $absensi_belum_verifikasi = DB::table('absensis')
                    ->where('id_user', $id)
                    ->where('id_seksi', $request->id_seksi)
                    ->where('verifikasi', null)
                    ->count();

                $hadir = DB::table('absensis')
                    ->where('id_user', $id)
                    ->where('id_seksi', $request->id_seksi)
                    ->where('verifikasi', 1)
                    ->where('keterangan', 'hadir')
                    ->count();

                $izin = DB::table('absensis')
                    ->where('id_user', $id)
                    ->where('id_seksi', $request->id_seksi)
                    ->where('verifikasi', 1)
                    ->where('keterangan', 'izin')
                    ->count();

                $alpa = DB::table('absensis')
                    ->where('id_user', $id)
                    ->where('id_seksi', $request->id_seksi)
                    ->where('verifikasi', 1)
                    ->where('keterangan', null)
                    ->count();

                return response()->json(
                    [
                        "status" => "Success",
                        "message" => "Data berhasil ditemukan",
                        "seksi" => $seksi,
                        "nama" => $mahasiswa,
                        "nim" => $nim,
                        "pertemuan" => $pertemuan,
                        "absensi_belum_diverifikasi" => $absensi_belum_verifikasi,
                        "hadir" => $hadir,
                        "izin" => $izin,
                        "alpa" => $alpa
                    ]
                );
            } else {
                return response()->json(["status" => "Error", "message" => "Belum ada data", "data" => null]);
            }
        } catch (Exception $e) {
            return response()->json(["status" => "Error", "message" => $e->getMessage(), "data" => null], $e->getCode(),);
        }
    }
}
