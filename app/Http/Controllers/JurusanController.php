<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JurusanController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {
        $jurusan = Jurusan::all()->where('status', '1');
        return view('admin.jurusan.manajemen_jurusan', compact('jurusan'));
    }

    function indexNonaktif(Request $request)
    {
        $jurusan = Jurusan::all()->where('status', '0');
        return view('admin.jurusan.jurusan_nonaktif', compact('jurusan'));
    }

    function insert(Request $request)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'kode_jurusan' => 'required|unique:jurusans,kode_jurusan|min:4|max:11',
                'nama_jurusan' => 'required',
            ],
            [
                'kode_jurusan.required' => 'Wajib diisi.',
                'kode_jurusan.unique' => 'Kode Jurusan ini ini sudah ada. Masukkan kode lain atau lihat data jurusan yang telah dinon-aktifkan.',
                'kode_jurusan.min' => 'Minimal 4 karakter.',
                'kode_jurusan.max' => 'Maksimal 11 karakter.',
                'nama_jurusan.required' => 'Wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/jurusan')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal dimasukkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $createAt = date('Y-m-d H:i:s');
        $updateAt = date('Y-m-d H:i:s');

        $status = "1";

        $data = [
            'kode_jurusan' => $request->kode_jurusan,
            'nama_jurusan' => $request->nama_jurusan,
            'status' => $status,
            'created_at' => $createAt,
            'updated_at' => $updateAt
        ];

        Jurusan::create($data);
        return redirect()->route('jurusan')->with('pesan-sukses', 'Data berhasil ditambahkan.');
    }

    function update(Request $request, $kode_jurusan)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'nama_jurusan' => 'required',
            ],
            [
                'nama_jurusan.required' => 'Wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/jurusan')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal diupdate. Mohon cek kembali data yang ingin diupdate!');
        }

        $jurusan = Jurusan::find($kode_jurusan);

        $jurusan->update($request->all());

        return redirect()->route('jurusan')->with('pesan-sukses', 'Data berhasil diupdate.');
    }

    function nonaktif($kode_jurusan)
    {
        $nonaktif = "0";

        $data_jurusan = Jurusan::find($kode_jurusan);
        $data_jurusan->status = $nonaktif;

        $data_jurusan->update();

        return redirect()->route('jurusan')->with('pesan-sukses', 'Data berhasil dinonaktifkan. Silahkan tekan tombol "Data Non-Aktif" untuk melihat Data yang telah dinonaktifkan.');
    }

    function aktif($kode_jurusan)
    {
        $aktif = "1";

        $data_jurusan = Jurusan::find($kode_jurusan);
        $data_jurusan->status = $aktif;

        $data_jurusan->update();

        return redirect()->route('jurusan_nonaktif')->with('pesan-sukses', 'Data berhasil diaktifkan. Silahkan tekan tombol "Kembali" untuk melihat tabel Data yang aktif.');
    }
}
