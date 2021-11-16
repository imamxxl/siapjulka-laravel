<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Mahasiswa as MiddlewareMahasiswa;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class DeviceController extends Controller
{
    function show($id)
    {
        $device_check = User::where('id', $id)->value('imei');

        $device = DB::table('users')
            ->select('imei')
            ->where('id', $id)
            ->first();

        if ($device_check == null) {
            return response()->json([
                "status" => 0,
                "message" => "Perangkat belum terdaftar di sistem"
            ]);
        } else {
            return response()->json(
                $device
            );
        }
    }

    function store(Request $request, $id)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "imei" => "required",
                ],
                [
                    'imei.required' => 'Imei wajib ada',
                ]
            );

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 400);
            }

            $user = User::where('id', $request->id)->first();
            if ($user == null) {
                throw new Exception("User" . $request->username . " tidak terdaftar di dalam sistem ", 404);
            }

            //update imei ke tabel users
            $user = new User;
            $user = User::find($id);
            $user->imei = $request->imei;
            $user->update();

            // update imei ke tabel mahasiswas
            DB::table('mahasiswas')
              ->where('user_id', $id)
              ->update(['imei_mahasiswa' => $request->imei]);
            
              // return data
            return response()->json(["status" => "Sukses", "message" => "Perangkat berhasil didaftarkan"]);

        } catch (Exception $e) {
            return response()->json(["status" => "Gagal", "message" => $e->getMessage()], $e->getCode());
        }
    }
}
