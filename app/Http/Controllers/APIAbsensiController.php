<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;

class APIAbsensiController extends Controller
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

    function put($id_absensi, Request $request)
    {
        // get data from client
        $id_pertemuan = $request->id_pertemuan;
        $qrcode = $request->qrcode;
        $imei = $request->imei;
        $keterangan = $request->keterangan;
        $updated_at = date('Y-m-d H:i:s');

        $absensi = Absensi::where('id_absensi', $id_absensi)->first();

        $cek_value_absensi = Absensi::where('id_absensi', $id_absensi)->value('keterangan');

        $cek_qrcode = DB::table('absensis')
            ->where('id_absensi', $id_absensi)
            ->where('qrcode', $qrcode)
            ->first();

        $cek_imei = DB::table('absensis')
            ->where('id_absensi', $id_absensi)
            ->where('qrcode', $qrcode)
            ->where('imei_absensi', $imei)
            ->first();

        if ($cek_value_absensi == null) {
            if ($absensi) {
                if ($cek_qrcode) {
                    if ($cek_imei) {

                        $absensi->keterangan = 'hadir';
                        $absensi->save();

                        return response()->json(
                            [
                                "message" => "Anda telah mengisi kehadiran",
                                "data" => $absensi
                            ]
                        );
                    } else {
                        return response()->json(
                            [
                                "message" => "Perangkat tidak terdaftar di sistem"
                            ]
                        );
                    }
                }
                return response()->json(
                    [
                        "message" => "QR Code tidak ditemukan"
                    ]
                );
            }
            return response()->json(
                [
                    "message" => "Gagal mengirim data. data tidak dikenal"
                ]
            );
        }
        return response()->json(
            [
                "message" => "Anda sudah melakukan absensi. Absensi hanya dapat dilakukan satu kali."
            ]
        );
        
    }
}
