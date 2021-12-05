<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class AbsensiController extends Controller
{
    function get()
    {
        $data = Absensi::all();
        return response()->json(
            $data
        );
    }

    function getById($id_absensi)
    {
        $absensi = Absensi::where('id_absensi', $id_absensi)->get();

        $count_data = $absensi->count();

        if ($count_data == 0) {
            return response()->json(
                [
                    "message" => "Data tidak ditemukan",
                ],
            );
        } else {
            return response()->json(
                $absensi
            );
        }
    }

    function post(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "id_user" => "required",
                    "qrcode" => "required",
                    "device_id" => "required",
                ],
                [
                    'id_user.required' => 'User wajib ada',
                    'qrcode.required' => 'Wajib ada',
                    'device_id.required' => 'Device id wajib ada',
                ]
            );

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 400);
            }

            $cek_verifikasi = DB::table('absensis')
                ->where('id_user', $request->id_user)
                ->where('qrcode', $request->qrcode)
                ->value('verifikasi');

            $cek_value_absensi = DB::table('absensis')
                ->where('id_user', $request->id_user)
                ->where('qrcode', $request->qrcode)
                ->value('keterangan');

            $cek_id_absensi = DB::table('absensis')
                ->where('id_user', $request->id_user)
                ->where('qrcode', $request->qrcode)
                ->value('id_absensi');

            $cek_qrcode = DB::table('absensis')
                ->where('id_user', $request->id_user)
                ->where('id_absensi', $cek_id_absensi)
                ->first();

            $cek_imei = DB::table('absensis')
                ->where('id_absensi', $cek_id_absensi)
                ->where('qrcode', $request->qrcode)
                ->where('imei_absensi', $request->device_id)
                ->first();

            $absensi = Absensi::where('id_absensi', $cek_id_absensi)->first();

            if ($cek_verifikasi == null) {
                if ($cek_value_absensi == null) {
                    if ($cek_qrcode) {
                        if ($cek_imei) {
                            $absensi->keterangan = 'hadir';
                            $absensi->save();
                            return response()->json(
                                [
                                    "status" => "Success",
                                    "message" => "Anda telah mengisi kehadiran",
                                    "data" => $absensi
                                ]
                            );
                        } else {
                            return response()->json(
                                [
                                    "status" => "Error",
                                    "message" => "Perangkat tidak terdaftar"
                                ]
                            );
                        }
                    }
                    return response()->json(
                        [
                            "status" => "Error",
                            "message" => "QR Code tidak cocok"
                        ]
                    );
                }
                return response()->json(
                    [
                        "status" => "Error",
                        "message" => "Anda sudah melakukan absensi. Absensi hanya dapat dilakukan satu kali."
                    ]
                );
            } else {
                return response()->json(
                    [
                        "status" => "Error",
                        "message" => "Absensi sudah ditutup. Anda tidak dapat melakukan absensi lagi."
                    ]
                );
            }
            
        } catch (Exception $e) {
            return response()->json(["status" => "Error", "message" => $e->getMessage(), "data" => null], $e->getCode(), );
        }
    }
}
