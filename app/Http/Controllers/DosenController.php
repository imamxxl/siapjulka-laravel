<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;

class DosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function index(Request $request)
    {
        $dosen = DB::table('users')
            ->join('dosens', 'users.id', '=', 'dosens.user_id')
            ->where('status', '1')
            ->orderBy('nama', 'asc')
            ->get();
            
        return view('admin.users.dosen.manajemen_dosen', compact('dosen'));
    }

    function indexNonaktif(Request $request)
    {
        $dosen = DB::table('users')
            ->join('dosens', 'users.id', '=', 'dosens.user_id')
            ->where('status', '0')
            ->get();
        return view('admin.users.dosen.manajemen_dosen_nonaktif', compact('dosen'));
    }

    function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_dosen' => 'required',
                'nip_dosen' => 'required',
                'nip_dosen' => 'required|max:20',
                'jk_dosen' => 'required',
                'avatar_dosen' => 'mimes:jpg,jpeg,png|max:1024'

            ],
            [

                'nama_dosen.required' => 'Wajib diisi.',
                'nip_dosen.required' => 'Wajib diisi.',
                'nip_dosen.max' => 'Maksimal 20 karakter Angka.',
                'jk_dosen.required' => 'Jenis kelamin harus dipilih.',
                'avatar_dosen.mimes' => 'Format tidak sesuai. Silahkan pilih format .jpg/.jpeg/.png.',
                'avatar_dosen.max' => 'Size file foto tidak boleh lebih dari 1024KB / 1 MB'
            ],
        );

        if ($validator->fails()) {
            return redirect('/dosen')
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
        $user->id = $request->id_dosen;
        $user->nama = $request->nama_dosen;
        $user->jk = $request->jk_dosen;
        $user->updated_at = $updated_at;

        if ($request->hasFile('avatar_dosen')) {
            $photo = $request->file('avatar_dosen');
            $filename = $request->kode_dosen . '.' . $photo->getClientOriginalExtension();
            $location = public_path('avatar/' . $filename);
            Image::make($photo)->resize(300, 300)->save($location);
            $user->avatar = $filename;

            $oldFilename = $user->avatar;
            $user->avatar = $filename;
            Storage::delete($oldFilename);
        }

        $user->save();

        // Insert to Dosen Table
        $dosen = new Dosen;
        $dosen = Dosen::find($id);
        $dosen = Dosen::where('user_id', $id)->first();
        $dosen->kode_dosen = $request->kode_dosen;
        $dosen->user_id = $request->id_dosen;
        $dosen->nama_dosen = $request->nama_dosen;
        $dosen->nip_dosen = $request->nip_dosen;
        $dosen->updated_at = $updated_at;
        $dosen->save();

        return redirect()->route('dosen')->with('pesan-sukses', 'Data berhasil diupdate.');
    }

    function nonaktif($id)
    {
        $nonaktif = "0";

        $data_dosen = User::find($id);
        $data_dosen->status = $nonaktif;

        $data_dosen->update();

        return redirect()->route('dosen')->with('pesan-sukses', 'Data berhasil dinonaktifkan. Silahkan tekan tombol "Lihat Dosen Non-Aktif" untuk melihat Data yang telah dinonaktifkan.');
    }

    function aktif($id)
    {
        $aktif = "1";

        $data_mk = User::find($id);
        $data_mk->status = $aktif;

        $data_mk->update();

        return redirect()->route('dosen_nonaktif')->with('pesan', 'Data berhasil diaktifkan. Silahkan tekan tombol "Kembali" untuk melihat tabel Data yang aktif.');
    }
}