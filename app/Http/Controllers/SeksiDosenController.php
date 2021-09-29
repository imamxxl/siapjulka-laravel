<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Matakuliah;
use App\Models\Ruang;
use App\Models\Participant;
use App\Models\Seksi;
use App\Models\Jurusan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SeksiDosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        $seksi = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
            ->where('seksis.status', '1')
            // 5332 akan diganti dengan Middleware User Dosen yang login
            // ->where('seksis.kode_dosen', '5322')
            ->where('seksis.kode_dosen', Auth::user()->username )
            ->get();

        // get Dosen
        $dosen = DB::table('dosens')
            ->join('users', 'dosens.user_id', '=', 'users.id')
            ->where('status', '1')
            // ->where('kode_dosen', '5322')
            ->where('kode_dosen', Auth::user()->username )
            ->get();

        // get jam mulai
        $jadwal = Seksi::all();

        // Array hari
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // get ruangan
        $ruangan = Ruang::all();

        // get matakuliah
        $matakuliah_all = DB::table('matakuliahs')
            ->where('status', '1')
            ->orderBy('kode_mk', 'asc')
            ->get();

        // get jurusan
        $kode_jurusan = Jurusan::all()->where('status', '1');

        // make token
        $token = Str::random(6);
        $token_edit = Str::random(6);

        return view('dosen.seksi.seksi_dosen', compact(
            'seksi',
            'kode_jurusan',
            'matakuliah_all',
            'dosen',
            'hari',
            'ruangan',
            'token',
            'token_edit',
        ));
    }

    function indexNonaktif(Request $request)
    {
        $seksi = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
            ->where('seksis.status', '0')
            // 5332 akan diganti dengan Middleware User Dosen yang login
            ->where('seksis.kode_dosen', Auth::user()->username )
            ->get();

        return view('dosen.seksi.seksi_dosen_nonaktif', compact('seksi'));
    }

    function detail(Request $request, $id)
    {
        $seksi = DB::table('seksis')
            ->join('jurusans', 'seksis.kode_jurusan', '=', 'jurusans.kode_jurusan')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
            ->where('id', $id)
            ->get();

        $participant = DB::table('participants')
            ->join('seksis', 'seksis.id', '=', 'participants.id_seksi')
            ->join('users', 'users.id', '=', 'participants.user_id')
            ->where('id_seksi', $id)
            ->orderBy('nama', 'asc')
            ->get();

        $mahasiswa = DB::table('mahasiswas')
            ->whereNotIn('user_id', DB::table('participants')->select('user_id')->where('id_seksi', '=', $id))
            ->orderBy('nama_mahasiswa', 'asc')
            ->get();

        return view('dosen.seksi.seksi_detail', compact('seksi', 'participant', 'mahasiswa'));
    }

    function insertSeksi(Request $request)
    {

        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'kode_seksi' => 'required|unique:seksis,kode_seksi|min:12|max:20',
                'kode_mk' => 'required',
                'kode_jurusan' => 'required',
                'dosen' => 'required',
                'hari' => 'required',
                'jadwal_mulai' => 'required',
                'jadwal_selesai' => 'required',
                'ruangan' => 'required',
            ],
            [
                'kode_seksi.required' => 'Wajib diisi.',
                'kode_seksi.unique' => 'Kode Seksi ini ini sudah ada. Masukkan kode lain atau lihat data seksi yang telah dinon-aktifkan.',
                'kode_seksi.min' => 'Minimal 12 karakter.',
                'kode_seksi.max' => 'Maksimal 20 karakter.',
                'kode_mk.required' => 'Wajib diisi.',
                'kode_jurusan.required' => 'Wajib diisi.',
                'dosen.required' => 'Wajib diisi.',
                'hari.required' => 'Wajib diisi.',
                'jadwal_mulai.required' => 'Wajib diisi.',
                'jadwal_selesai.required' => 'Wajib diisi.',
                'ruangan.required' => 'Wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/seksi_dosen')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal dimasukkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        // Inset ke table Seksi
        $seksi = new Seksi;
        $seksi->kode_seksi = $request->kode_seksi;
        $seksi->token = $request->token;
        $seksi->kode_jurusan = $request->kode_jurusan;
        $seksi->kode_mk = $request->kode_mk;
        $seksi->kode_dosen = $request->dosen;
        $seksi->kode_ruang = $request->ruangan;
        $seksi->status = '1';
        $seksi->hari = $request->hari;
        $seksi->jadwal_mulai = $request->jadwal_mulai;
        $seksi->jadwal_selesai = $request->jadwal_selesai;
        $seksi->created_at = $created_at;
        $seksi->updated_at = $updated_at;
        $seksi->save();

        return redirect()->route('seksi_dosen')->with('pesan-sukses', 'Data seksi berhasil diinput.');
    }

    function addParticipant(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kode_seksi_detail' => 'required',
                'user_id' => 'required',
            ],
            [
                'kode_seksi_detail.required' => 'Wajib diisi.',
                'user_id.required' => '*Mahasiswa Belum Dipilih.',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Peserta gagal ditambahkan. Mohon isi/cek kembali data Peserta yang ingin ditambahkan!');
        }

        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $participant = new Participant;
        $participant->id_seksi = $request->kode_seksi_detail;
        $participant->user_id = $request->user_id;
        $participant->imei_participant = $request->imei;
        $participant->keterangan = '1';
        $participant->created_at = $created_at;
        $participant->updated_at = $updated_at;
        $participant->save();

        return redirect()->back()->with('pesan-sukses', 'Peserta berhasil ditambahkan.');
    }

    function deleteParticipant($id_participant)
    {
        $participant = DB::table('participants')
            ->where('id_participant', $id_participant);

        if ($participant != null) {
            $participant->delete();
            return redirect()->back()->with(['pesan-sukses' => 'Peserta berhasil dihapus.']);
        }

        return redirect()->back()->with('pesan-gagal', 'Peserta gagal dihapus.');
    }

    function verifParticipant($id_participant)
    {

        $participant = DB::table('participants')
            ->where('id_participant', $id_participant);

        if ($participant != null) {
            $participant->update(['keterangan' => 1]);
            return redirect()->back()->with(['pesan-sukses' => 'Peserta behasil diverifikasi.']);
        }

        return redirect()->back()->with('pesan-gagal', 'Peserta gagal diverifikasi.');
    }

    function update(Request $request, $id)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'dosen_edit' => 'required',
                'kode_mk_edit' => 'required',
                'hari_edit' => 'required',
                'jadwal_mulai_edit' => 'required',
                'jadwal_selesai_edit' => 'required',
                'ruangan_edit' => 'required',
            ],
            [
                'dosen_edit.required' => 'Wajib diisi.',
                'kode_mk_edit.required' => 'Wajib diisi.',
                'hari_edit.required' => 'Wajib diisi.',
                'jadwal_mulai_edit.required' => 'Wajib diisi.',
                'jadwal_selesai_edit.required' => 'Wajib diisi.',
                'ruangan_edit.required' => 'Wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/seksi_dosen')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal diupdate. Mohon cek kembali data yang ingin diupdate!');
        }

        $updated_at = date('Y-m-d H:i:s');

        $seksi = Seksi::find($id);

        $seksi->kode_seksi = $request->kode_seksi_edit;
        $seksi->kode_mk = $request->kode_mk_edit;
        $seksi->kode_dosen = $request->dosen_edit;
        $seksi->hari = $request->hari_edit;
        $seksi->jadwal_mulai = $request->jadwal_mulai_edit;
        $seksi->jadwal_selesai = $request->jadwal_selesai_edit;
        $seksi->kode_ruang = $request->ruangan_edit;
        $seksi->updated_at = $updated_at;

        $seksi->save();

        return redirect()->route('seksi_dosen')->with('pesan-sukses', 'Data berhasil diupdate.');
    }

    function resetToken(Request $request, $id)
    {
        $data_seksi = Seksi::find($id);
        $data_seksi->token = $request->token_baru;

        $data_seksi->update();

        return redirect()->route('seksi_dosen')->with('pesan-sukses', 'Token berhasil direset.');
    }

    function nonaktif($id)
    {
        $data_seksi = Seksi::find($id);
        $data_seksi->status = "0";

        $data_seksi->update();

        return redirect()->route('seksi_dosen')->with('pesan-sukses', 'Data berhasil dinonaktifkan. Silahkan tekan tombol "Data Non-Aktif" untuk melihat Data yang telah dinonaktifkan.');
    }

    function aktif($id)
    {
        $data_seksi = Seksi::find($id);
        $data_seksi->status = "1";

        $data_seksi->update();

        return redirect()->route('seksi_dosen_nonaktif')->with('pesan-sukses', 'Data berhasil diaktifkan. Silahkan tekan tombol "Kembali" untuk melihat tabel Data yang aktif.');
    }
}
