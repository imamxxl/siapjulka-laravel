<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuangController extends Controller
{
    function index(Request $request)
    {
        $ruang = Ruang::all()->where('status', '1');
        return view('admin.ruangan.manajemen_ruang', compact('ruang'));
    }

    function indexNonaktif(Request $request)
    {
        $ruang = Ruang::all()->where('status', '0');
        return view('admin.ruangan.ruang_nonaktif', compact('ruang'));
    }

    function insert(Request $request)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'kode_ruang' => 'required|unique:ruangs,kode_ruang|min:4|max:11',
                'nama_ruang' => 'required',
            ],
            [
                'kode_ruang.required' => 'Wajib diisi.',
                'kode_ruang.unique' => 'Kode Ruang ini ini sudah ada. Masukkan kode lain atau lihat data ruang yang telah dinon-aktifkan.',
                'kode_ruang.min' => 'Minimal 4 karakter.',
                'kode_ruang.max' => 'Maksimal 11 karakter.',
                'nama_ruang.required' => 'Wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/ruang')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal dimasukkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $createAt = date('Y-m-d H:i:s');
        $updateAt = date('Y-m-d H:i:s');

        $status = "1";

        $data = [
            'kode_ruang' => $request->kode_ruang,
            'nama_ruang' => $request->nama_ruang,
            'status' => $status,
            'created_at' => $createAt,
            'updated_at' => $updateAt
        ];

        Ruang::create($data);
        return redirect()->route('ruang')->with('pesan-sukses', 'Data berhasil ditambahkan.');
    }

    function update(Request $request, $kode_ruang)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'nama_ruang' => 'required',
            ],
            [
                'nama_ruang.required' => 'Wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/ruang')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal diupdate. Mohon cek kembali data yang ingin diupdate!');
        }

        $ruang = Ruang::find($kode_ruang);

        $ruang->update($request->all());

        return redirect()->route('ruang')->with('pesan-sukses', 'Data berhasil diupdate.');
    }

    function nonaktif($kode_ruang)
    {
        $nonaktif = "0";

        $data_ruang = Ruang::find($kode_ruang);
        $data_ruang->status = $nonaktif;

        $data_ruang->update();

        return redirect()->route('ruang')->with('pesan-sukses', 'Data berhasil dinonaktifkan. Silahkan tekan tombol "Data Non-Aktif" untuk melihat Data yang telah dinonaktifkan.');
    }

    function aktif($kode_ruang)
    {
        $aktif = "1";

        $data_ruang = Ruang::find($kode_ruang);
        $data_ruang->status = $aktif;

        $data_ruang->update();

        return redirect()->route('ruang_nonaktif')->with('pesan-sukses', 'Data berhasil diaktifkan. Silahkan tekan tombol "Kembali" untuk melihat tabel Data yang aktif.');
    }
}