<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {
        $admin = DB::table('users')
            ->join('admins', 'users.id', '=', 'admins.user_id')
            ->where('status', '1')
            ->orderBy('nama', 'asc')
            ->get();
            
        return view('admin.users.admin.manajemen_admin', compact('admin'));
    }

    function indexNonaktif(Request $request)
    {
        $admin = DB::table('users')
            ->join('admins', 'users.id', '=', 'admins.user_id')
            ->where('status', '0')
            ->get();
        return view('admin.users.admin.manajemen_admin_nonaktif', compact('admin'));
    }

    function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_admin' => 'required',
                'nip_admin' => 'required',
                'nip_admin' => 'required|max:20',
                'jk_admin' => 'required',
                'avatar_admin' => 'mimes:jpg,jpeg,png|max:1024'

            ],
            [

                'nama_admin.required' => 'Wajib diisi.',
                'nip_admin.required' => 'Wajib diisi.',
                'nip_admin.max' => 'Maksimal 20 karakter Angka.',
                'jk_admin.required' => 'Jenis kelamin harus dipilih.',
                'avatar_admin.mimes' => 'Format tidak sesuai. Silahkan pilih format .jpg/.jpeg/.png.',
                'avatar_admin.max' => 'Size file foto tidak boleh lebih dari 1024KB / 1 MB'
            ],
        );

        if ($validator->fails()) {
            return redirect('/admin')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal diupdate. Mohon cek kembali data yang ingin diupdate!');
        }

        // updated_at
        $updated_at = date('Y-m-d H:i:s');

        // Insert to User Table
        $user = new User;
        $user = User::find($id);
        $user = User::where('id', $id)->first();
        $user->id = $request->id_admin;
        $user->nama = $request->nama_admin;
        $user->jk = $request->jk_admin;
        $user->updated_at = $updated_at;

        if ($request->hasFile('avatar_admin')) {
            $photo = $request->file('avatar_admin');
            $filename = $request->kode_admin . '.' . $photo->getClientOriginalExtension();
            $location = public_path('avatar/' . $filename);
            Image::make($photo)->resize(300, 300)->save($location);
            $user->avatar = $filename;

            $oldFilename = $user->avatar;
            $user->avatar = $filename;
            Storage::delete($oldFilename);
        }

        $user->save();

        // Insert to Admin Table
        $admin = new Admin;
        $admin = Admin::find($id);
        $admin = Admin::where('user_id', $id)->first();
        $admin->kode_admin = $request->kode_admin;
        $admin->user_id = $request->id_admin;
        $admin->nama_admin = $request->nama_admin;
        $admin->nip_admin = $request->nip_admin;
        $admin->updated_at = $updated_at;
        $admin->save();

        return redirect()->route('admin')->with('pesan-sukses', 'Data berhasil diupdate.');

    }

    function nonaktif($id)
    {
        $nonaktif = "0";

        $data_admin = User::find($id);
        $data_admin->status = $nonaktif;

        $data_admin->update();

        return redirect()->route('admin')->with('pesan-sukses', 'Data berhasil dinonaktifkan. Silahkan tekan tombol "Lihat Admin Non-Aktif" untuk melihat Data yang telah dinonaktifkan.');
    }

    function aktif($id)
    {
        $aktif = "1";

        $data_mk = User::find($id);
        $data_mk->status = $aktif;

        $data_mk->update();

        return redirect()->route('admin_nonaktif')->with('pesan', 'Data berhasil diaktifkan. Silahkan tekan tombol "Kembali" untuk melihat tabel Data yang aktif.');
    }
}
