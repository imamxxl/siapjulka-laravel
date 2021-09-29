<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grup;
use Illuminate\Support\Facades\Validator;

class GrupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $grup = Grup::all()->where('status', '1');
        return view('admin.grup.manajemen_grup', compact('grup'));
    }

    public function indexNonaktif(Request $request)
    {
        $grup = Grup::all()->where('status', '0');
        return view('admin.grup.grup_nonaktif', compact('grup'));
    }

    function insert(Request $request)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'kode_grup' => 'required|unique:grups,kode_grup|min:4|max:20',
            ],
            [
                'kode_grup.required' => 'Wajib diisi.',
                'kode_grup.unique' => 'Kode Grup ini ini sudah ada. Silahkan pilih kode lain atau lihat data Grup yang telah dinon-aktifkan.',
                'kode_grup.min' => 'Minimal 4 karakter.',
                'kode_grup.max' => 'Maksimal 20 karakter.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/grup')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal dimasukkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $createAt = date('Y-m-d H:i:s');
        $updateAt = date('Y-m-d H:i:s');

        $status = "1";

        $data = [
            'kode_grup' => $request->kode_grup,
            'nama_grup' => $request->nama_grup,
            'status' => $status,
            'created_at' => $createAt,
            'updated_at' => $updateAt
        ];

        Grup::create($data);
        return redirect()->route('grup')->with('pesan-sukses', 'Data berhasil ditambahkan.');
    }

    function update(Request $request, $kode_grup)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'nama_grup' => 'required',
            ],
            [
                'nama_grup.required' => 'Wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/grup')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal diupdate. Mohon cek kembali data yang ingin diupdate!');
        }

        $grup = Grup::find($kode_grup);

        $grup->update($request->all());

        return redirect()->route('grup')->with('pesan-sukses', 'Data berhasil diupdate.');
    }

    function nonaktif($kode_grup)
    {
        $nonaktif = "0";

        $data_grup = Grup::find($kode_grup);
        $data_grup->status = $nonaktif;

        $data_grup->update();

        return redirect()->route('grup')->with('pesan-sukses', 'Data berhasil dinonaktifkan. Silahkan tekan tombol "Data Non-Aktif" untuk melihat Data yang telah dinonaktifkan.');
    }

    function aktif($kode_grup)
    {
        $aktif = "1";

        $data_grup= Grup::find($kode_grup);
        $data_grup->status = $aktif;

        $data_grup->update();

        return redirect()->route('grup_nonaktif')->with('pesan-sukses', 'Data berhasil diaktifkan. Silahkan tekan tombol "Kembali" untuk melihat tabel Data yang aktif.');
    }

}
