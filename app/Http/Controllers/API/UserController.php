<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class UserController extends Controller
{
    function get()
    {
        $user = User::all();
        return response()->json([
            "status" => "Ok",
            "message" => "Data ditemukan",
            "data" => $user
        ]);
    }

    function show($id)
    {
        $user = User::find($id);
        if (!empty($user)) {
            return response()->json([
                "status" => "ok",
                'message' => 'User ditemukan',
                'data' => $user
            ]);
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
                throw new Exception("User " . $request->username . " tidak ditemukan ", 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                throw new Exception("Password tidak valid", 400);
            }

            return response()->json(["status" => "ok", "message" => "Berhasil login", "data" => $user], 200);
        } catch (Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], $e->getCode());
        }
    }
}
