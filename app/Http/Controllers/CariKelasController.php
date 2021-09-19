<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CariKelasController extends Controller
{
    function index()
    {
        return view('mahasiswa.search.kelas');
    }

    function cariKelas(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'token' => 'required',
            ],
            [
                'token.required' => 'Token wajib diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect('/cari_kelas')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Kelas tidak ditemukan. Mohon isikan token dengan benar.');
        }

        // menangkap data pencarian
        $token = $request->token;

        $count_seksi = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
            ->where('token', 'like', "%" . $token . "%")
            ->count();

        if ($count_seksi == 0) {
            return redirect('/cari_kelas')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Token tidak ditemukan. Silahkan cek token dan isikan token dengan benar.');
        } else {
            // mengambil data dari table pegawai sesuai pencarian data
            $seksi = DB::table('seksis')
                ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
                ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
                ->where('token', 'like', "%" . $token . "%")
                ->paginate();
        }

        $user = DB::table('users')
            ->where('id', '1')
            ->get();

        // mengirim data pegawai ke view index
        return view('mahasiswa.search.cari-kelas', compact('seksi', 'user'));
    }

    function tambahParticipant(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id_seksi' => 'required',
                'user_id' => 'required',
            ],
            [
                'id_seksi.required' => 'Id Seksi Wajib diisi',
                'user_id.required' => 'Id User wajib diisi',
            ]
        );

        if ($validator->fails()) {
            return redirect('/cari_kelas')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Ada beberapa data yang kosong');
        }

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        // get data form
        $id_seksi = $request->id_seksi;
        $user_id = $request->user_id;
        $imei = $request->imei;

        $hasil_request = DB::table('participants')
           ->where('id_seksi', '=', $id_seksi)
           ->where('user_id', '=', $user_id)
           ->count();

        if ($hasil_request == 0) {
            $data = [
                'id_seksi' => $id_seksi,
                'user_id' => $user_id,
                'imei_participant' => $imei,
                'keterangan' => 0,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ];

            Participant::create($data);
            return redirect('/cari_kelas')
                ->with('pesan-sukses', 'Selamat, anda berhasil bergabung.');
        } else {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-kelas-terdeteksi', 'Mohon maaf, anda sudah bergabung di kelas ini.');
        }
    }
}
