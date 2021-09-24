<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertemuan;
use App\Models\Absensi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class AbsensiMahasiswaController extends Controller
{
    function index(Request $request)
    {
        $cek_seksi = DB::table('seksis')
            ->join('participants', 'participants.id_seksi', '=', 'seksis.id')
            ->where('status', '1')
            // 1 akan diganti dengan Middleware User Mahasiswa yang login
            ->where('user_id', '1')
            ->count();

        $seksi = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
            ->join('participants', 'participants.id_seksi', '=', 'seksis.id')
            ->where('seksis.status', '1')
            // 5332 akan diganti dengan Middleware User Mahasiswa yang login
            ->where('participants.user_id', '1')
            ->get();

        $participant = DB::table('participants')
            ->join('seksis', 'seksis.id', '=', 'participants.id_seksi')
            ->join('users', 'users.id', '=', 'participants.user_id')
            ->get();

        return view('mahasiswa.absensi.absensi', compact('seksi', 'cek_seksi', 'participant'));
    }

    function lihatPeserta($id)
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

        return view('mahasiswa.absensi.absensi_lihat_peserta', compact('seksi', 'participant'));
    }

    function detailAbsensi($id)
    {
        // mengambil daftar pertemuan
        $rincian_pertemuan = DB::table('pertemuans')
            ->where('.id_seksi', $id)
            ->get();

        // deteksi matakuliah single
        $data_seksi = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->where('id', $id)
            ->get();

        // Nilai awal variabel warna yang dihitung
        $color_hitung = 0;

        // Array warna template menu pilihan pertemuan 1-16
        $color = [
            'bg-aqua',
            'bg-yellow',
            'bg-red',
            'bg-green',
            'bg-maroon',
            'bg-teal',
            'bg-purple',
            'bg-orange',
            'bg-green',
            'bg-blue',
            'bg-red',
            'bg-aqua',
            'bg-purple',
            'bg-yellow',
            'bg-maroon',
            'bg-teal',
        ];

        // melihat peserta yang berada di tabel participant yang sudah diverifikasi
        $participant = DB::table('participants')
            ->join('seksis', 'seksis.id', '=', 'participants.id_seksi')
            ->join('users', 'users.id', '=', 'participants.user_id')
            ->where('id_seksi', $id)
            ->where('participants.keterangan', '=', '1')
            ->orderBy('nama', 'asc')
            ->get();

        // melihat peserta yang berada di table participants
        $peserta = DB::table('participants')
            ->where('id_seksi', '=', $id)
            ->get();

        // untuk memilih seksi
        $pilih_seksi = DB::table('seksis')
            ->where('id', $id)
            ->get();

        // menghitung jumlah pertemuan yang telah dibuat
        $hitung_pertemuan = DB::table('pertemuans')
            ->where('id_seksi', $id)
            ->count();

        // membuat angka 0 sebagai permulaan awal looping (return deteksi pertemuan)
        $return_deteksi_pertemuan = 0;

        // mendeteksi beberapa pertemuan di dalam id_seksi yang sama
        $deteksi_pertemuan = DB::table('absensis')
            ->where('id_seksi', $id)
            ->groupBy('id_pertemuan')
            ->pluck('id_pertemuan');

        // melakukan perulangan untuk deteksi peserta yang hadir di id_seksi yang sama namun id_pertemuan yang berbeda berdasarkan middleware user yang login
        $get_keterangan = [];
        for ($i = 0; $i < count($deteksi_pertemuan); $i++) {
            $get_keterangan[] = DB::table('absensis')
                ->where('absensis.id_seksi', $id)
                ->where('absensis.id_pertemuan', '=', $deteksi_pertemuan[$i])
                // 1 akan diganti dengan Middleware User Mahasiswa yang login
                ->where('absensis.id_user', '1')
                ->value('keterangan');
        }

        // parsing data ke blade.php
        return view('mahasiswa.absensi.absensi_detail', compact(
            'color',
            'color_hitung',
            'participant',
            'pilih_seksi',
            'peserta',
            'rincian_pertemuan',
            'hitung_pertemuan',
            'deteksi_pertemuan',
            'return_deteksi_pertemuan',
            'get_keterangan',
            'data_seksi',
        ));
    }

    function detailPertemuan($id_seksi, $id_pertemuan)
    {
        // Membaca/mengambil value id_seksi dan id_pertemuan dari route link website
        $seksi = Absensi::find($id_seksi);
        $pertemuan = Absensi::find($id_pertemuan);

        // link kembali ke halaman sebelumnya
        $previous = "/absensi_mahasiswa/detail/$id_seksi";

        // mengambil tanggal pertemuan
        $tanggal_pertemuan = DB::table('pertemuans')
            ->where('id_pertemuan', $id_pertemuan)
            ->value('tanggal');

        // Mengambil value qrcode dari database pada tabel absensis
        $qr_absensi = 'QR Code ini hanya contoh, mintalah QR Code yang valid kepada dosen matakuliah terkait';

        // Generate QR-Code ekstensi PNG berdasarkan data $qr_absensi
        $qrcode = QrCode::format('png')
            ->merge('qrcode_logo/launcher.png', 0.2, true)
            ->size(220)
            ->color(0, 0, 0)
            ->eyeColor(0, 96, 92, 168, 0, 0, 0)
            ->backgroundColor(255, 255, 255)
            ->generate($qr_absensi);

        // variabel qr_image digunakan sebagai penampung value dari route link $id_seksi dan $id_pertemuan
        $qr_image = DB::table('pertemuans')
            ->join('seksis', 'pertemuans.id_seksi', '=', 'seksis.id')
            ->where('pertemuans.id_seksi', $id_seksi)
            ->where('pertemuans.id_pertemuan', $id_pertemuan)
            ->get();

        // Fetch data dari tabel absensi di mana data akan disaring dengan where sesuai $id_seksi dan $id_pertemuan
        $absensis = DB::table('absensis')
            ->join('pertemuans', 'absensis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
            ->join('seksis', 'absensis.id_seksi', '=', 'seksis.id')
            ->join('users', 'absensis.id_user', '=', 'users.id')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            // 1 akan diganti dengan Middleware User Mahasiswa yang login
            ->where('id_user', '1')
            ->get();

        // mendapatkan kode_seksi dari database
        $kode_seksi = DB::table('seksis')
            ->where('seksis.id', $id_seksi)
            ->value('kode_seksi');

        // mendapatkan kode_seksi dari database
        $deteksi_matakuliah = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->where('seksis.id', $id_seksi)
            ->value('nama_mk');

        // parsing data ke view
        return view('mahasiswa.absensi.absensi_pertemuan', compact(
            'seksi',
            'kode_seksi',
            'absensis',
            'pertemuan',
            'qrcode',
            'qr_absensi',
            'qr_image',
            'deteksi_matakuliah',
            'tanggal_pertemuan',
            'previous',
        ));
    }
    
    function printPertemuan($id_seksi, $id_pertemuan)
    {
        $seksi = Absensi::find($id_seksi);
        $pertemuan = Absensi::find($id_pertemuan);

        $previous = "/absensi_mahasiswa/detail/$id_seksi";

        // mengambil tanggal pertemuan
        $tanggal_pertemuan = DB::table('pertemuans')
            ->where('id_pertemuan', $id_pertemuan)
            ->value('tanggal');

        // get materi pertemuan
        $materi_pertemuan = DB::table('pertemuans')
            ->where('id_pertemuan', $id_pertemuan)
            ->value('materi');

        // Melihat matakuliah pada sesi halaman
        $matakuliah = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->where('seksis.id', $id_seksi)
            ->value('nama_mk');

        // get prodi dari database
        $prodi = DB::table('seksis')
            ->join('jurusans', 'seksis.kode_jurusan', '=', 'jurusans.kode_jurusan')
            ->where('seksis.id', $id_seksi)
            ->value('nama_jurusan');

        // get sks from database
        $sks = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->where('seksis.id', $id_seksi)
            ->value('sks');

        // get nama dosen from database
        $dosen = DB::table('seksis')
            ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
            ->where('seksis.id', $id_seksi)
            ->value('nama_dosen');

        // get nip dosen from database table seksis
        $nip_dosen = DB::table('seksis')
            ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
            ->where('seksis.id', $id_seksi)
            ->value('nip_dosen');

        // Fetch data dari tabel absensi di mana data akan disaring dengan where sesuai $id_seksi dan $id_pertemuan
        $absensis = DB::table('absensis')
            ->join('pertemuans', 'absensis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
            ->join('seksis', 'absensis.id_seksi', '=', 'seksis.id')
            ->join('users', 'absensis.id_user', '=', 'users.id')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->where('verifikasi', '=', '1')
            ->orderBy('nama', 'ASC')
            ->get();

        // mendapatkan kode_seksi dari database
        $kode_seksi = DB::table('seksis')
            ->where('seksis.id', $id_seksi)
            ->value('kode_seksi');

        // variabel penghitung peserta yang hadir
        $hitung_absensi_hadir = DB::table('absensis')
            ->where('keterangan', 'hadir')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->where('verifikasi', '=', '1')
            ->count();

        // variabel penghitung peserta yang izin
        $hitung_absensi_izin = DB::table('absensis')
            ->where('keterangan', 'izin')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->where('verifikasi', '=', '1')
            ->count();

        // variabel penghitung peserta yang alfa
        $hitung_absensi_alfa = DB::table('absensis')
            ->where('keterangan', null)
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->where('verifikasi', '=', '1')
            ->count();

        // Variabel penghitung semua peserta
        $hitung_semua_peserta = DB::table('absensis')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->where('verifikasi', '=', '1')
            ->count();

        // Mengambil value qrcode dari database pada tabel absensis
        $qr_absensi = DB::table('absensis')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->value('qrcode');

        // Generate QR-Code ekstensi PNG berdasarkan data $qr_absensi
        $qrcode = QrCode::format('png')
            ->size(50)
            ->color(0, 0, 0)
            ->eyeColor(0, 0, 0, 0, 0, 0, 0)
            ->backgroundColor(255, 255, 255)
            ->generate($qr_absensi);

        // parsing data
        return view('mahasiswa.print.print_absensi_pertemuan', compact(
            'absensis',
            'prodi',
            'sks',
            'dosen',
            'nip_dosen',
            'tanggal_pertemuan',
            'materi_pertemuan',
            'matakuliah',
            'kode_seksi',
            'qrcode',
            'hitung_absensi_hadir',
            'hitung_absensi_izin',
            'hitung_absensi_alfa',
            'hitung_semua_peserta',
        ));
    }

    function printPerSemester($id_seksi)
    {
        $seksi = Absensi::find($id_seksi);

        // Mengambil kode seksi dari database
        $get_kode_seksi = DB::table('seksis')
            ->where('seksis.id', $id_seksi)
            ->value('kode_seksi');

        // Memotong data kode seksi khusus untuk kode tahun
        $get_tahun = Str::substr($get_kode_seksi, 0, 4);

        // memotong data kode seksi khusus untuk kode semester
        $get_semester = Str::substr($get_kode_seksi, 4, 1);

        // merubah semester 1 atau 2 menjadi semester jan-jun atau jul-des
        if ($get_semester == '1') {
            $keterangan_semester = "JANUARI-JUNI";
            $nama_semester = "GENAP";
        } else {
            $keterangan_semester = "JULI-DESEMBER";
            $nama_semester = "GANJIL";
        }

        // get prodi dari database
        $prodi = DB::table('seksis')
            ->join('jurusans', 'seksis.kode_jurusan', '=', 'jurusans.kode_jurusan')
            ->where('seksis.id', $id_seksi)
            ->value('nama_jurusan');

        // get nama matakuliah from database table seksis
        $matakuliah = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->where('seksis.id', $id_seksi)
            ->value('nama_mk');

        // get nama dosen from database
        $dosen = DB::table('seksis')
            ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
            ->where('seksis.id', $id_seksi)
            ->value('nama_dosen');

        // table absensis join pertemuans join seksis join users
        $absensis = DB::table('absensis')
            ->join('pertemuans', 'absensis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
            ->join('seksis', 'absensis.id_seksi', '=', 'seksis.id')
            ->join('users', 'absensis.id_user', '=', 'users.id')
            ->where('absensis.id_seksi', $id_seksi)
            ->orderBy('nama', 'ASC')
            ->get();

        // menghitung jumlah pertemuan yang telah dibuat
        $hitung_pertemuan = DB::table('pertemuans')
            ->where('id_seksi', $id_seksi)
            ->count();

        // mmenghitung pertemuan yang belum dibuat
        $jmlh_pertemuan_saat_ini = 16 - $hitung_pertemuan;

        // table participant
        $participant = DB::table('participants')
            ->join('users', 'participants.user_id', '=', 'users.id')
            ->where('id_seksi', $id_seksi)
            ->orderBy('nama', 'ASC')
            ->get();

        // table participant
        $peserta = DB::table('participants')
            ->join('users', 'participants.user_id', '=', 'users.id')
            ->where('id_seksi', $id_seksi)
            ->orderBy('nama', 'ASC')
            ->pluck('username');

        // table participant
        $nama_peserta = DB::table('participants')
            ->join('users', 'participants.user_id', '=', 'users.id')
            ->where('id_seksi', $id_seksi)
            ->orderBy('nama', 'ASC')
            ->pluck('nama');

        // table participant
        $jk = DB::table('participants')
            ->join('users', 'participants.user_id', '=', 'users.id')
            ->where('id_seksi', $id_seksi)
            ->orderBy('nama', 'ASC')
            ->pluck('jk');

        // where table participant
        $where_participant = DB::table('participants')
            ->join('users', 'participants.user_id', '=', 'users.id')
            ->where('id_seksi', $id_seksi)
            ->orderBy('nama', 'ASC')
            ->pluck('user_id');


        // mengambil absensi tiap pertemuan
        for ($i = 0; $i < count($where_participant); $i++) {
            $get_ket_absensi[] = DB::table('absensis')
                ->join('pertemuans', 'absensis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                ->join('seksis', 'absensis.id_seksi', '=', 'seksis.id')
                ->join('users', 'absensis.id_user', '=', 'users.id')
                ->where('absensis.id_seksi', $id_seksi)
                ->where('absensis.id_user', '=', $where_participant[$i])
                ->pluck('keterangan');
        }

        // menghitung absensi hadir dari semua pertemuan
        for ($i = 0; $i < count($where_participant); $i++) {
            $get_ket_hadir[] = DB::table('absensis')
                ->join('pertemuans', 'absensis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                ->join('seksis', 'absensis.id_seksi', '=', 'seksis.id')
                ->join('users', 'absensis.id_user', '=', 'users.id')
                ->where('absensis.id_seksi', $id_seksi)
                ->where('absensis.id_user', '=', $where_participant[$i])
                ->where('keterangan', '=', 'hadir')
                ->count();
        }

        // menghitung absensi izin dari semua pertemuan
        for ($i = 0; $i < count($where_participant); $i++) {
            $get_ket_izin[] = DB::table('absensis')
                ->join('pertemuans', 'absensis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                ->join('seksis', 'absensis.id_seksi', '=', 'seksis.id')
                ->join('users', 'absensis.id_user', '=', 'users.id')
                ->where('absensis.id_seksi', $id_seksi)
                ->where('absensis.id_user', '=', $where_participant[$i])
                ->where('keterangan', '=', 'izin')
                ->count();
        }

        // menghitung absensi alfa dari semua pertemuan
        for ($i = 0; $i < count($where_participant); $i++) {
            $get_ket_alfa[] = DB::table('absensis')
                ->join('pertemuans', 'absensis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
                ->join('seksis', 'absensis.id_seksi', '=', 'seksis.id')
                ->join('users', 'absensis.id_user', '=', 'users.id')
                ->where('absensis.id_seksi', $id_seksi)
                ->where('absensis.id_user', '=', $where_participant[$i])
                ->where('keterangan', null)
                ->count();
        }

        return view('mahasiswa.print.print_absensi_persemester', compact(
            'absensis',
            'matakuliah',
            'get_kode_seksi',
            'get_tahun',
            'keterangan_semester',
            'nama_semester',
            'prodi',
            'dosen',
            'participant',
            'get_ket_absensi',
            'get_ket_hadir',
            'get_ket_izin',
            'get_ket_alfa',
            'peserta',
            'nama_peserta',
            'jk',
            'jmlh_pertemuan_saat_ini'
        ));
    }
}
