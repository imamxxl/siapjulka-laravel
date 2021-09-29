<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatakuliahController extends Controller
{
    public function __construct()
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

        $matakuliah = Matakuliah::orderBy('nama_mk', 'ASC')->where('status', '1')->get();
        
        $hitung_jurusan = Jurusan::all()->where('status', '1')->count();
        $jurusan = Jurusan::all()->where('status', '1');

        return view('admin.matakuliah.manajemen_matakuliah', compact('matakuliah', 'jurusan', 'opsi_jurusan', 'hitung_jurusan'));
    }

    function indexNonaktif(Request $request)
    {
        $matakuliah = Matakuliah::all()->where('status', '0');
        return view('admin.matakuliah.matakuliah_nonaktif', compact('matakuliah'));
    }

    function insert(Request $request)
    {

        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'kode_mk' => 'required|unique:matakuliahs,kode_mk|min:6|max:12',
                'nama_mk' => 'required',
                'sks' => 'required',
                'kode_jurusan' => 'required',
            ],
            [
                'kode_mk.required' => 'Wajib diisi.',
                'kode_mk.unique' => 'Kode Matakuliah ini ini sudah ada. Masukkan kode lain atau lihat data matakuliah yang telah dinon-aktifkan.',
                'kode_mk.min' => 'Minimal 6 karakter.',
                'kode_mk.max' => 'Maksimal 12 karakter.',
                'nama_mk.required' => 'Wajib diisi.',
                'sks.required' => 'Wajib memilih SKS.',
                'kode_jurusan.required' => 'Wajib memilih Jurusan.',
                'status.required' => 'Wajib pilih status.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/matakuliah')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal dimasukkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $createAt = date('Y-m-d H:i:s');
        $updateAt = date('Y-m-d H:i:s');

        $status = "1";

        $data = [
            'kode_mk' => $request->kode_mk,
            'nama_mk' => $request->nama_mk,
            'kode_jurusan' => $request->kode_jurusan,
            'sks' => $request->sks,
            'status' => $status,
            'created_at' => $createAt,
            'updated_at' => $updateAt
        ];

        Matakuliah::create($data);
        
        return redirect()->route('matakuliah')->with('pesan-sukses', 'Data berhasil ditambahkan.');
    }

    function update(Request $request, $kode_mk)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'nama_mk' => 'required',
                'sks' => 'required',
            ],
            [
                'nama_mk.required' => 'Wajib diisi.',
                'sks.required' => 'Wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/matakuliah')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal diupdate. Mohon cek kembali data yang ingin diupdate!');
        }

        $matakuliah = Matakuliah::find($kode_mk);
        $matakuliah->nama_mk = $request->nama_mk;
        $matakuliah->sks = $request->sks;
        $matakuliah->kode_jurusan = $request->kode_jurusan;

        $matakuliah->save();

        return redirect()->route('matakuliah')->with('pesan-sukses', 'Data berhasil diupdate.');
    }

    function nonaktif($kode_mk)
    {
        $nonaktif = "0";

        $data_mk = Matakuliah::find($kode_mk);
        $data_mk->status = $nonaktif;

        $data_mk->update();

        return redirect()->route('matakuliah')->with('pesan-sukses', 'Data berhasil dinonaktifkan. Silahkan tekan tombol "Data Non-Aktif" untuk melihat Data yang telah dinonaktifkan.');
    }

    function aktif($kode_mk)
    {
        $aktif = "1";

        $data_mk = Matakuliah::find($kode_mk);
        $data_mk->status = $aktif;

        $data_mk->update();

        return redirect()->route('matakuliah_nonaktif')->with('pesan-sukses', 'Data berhasil diaktifkan. Silahkan tekan tombol "Kembali" untuk melihat tabel Data yang aktif.');
    }
}
