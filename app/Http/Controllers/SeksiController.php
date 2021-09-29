<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Matakuliah;
use App\Models\Ruang;
use App\Models\Seksi;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon;
use League\CommonMark\Block\Element\Document;

class SeksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {
        // $seksi = Seksi::all()->where('status', '1'); // jika menggunakan eloquent

        $seksi = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
            ->where('seksis.status', '1')
            ->get();

        //get tahun
        $tahun = date('Y');

        //get bulan convert to semester
        $bulan = date('n');

        if ($bulan <= 6) {
            $semester = "2";
        } else {
            $semester = "1";
        }

        //variable kode_jurusan
        $ptik = "0760";
        $pte = "0650";
        $d3te = "0650";

        if (date('d') == '01' && date('n') == '07') {
            $digit_semester = '1';
        } elseif (date('d') == '01' && date('n') == '01') {
            $digit_semester = '1';
        }

        $kode_seksi_ptik_loop = Seksi::select('seksis')->where('kode_jurusan', 'S1-PTIK')->max('id');
        $kode_seksi_ptik_loop++;
        $kode_seksi_ptik = sprintf("%03s", $kode_seksi_ptik_loop);

        $kode_seksi_pte = Seksi::select('seksis')->where('kode_jurusan', 'S1-PTE')->max('id');
        $kode_seksi_pte++;
        $kode_seksi_pte = sprintf("%03s", $kode_seksi_pte);

        $kode_seksi_d3te = Seksi::select('seksis')->where('kode_jurusan', 'D3-PTE')->max('id');
        $kode_seksi_d3te++;
        $kode_seksi_d3te = sprintf("%03s", $kode_seksi_d3te);

        $kode_seksi_ptik_final =  $tahun . $semester . $ptik . $kode_seksi_ptik;
        $kode_seksi_pte_final =  $tahun . $semester . $pte . $kode_seksi_pte;
        $kode_seksi_d3te_final =  $tahun . $semester . $d3te . $kode_seksi_pte;

        // get Matakuliah
        $matakuliah_all = Matakuliah::all()->where('status', '1');
        $matakuliah_ptik = Matakuliah::all()->where('kode_jurusan', 'status', 'S1-PTIK', '1');

        $filter = ['S1-PTE', 'D3-PTE'];
        $matakuliah_pte = Matakuliah::whereIn('matakuliahs.kode_jurusan',  $filter)
            ->where('status', '1')
            ->get();

        // get Dosen
        $dosen = DB::table('dosens')
            ->join('users', 'dosens.user_id', '=', 'users.id')
            ->get()
            ->where('status', '1');

        $hitung_dosen = Dosen::all()->count();

        // get jurusan
        $hitung_jurusan_all = Jurusan::all()->where('status', '1')->count();
        $jurusan_ptik = Jurusan::all()->where('kode_jurusan', 'status', 'S1-PTIK', '1');
        $jurusan_pte = Jurusan::all()->where('kode_jurusan', 'status', 'S1-PTE', '1');
        $jurusan_d3te = Jurusan::all()->where('kode_jurusan', 'status', 'D3-PTE', '1');

        // get ruangan
        $ruangan = Ruang::all();

        // get jam mulai
        $jadwal = Seksi::all();
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // make token
        $token = Str::random(6);
        $token_edit = Str::random(6);

        return view('admin.seksi.manajemen_seksi', compact(
            'seksi',
            'jurusan_ptik',
            'jurusan_pte',
            'jurusan_d3te',
            'hitung_jurusan_all',
            'kode_seksi_ptik_final',
            'kode_seksi_pte_final',
            'kode_seksi_d3te_final',
            'matakuliah_all',
            'matakuliah_ptik',
            'matakuliah_pte',
            'dosen',
            'hitung_dosen',
            'ruangan',
            'hari',
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
            ->get();

        return view('admin.seksi.seksi_nonaktif', compact('seksi'));
    }

    function insertPTIK(Request $request)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'kode_seksi_ptik' => 'required|unique:seksis,kode_seksi|min:4|max:20',
                'dosen_ptik' => 'required',
                'kode_mk_ptik' => 'required',
                'hari_ptik' => 'required',
                'jadwal_mulai_ptik' => 'required',
                'jadwal_selesai_ptik' => 'required',
                'ruangan_ptik' => 'required',
            ],
            [
                'kode_seksi_ptik.required' => 'Wajib diisi.',
                'kode_seksi_ptik.unique' => 'Kode Seksi ini ini sudah ada. Masukkan kode lain atau lihat data seksi yang telah dinon-aktifkan.',
                'kode_seksi_ptik.min' => 'Minimal 4 karakter.',
                'kode_seksi_ptik.max' => 'Maksimal 20 karakter.',
                'dosen_ptik.required' => 'Wajib diisi.',
                'kode_mk_ptik.required' => 'Wajib diisi.',
                'hari_ptik.required' => 'Wajib diisi.',
                'jadwal_mulai_ptik.required' => 'Wajib diisi.',
                'jadwal_selesai_ptik.required' => 'Wajib diisi.',
                'ruangan_ptik.required' => 'Wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/seksi')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal dimasukkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        // Inset ke table Seksi
        $seksi = new Seksi;
        $seksi->kode_seksi = $request->kode_seksi_ptik;
        $seksi->token = $request->token_ptik;
        $seksi->kode_jurusan = 'S1-PTIK';
        $seksi->kode_mk = $request->kode_mk_ptik;
        $seksi->kode_dosen = $request->dosen_ptik;
        $seksi->kode_ruang = $request->ruangan_ptik;
        $seksi->status = '1';
        $seksi->hari = $request->hari_ptik;
        $seksi->jadwal_mulai = $request->jadwal_mulai_ptik;
        $seksi->jadwal_selesai = $request->jadwal_selesai_ptik;
        $seksi->created_at = $created_at;
        $seksi->updated_at = $updated_at;
        $seksi->save();

        return redirect()->route('seksi')->with('pesan-sukses', 'Data seksi Pend. Informatika berhasil ditambahkan.');
    }

    function insertPTE(Request $request)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                // 'kode_jurusan_ptik' => 'required',
                'kode_seksi_pte' => 'required|unique:seksis,kode_seksi|min:4|max:20',
                'dosen_pte' => 'required',
                'kode_mk_pte' => 'required',
                'hari_pte' => 'required',
                'jadwal_mulai_pte' => 'required',
                'jadwal_selesai_pte' => 'required',
                'ruangan_pte' => 'required',
            ],
            [
                // 'kode_jurusan_ptik.required' => 'Wajib memilih jurusan',
                'kode_seksi_pte.required' => 'Wajib diisi.',
                'kode_seksi_pte.unique' => 'Kode Seksi ini ini sudah ada. Masukkan kode lain atau lihat data seksi yang telah dinon-aktifkan.',
                'kode_seksi_pte.min' => 'Minimal 4 karakter.',
                'kode_seksi_pte.max' => 'Maksimal 20 karakter.',
                'dosen_pte.required' => 'Wajib diisi.',
                'kode_mk_pte.required' => 'Wajib diisi.',
                'hari_pte.required' => 'Wajib diisi.',
                'jadwal_mulai_pte.required' => 'Wajib diisi.',
                'jadwal_selesai_pte.required' => 'Wajib diisi.',
                'ruangan_pte.required' => 'Wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/seksi')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal dimasukkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        // Inset ke table Seksi
        $seksi = new Seksi;
        $seksi->kode_seksi = $request->kode_seksi_pte;
        $seksi->token = $request->token_pte;
        $seksi->kode_jurusan = 'S1-PTE';
        $seksi->kode_mk = $request->kode_mk_pte;
        $seksi->kode_dosen = $request->dosen_pte;
        $seksi->kode_ruang = $request->ruangan_pte;
        $seksi->status = '1';
        $seksi->hari = $request->hari_pte;
        $seksi->jadwal_mulai = $request->jadwal_mulai_pte;
        $seksi->jadwal_selesai = $request->jadwal_selesai_pte;
        $seksi->created_at = $created_at;
        $seksi->updated_at = $updated_at;
        $seksi->save();

        return redirect()->route('seksi')->with('pesan-sukses', 'Data seksi Elektronika berhasil ditambahkan.');
    }

    function insertD3TE(Request $request)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                // 'kode_jurusan_ptik' => 'required',
                'kode_seksi_d3te' => 'required|unique:seksis,kode_seksi|min:4|max:20',
                'dosen_d3te' => 'required',
                'kode_mk_d3te' => 'required',
                'hari_d3te' => 'required',
                'jadwal_mulai_d3te' => 'required',
                'jadwal_selesai_d3te' => 'required',
                'ruangan_d3te' => 'required',
            ],
            [
                // 'kode_jurusan_ptik.required' => 'Wajib memilih jurusan',
                'kode_seksi_d3te.required' => 'Wajib diisi.',
                'kode_seksi_d3te.unique' => 'Kode Seksi ini ini sudah ada. Masukkan kode lain atau lihat data seksi yang telah dinon-aktifkan.',
                'kode_seksi_d3te.min' => 'Minimal 4 karakter.',
                'kode_seksi_d3te.max' => 'Maksimal 20 karakter.',
                'dosen_d3te.required' => 'Wajib diisi.',
                'kode_mk_d3te.required' => 'Wajib diisi.',
                'hari_d3te.required' => 'Wajib diisi.',
                'jadwal_mulai_d3te.required' => 'Wajib diisi.',
                'jadwal_selesai_d3te.required' => 'Wajib diisi.',
                'ruangan_d3te.required' => 'Wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect('/seksi')
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data gagal dimasukkan. Mohon cek kembali data yang ingin dimasukkan!');
        }

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        // Inset ke table Seksi
        $seksi = new Seksi;
        $seksi->kode_seksi = $request->kode_seksi_d3te;
        $seksi->token = $request->token_d3te;
        $seksi->kode_jurusan = 'D3-PTE';
        $seksi->kode_mk = $request->kode_mk_d3te;
        $seksi->kode_dosen = $request->dosen_d3te;
        $seksi->kode_ruang = $request->ruangan_d3te;
        $seksi->status = '1';
        $seksi->hari = $request->hari_d3te;
        $seksi->jadwal_mulai = $request->jadwal_mulai_d3te;
        $seksi->jadwal_selesai = $request->jadwal_selesai_d3te;
        $seksi->created_at = $created_at;
        $seksi->updated_at = $updated_at;
        $seksi->save();

        return redirect()->route('seksi')->with('pesan-sukses', 'Data seksi Elektronika berhasil ditambahkan.');
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

        return view('admin.seksi.seksi_detail', compact('seksi', 'participant', 'mahasiswa'));
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
                'user_id.required' => 'Mahasiswa Belum Dipilih.',
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
            return redirect('/seksi')
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

        return redirect()->route('seksi')->with('pesan-sukses', 'Data berhasil diupdate.');
    }

    function resetToken(Request $request, $id)
    {
        $data_seksi = Seksi::find($id);
        $data_seksi->token = $request->token_baru;

        $data_seksi->update();

        return redirect()->route('seksi')->with('pesan-sukses', 'Token berhasil direset.');
    }

    function nonaktif($id)
    {
        $data_seksi = Seksi::find($id);
        $data_seksi->status = "0";

        $data_seksi->update();

        return redirect()->route('seksi')->with('pesan-sukses', 'Data berhasil dinonaktifkan. Silahkan tekan tombol "Data Non-Aktif" untuk melihat Data yang telah dinonaktifkan.');
    }

    function aktif($id)
    {
        $data_seksi = Seksi::find($id);
        $data_seksi->status = "1";

        $data_seksi->update();

        return redirect()->route('seksi_nonaktif')->with('pesan-sukses', 'Data berhasil diaktifkan. Silahkan tekan tombol "Kembali" untuk melihat tabel Data yang aktif.');
    }
}
