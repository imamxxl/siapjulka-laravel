<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Jurusan;
use App\Models\Grup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;

class MahasiswaController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {

        $opsi_jurusan = [
            ['kode' => 'S1-PTIK', 'nama' => 'S1 - Pendidikan Teknik Informatika dan Komputer',],
            ['kode' => 'S1-PTE', 'nama' => 'S1 - Pendidikan Teknik Elektronika',],
            ['kode' => 'D3-PTE', 'nama' => 'D3 - Teknik Elekronika',],
        ];

        $jurusan = Jurusan::all()->where('status', '1');

        $grup = Grup::all()->sortByDesc('kode_grup')->where('status', '1');

        $mahasiswa = DB::table('users')
            ->join('mahasiswas', 'users.id', '=', 'mahasiswas.user_id')
            ->where('status', '1')
            ->orderBy('nama', 'asc')
            ->get();

        return view('admin.users.mahasiswa.manajemen_mahasiswa', compact('mahasiswa', 'jurusan', 'opsi_jurusan', 'grup'));
    }

    function indexNonaktif(Request $request)
    {
        $mahasiswa = DB::table('users')
            ->join('mahasiswas', 'users.id', '=', 'mahasiswas.user_id')
            ->where('status', '0')
            ->get();
        return view('admin.users.mahasiswa.manajemen_mahasiswa_nonaktif', compact('mahasiswa'));
    }

    function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_mahasiswa' => 'required',
                'avatar_mahasiswa' => 'mimes:jpg,jpeg,png|max:1024'

            ],
            [
                'nama_mahasiswa.required' => 'Wajib diisi.',
                'avatar_mahasiswa.mimes' => 'Format tidak sesuai. Silahkan pilih format .jpg/.jpeg/.png.',
                'avatar_mahasiswa.max' => 'Size file foto tidak boleh lebih dari 1024KB / 1 MB'
            ],
        );

        if ($validator->fails()) {
            return redirect('/mahasiswa')
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
        $user->id = $request->id_mahasiswa;
        $user->nama = $request->nama_mahasiswa;
        $user->jk = $request->jk_mahasiswa;
        $user->updated_at = $updated_at;

        if ($request->hasFile('avatar_mahasiswa')) {
            $photo = $request->file('avatar_mahasiswa');
            $filename = $request->nim . '.' . $photo->getClientOriginalExtension();
            $location = public_path('avatar/' . $filename);
            Image::make($photo)->resize(300, 300)->save($location);
            $user->avatar = $filename;

            $oldFilename = $user->avatar;
            $user->avatar = $filename;
            Storage::delete($oldFilename);
        }

        $user->save();

        // Insert to Dosen Table
        $mahasiswa = new Mahasiswa();
        $mahasiswa = Mahasiswa::find($id);
        $mahasiswa = Mahasiswa::where('user_id', $id)->first();
        $mahasiswa->nim = $request->nim;
        $mahasiswa->user_id = $request->id_mahasiswa;
        $mahasiswa->nama_mahasiswa = $request->nama_mahasiswa;
        $mahasiswa->kode_jurusan = $request->kode_jurusan;
        $mahasiswa->kode_grup = $request->kode_grup;
        $mahasiswa->updated_at = $updated_at;
        $mahasiswa->save();

        return redirect()->route('mahasiswa')->with('pesan-sukses', 'Data berhasil diupdate.');
    }

    public function getKodeGrup($kode_grup)
    {
        $grup = Grup::find($kode_grup);
        return view('users.mahasiswa.manajemen_mahasiswa', compact('grup'));
    }

    function nonaktif($id)
    {
        $nonaktif = "0";

        $data_mahasiswa = User::find($id);
        $data_mahasiswa->status = $nonaktif;

        $data_mahasiswa->update();

        return redirect()->route('mahasiswa')->with('pesan-sukses', 'Data berhasil dinonaktifkan. Silahkan tekan tombol "Lihat Mahasiswa Non-Aktif" untuk melihat Data yang telah dinonaktifkan.');
    }

    function aktif($id)
    {
        $aktif = "1";

        $data_mk = User::find($id);
        $data_mk->status = $aktif;

        $data_mk->update();
        return redirect()->route('mahasiswa_nonaktif')->with('pesan-sukses', 'Data berhasil diaktifkan. Silahkan tekan tombol "Kembali" untuk melihat tabel Data yang aktif.');
    }

    function resetIMEI($id)
    {
        // update imei to null users table
        $data_imei_user = User::find($id);
        $data_imei_user->imei = null;
        $data_imei_user->save();

        // update imei to null mahaasiswas tabless
        Mahasiswa::where('user_id', $id)->update(['imei_mahasiswa' => null]);

        return redirect()->route('mahasiswa')->with('pesan-sukses', 'IMEI berhasil direset.');
    }

}
