<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;

class UserController extends Controller
{
    function get()
    {
        $users = User::all();
        return response()->json(
            $users
        );
    }

    function show($id)
    {
        $user = DB::table('mahasiswas')
        ->join('jurusans', 'jurusans.kode_jurusan', '=', 'mahasiswas.kode_jurusan')
        ->join('users', 'users.id', '=', 'mahasiswas.user_id')
        ->where('user_id', $id)->first();
        
        if (!empty($user)) {
            return response()->json(
                $user
            );
        } else {
            return response()->json([
                'message' => 'Tidak dapat menemukan user dengan id ' . $id . ' ',
                'data' => null
            ], 404);
        }
    }

    function login(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "username" => "required",
                    "password" => "required|min:6",
                ],
                [
                    'username.required' => 'User wajib diisi',
                    'password.required' => 'Password wajib diisi',
                    'password.min' => 'Password minimal 6 karakter'
                ]
            );
            if ($validator->fails()) {
                throw new Exception($validator->errors()->first(), 400);
            }
            $user = User::where('username', $request->username)->first();
            if ($user == null) {
                throw new Exception("User " . $request->username . " tidak terdaftar di dalam sistem ", 404);
            }
            if (!Hash::check($request->password, $user->password)) {
                throw new Exception("Password tidak valid", 400);
            }
            return response()->json($user, 200);
        } catch (Exception $e) {
            return response()->json(["status" => "Error", "message" => $e->getMessage()], $e->getCode());
        }
    }
}
