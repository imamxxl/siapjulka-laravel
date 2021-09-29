<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Grup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {
        $user = User::orderBy('nama', 'ASC')->where('status', '1')->get();
        $jurusan = Jurusan::all()->where('status', '1');
        $grup = Grup::orderBy('kode_grup', 'DESC')->get()->where('status', '1');
        
        return view('admin.user.manajamen_user', compact('user', 'jurusan', 'grup'));
    }

    function indexNonaktif(Request $request)
    {
        $user = User::all()->where('status', '0');
        return view('admin.user.user_nonaktif', compact('user'));
    }

    function insertUserAdmin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username_admin' => 'required|unique:users,username|min:4|max:12',
                'nama_admin' => 'required',
                'nip_admin' => 'required|max:20',
                'jk_admin' => 'required',
                'password_admin' => 'required|min:6',
                'avatar_admin' => 'mimes:jpg,jpeg,png|max:1024'
            ],
            [
                'username_admin.required' => 'Wajib diisi.',
                'username_admin.unique' => 'Username ini ini sudah ada. Masukkan kode lain atau lihat data user yang telah dinonaktifkan.',
                'username_admin.min' => 'Minimal 4 karakter Angka.',
                'username_admin.max' => 'Maksimal 12 karakter Angka.',
                'nama_admin.required' => 'Wajib diisi.',
                'nip_admin.required' => 'Wajib diisi.',
                'nip_admin.max' => 'Maksimal 20 karakter Angka.',
                'jk_admin.required' => 'Jenis kelamin harus dipilih.',
                'password_admin.required' => 'Wajib diisi.',
                'password_admin.min' => 'Minimal 6 karakter',
                'avatar_admin.mimes' => 'Format tidak sesuai. Silahkan pilih format .jpg/.jpeg/.png.',
                'avatar_admin.max' => 'Size file foto tidak boleh lebih dari 1024KB / 1 MB'
            ],
        );

        if ($validator->fails()) {
            return redirect('/user')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal ditambahkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $file = $request->avatar_admin;
        if ($file == "") {
            $fileName = "default.jpg";
        } else {
            $photo = $request->file('avatar_admin');
            $fileName = $request->username_admin . '.' . $photo->getClientOriginalExtension();
            $location = public_path('avatar/' . $fileName);
            Image::make($photo)->resize(300, 300)->save($location);
        }

        $data = $request->all();

        // Inset ke table User
        $user = new User;
        $user->username = $data['username_admin'];
        $user->nama = $data['nama_admin'];
        $user->jk = $request->jk_admin;
        $user->password = Hash::make($request->password_admin);
        $user->status = '1';
        $user->level = 'admin';
        $user->avatar = $fileName;
        $user->created_at = $created_at;
        $user->updated_at = $updated_at;
        $user->save();

        // Insert ke table Admin
        $admin = new Admin;
        $admin->kode_admin = $request->username_admin;
        $admin->user_id = $user->id;
        $admin->nama_admin = $request->nama_admin;
        $admin->nip_admin = $request->nip_admin;
        $admin->created_at = $created_at;
        $admin->updated_at = $updated_at;
        $admin->save();

        return redirect()->route('user')->with('pesan-sukses', 'Data berhasil ditambahkan.');
    }

    function insertUserDosen(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username_dosen' => 'required|unique:users,username|min:4|max:12',
                'nama_dosen' => 'required',
                'nip_dosen' => 'required|max:20',
                'jk_dosen' => 'required',
                'password_dosen' => 'required|min:6',
                'avatar_dosen' => 'mimes:jpg,jpeg,png|max:1024'

            ],
            [
                'username_dosen.required' => 'Wajib diisi.',
                'username_dosen.unique' => 'Username ini ini sudah ada. Masukkan kode lain atau lihat data user yang telah dinonaktifkan.',
                'username_dosen.min' => 'Minimal 4 karakter Angka.',
                'username_dosen.max' => 'Maksimal 12 karakter Angka.',
                'nama_dosen.required' => 'Wajib diisi.',
                'nip_dosen.required' => 'Wajib diisi.',
                'nip_dosen.max' => 'Maksimal 20 karakter Angka.',
                'jk_dosen.required' => 'Jenis kelamin harus dipilih.',
                'password_dosen.required' => 'Wajib diisi.',
                'password_dosen.min' => 'Minimal 6 karakter',
                'avatar_dosen.mimes' => 'Format tidak sesuai. Silahkan pilih format .jpg/.jpeg/.png.',
                'avatar_dosen.max' => 'Size file foto tidak boleh lebih dari 1024KB / 1 MB'
            ],
        );

        if ($validator->fails()) {
            return redirect('/user')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal ditambahkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $file = $request->avatar_dosen;
        if ($file == "") {
            $fileName = "default.jpg";
        } else {
            $photo = $request->file('avatar_dosen');
            $fileName = $request->username_dosen . '.' . $photo->getClientOriginalExtension();
            $location = public_path('avatar/' . $fileName);
            Image::make($photo)->resize(300, 300)->save($location);
        }

        $data = $request->all();

        // Inset ke table User
        $user = new User;
        $user->username = $data['username_dosen'];
        $user->nama = $data['nama_dosen'];
        $user->password = Hash::make($request->password_dosen);
        $user->status = '1';
        $user->level = 'dosen';
        $user->jk = $request->jk_dosen;
        $user->avatar = $fileName;
        $user->created_at = $created_at;
        $user->updated_at = $updated_at;
        $user->save();

        // Insert ke table Dosen
        $dosen = new Dosen;
        $dosen->kode_dosen = $request->username_dosen;
        $dosen->user_id = $user->id;
        $dosen->nama_dosen = $request->nama_dosen;
        $dosen->nip_dosen = $request->nip_dosen;
        $dosen->created_at = $created_at;
        $dosen->updated_at = $updated_at;
        $dosen->save();

        return redirect()->route('user')->with('pesan-sukses', 'Data berhasil ditambahkan.');
    }

    function insertUserMahasiswa(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nim' => 'required|unique:users,username|min:8|max:12',
                'nama_mahasiswa' => 'required',
                'tahun' => 'required',
                'jk_mahasiswa' => 'required',
                'password_mahasiswa' => 'required|min:6',
                'avatar_mahasiswa' => 'mimes:jpg,jpeg,png|max:1024'

            ],
            [
                'nim.required' => 'Wajib diisi.',
                'nim.unique' => 'NIM ini ini sudah ada. Masukkan NIM lain atau lihat data user yang telah dinonaktifkan.',
                'nim.min' => 'Minimal 8 karakter Angka.',
                'nim.max' => 'Maksimal 12 karakter Angka.',
                'nama_mahasiswa.required' => 'Wajib diisi.',
                'tahun.required' => 'Tahun masuk harus dipilih.',
                'jk_mahasiswa.required' => 'Jenis kelamin harus dipilih.',
                'password_mahasiswa.required' => 'Wajib diisi.',
                'password_mahasiswa.min' => 'Minimal 6 karakter',
                'avatar_mahasiswa.mimes' => 'Format tidak sesuai. Silahkan pilih format .jpg/.jpeg/.png.',
                'avatar_mahasiswa.max' => 'Size file foto tidak boleh lebih dari 1024KB / 1 MB'
            ],
        );

        if ($validator->fails()) {
            return redirect('/user')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal ditambahkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $file = $request->avatar_mahasiswa;
        if ($file == "") {
            $fileName = "default.jpg";
        } else {
            $photo = $request->file('avatar_mahasiswa');
            $fileName = $request->nim . '.' . $photo->getClientOriginalExtension();
            $location = public_path('avatar/' . $fileName);
            Image::make($photo)->resize(300, 300)->save($location);
        }

        $data = $request->all();

        // Inset ke table User
        $user = new User;
        $user->username = $data['nim'];
        $user->nama = $data['nama_mahasiswa'];
        $user->password = Hash::make($request->password_mahasiswa);
        $user->status = '1';
        $user->level = 'mahasiswa';
        $user->jk = $request->jk_mahasiswa;
        $user->avatar = $fileName;
        $user->created_at = $created_at;
        $user->updated_at = $updated_at;
        $user->save();

        // Insert ke table Mahasiswa
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->tahun = $request->tahun;
        $mahasiswa->user_id = $user->id;
        $mahasiswa->nama_mahasiswa = $request->nama_mahasiswa;
        $mahasiswa->kode_jurusan = $request->kode_jurusan;
        $mahasiswa->kode_grup = $request->kode_grup;
        $mahasiswa->created_at = $created_at;
        $mahasiswa->updated_at = $updated_at;
        $mahasiswa->save();

        return redirect()->route('user')->with('pesan-sukses', 'Data berhasil ditambahkan.');
    }

    function changePassword(Request $request, $id)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|min:6',
            ],
            [
                'password.required' => 'Wajib diisi',
                'password.min' => 'Minimal 6 Karakter',
            ],
        );

        if ($validator->fails()) {
            return redirect('/user')
                ->withErrors($validator)
                ->withInput()
                ->with('password-gagal', 'Password gagal diperbaharui.');
        }

        $user = new User;

        // create updated_at
        $updated_at = date('Y-m-d H:i:s');

        // Jika validasi sudah selesai, lakukan simpan data
        //update ke tabel user
        $user = User::find($id);
        // $user->password = $request->password;
        $user->password = Hash::make($request->password);
        $user->updated_at = $updated_at;

        $user->update();

        return redirect()->route('user')->with('password-sukses', 'Password berhasil diperbaharui.');
    }

    function nonaktif($id)
    {
        $nonaktif = "0";

        $user = User::find($id);
        $user->status = $nonaktif;

        $user->update();

        return redirect()->route('user')->with('pesan-sukses', 'Data berhasil dinonaktifkan. Silahkan tekan tombol "Data User Nonaktif" untuk melihat Data yang telah dinonaktifkan.');
    }

    function aktif($id)
    {
        $aktif = "1";

        $user = User::find($id);
        $user->status = $aktif;

        $user->update();

        return redirect()->route('user_nonaktif')->with('pesan-sukses', 'Data berhasil diaktifkan. Silahkan tekan tombol "Kembali" untuk melihat tabel Data yang aktif.');
    }
}
