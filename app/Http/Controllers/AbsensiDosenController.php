<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Seksi;
use App\Models\Pertemuan;
use App\Models\Absensi;
use Hamcrest\Core\HasToString;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class AbsensiDosenController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {

        $cek_seksi = Seksi::all()->where('status', '1')
            ->where('kode_dosen', Auth::user()->username )
            ->count();

        $seksi = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->join('dosens', 'seksis.kode_dosen', '=', 'dosens.kode_dosen')
            ->where('seksis.status', '1')
            ->where('seksis.kode_dosen', Auth::user()->username )
            ->get();

        $participant = DB::table('participants')
            ->join('seksis', 'seksis.id', '=', 'participants.id_seksi')
            ->join('users', 'users.id', '=', 'participants.user_id')
            ->get();

        return view('dosen.absensi.absensi', compact('seksi', 'cek_seksi', 'participant'));
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

        $mahasiswa = DB::table('mahasiswas')
            ->whereNotIn('user_id', DB::table('participants')->select('user_id')->where('id_seksi', '=', $id))
            ->orderBy('nama_mahasiswa', 'asc')
            ->get();

        return view('dosen.absensi.absensi_lihat_peserta', compact('seksi', 'participant', 'seksi', 'mahasiswa'));
    }

    function detailAbsensi($id)
    {
        // mengambil daftar pertemuan
        $rincian_pertemuan = DB::table('pertemuans')
            ->where('.id_seksi', $id)
            ->get();

        // cek partisipant
        $deteksi_participant = DB::table('participants')
            ->where('id_seksi', $id)
            ->count();

        // link tambah peserta
        $link_tambah_peserta = "/absensi_dosen/lihat_peserta/$id";

        // melihat matakuliah di seksi $id
        $nama_matakuliah = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->where('id', $id)
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

        // membuat random qrcode 6 digit
        $qrcode_text = Str::random(6);

        // generate qrcode format png dengan logo dan set ukuran
        $qrcode = QrCode::format('png')
            ->merge('qrcode_logo/launcher.png', 0.2, true)
            ->size(175)
            ->color(0, 0, 0)
            ->eyeColor(0, 96, 92, 168, 0, 0, 0)
            ->backgroundColor(255, 255, 255)
            ->generate($qrcode_text);

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

        // menghitung jumlah peserta yang sudah diverifikasi
        $hitung_peserta = DB::table('participants')
            ->where('id_seksi', '=', $id)
            ->where('keterangan', '=', '1')
            ->count();

        // kode_seksi disamakan dengan id_seksi
        $kode_seksi = $id;

        // untuk memilih seksi
        $pilih_seksi = DB::table('seksis')
            ->where('id', $id)
            ->get();

        // menghitung jumlah pertemuan yang telah dibuat
        $hitung_pertemuan = DB::table('pertemuans')
            ->where('id_seksi', $id)
            ->count();

        // melihat detail peserta
        $detail_peserta = DB::table('participants')
            ->where('id_seksi', $id)
            ->where('keterangan', '=', '1')
            ->get();

        // membuat angka 0 sebagai permulaan awal looping (return deteksi pertemuan)
        $return_deteksi_pertemuan = 0;

        // mendeteksi beberapa pertemuan di dalam id_seksi yang sama
        $deteksi_pertemuan = DB::table('absensis')
            ->where('id_seksi', $id)
            ->groupBy('id_pertemuan')
            ->pluck('id_pertemuan');

        // melakukan perulangan untuk kalkulasi peserta yang hadir di id_seksi yang sama namun id_pertemuan yang berbeda
        $hitung_absensi_hadir = [];
        for ($i = 0; $i < count($deteksi_pertemuan); $i++) {
            $hitung_absensi_hadir[] = DB::table('absensis')
                ->where('keterangan', 'hadir')
                ->where('absensis.id_seksi', $id)
                ->where('absensis.id_pertemuan', '=', $deteksi_pertemuan[$i])
                ->count();
        }

        // melakukan perulangan untuk kalkulasi peserta yang izin di id_seksi yang sama namun id_pertemuan yang berbeda
        $hitung_absensi_izin = [];
        for ($i = 0; $i < count($deteksi_pertemuan); $i++) {
            $hitung_absensi_izin[] = DB::table('absensis')
                ->where('keterangan', 'izin')
                ->where('absensis.id_seksi', $id)
                ->where('absensis.id_pertemuan', '=', $deteksi_pertemuan[$i])
                ->count();
        }

        // melakukan perulangan untuk kalkulasi peserta yang alfa di id_seksi yang sama namun id_pertemuan yang berbeda
        $hitung_absensi_alfa = [];
        for ($i = 0; $i < count($deteksi_pertemuan); $i++) {
            $hitung_absensi_alfa[] = DB::table('absensis')
                ->where('keterangan', null)
                ->where('absensis.id_seksi', $id)
                ->where('absensis.id_pertemuan', '=', $deteksi_pertemuan[$i])
                ->count();
        }

        // melakukan perulangan untuk kalkulasi peserta yang total di id_seksi yang sama namun id_pertemuan yang berbeda
        $hitung_absensi_total = [];
        for ($i = 0; $i < count($deteksi_pertemuan); $i++) {
            $hitung_absensi_total[] = DB::table('absensis')
                ->where('absensis.id_seksi', $id)
                ->where('absensis.id_pertemuan', '=', $deteksi_pertemuan[$i])
                ->count();
        }

        // parsing data ke blade.php
        return view('dosen.absensi.absensi_detail', compact(
            'deteksi_participant',
            'link_tambah_peserta',
            'color',
            'color_hitung',
            'kode_seksi',
            'participant',
            'hitung_peserta',
            'pilih_seksi',
            'qrcode_text',
            'qrcode',
            'peserta',
            'detail_peserta',
            'rincian_pertemuan',
            'hitung_pertemuan',
            'deteksi_pertemuan',
            'return_deteksi_pertemuan',
            'hitung_absensi_hadir',
            'hitung_absensi_izin',
            'hitung_absensi_alfa',
            'hitung_absensi_total',
            'nama_matakuliah',
            'data_seksi',
        ));
    }

    function insertPertemuanAbsensi(Request $request)
    {
        // Jika ada data yang tidak terisi maka lakukan hal di bawah ini
        $validator = Validator::make(
            $request->all(),
            [
                'kode_seksi' => 'required',
                'tanggal_picker' => 'required',
            ],
            [
                'kode_seksi.required' => 'Wajib diisi.',
                'tanggal_picker.required' => 'Wajib diisi.',
            ]
        );

        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Pertemuan gagal dibuat!');
        }

        // Auth::user()->sent()->create([
        //     'tel'       => $request->tel,
        //     'email'    => $request->email,
        //     'start' => date("Y-m-d", strtotime($request->datepicker)),
        //     'end'       => date("Y-m-d", strtotime($request->datepicker1)),
        //     'supervisor'    => $request->supervisor,
        //     'department' => $request->department,
        //     'name'    => $request->name,
        //     'adress' => $request->adress,
        // ]);   
        // return view('home');

        // insert ke tabel Pertemuans
        $pertemuan = new Pertemuan;
        $pertemuan->id_seksi = $request->kode_seksi;

        $pertemuan->tanggal = date("Y-m-d", strtotime($request->tanggal_picker));

        $pertemuan->materi = $request->materi;
        $pertemuan->save();

        // mendapatkan tanggal inputan yang dimasukkan admin untuk dijadikan nama qr_code
        $date_day = date("Ymd", strtotime($request->tanggal_picker));

        // mendapatkan id_pertemuan terakhir dan menambahkannya dengan 1. Fungsinya untuk menamai image qr_code
        $max_id_pertemuan = DB::table('pertemuans')->max('id_pertemuan');
        // $add_id_pertemuan = $max_id_pertemuan + 1;
        $equal_id_pertemuan = sprintf("%06s", $max_id_pertemuan);

        // mendapatkan kode_seksi dari kode_seksi pada database
        $kode_seksi = $request->nama_seksi;

        // insert ke tabel Absensis
        $jumlah_peserta = $request->jumlah_peserta;
        $id_pertemuan = $pertemuan->id_pertemuan;
        $id_user = $request->detail_peserta;
        $imei_absensi = $request->imei_peserta;
        $id_seksi = $request->kode_seksi;
        $qrcode = $request->qrcode_text;

        $data = [];

        for ($i = 0; $i < $jumlah_peserta; $i++) {
            $data[] = [
                'id_pertemuan' => $id_pertemuan,
                'id_seksi' => $id_seksi,
                'id_user' => $id_user[$i],
                'imei_absensi' =>  $imei_absensi[$i],
                'qrcode' => $qrcode,
                'qrcode_image' => $kode_seksi . '-' . $equal_id_pertemuan . '-' . $date_day . '.png',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ];
        }

        DB::table('absensis')->insert($data);

        // insert qr code image ke folder public
        $image = $request->base64image;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = $kode_seksi . '-' . $equal_id_pertemuan . '-' . $date_day . '.png';

        File::put(storage_path('/app/public/qrcodes') . '/' . $imageName, base64_decode($image));

        return redirect()->back()->with('pesan-sukses', 'Pertemuan berhasil dibuat.');
    }

    function detailPertemuan($id_seksi, $id_pertemuan)
    {
        // Membaca/mengambil value id_seksi dan id_pertemuan dari route link website
        $seksi = Absensi::find($id_seksi);
        $pertemuan = Absensi::find($id_pertemuan);

        $previous = "/absensi_dosen/detail/$id_seksi";

        // mengambil tanggal pertemuan
        $tanggal_pertemuan = DB::table('pertemuans')
            ->where('id_pertemuan', $id_pertemuan)
            ->value('tanggal');

        $materi_pertemuan = DB::table('pertemuans')
            ->where('id_pertemuan', $id_pertemuan)
            ->value('materi');

        // Mengambil value qrcode dari database pada tabel absensis
        $qr_absensi = DB::table('absensis')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->value('qrcode');

        // Generate QR-Code ekstensi PNG berdasarkan data $qr_absensi
        $qrcode = QrCode::format('png')
            ->merge('qrcode_logo/launcher.png', 0.2, true)
            ->size(175)
            ->color(0, 0, 0)
            ->eyeColor(0, 96, 92, 168, 0, 0, 0)
            ->backgroundColor(255, 255, 255)
            ->generate($qr_absensi);

        // membuat data QR-Code text baru dengan 6 karakter baru yang acak
        $qrcode_text_baru = Str::random(6);

        // generate QR-Code baru berdasarkan data 6 karakter acak pada variabel $qrcode_text_baru
        $qrcode_baru = QrCode::format('png')
            ->merge('qrcode_logo/launcher.png', 0.2, true)
            ->size(175)
            ->color(0, 0, 0)
            ->eyeColor(0, 96, 92, 168, 0, 0, 0)
            ->backgroundColor(255, 255, 255)
            ->generate($qrcode_text_baru);

        // variabel qr_image digunakan sebagai penampung value dari route link $id_seksi dan $id_pertemuan
        $qr_image = DB::table('pertemuans')
            ->join('seksis', 'pertemuans.id_seksi', '=', 'seksis.id')
            ->where('pertemuans.id_seksi', $id_seksi)
            ->where('pertemuans.id_pertemuan', $id_pertemuan)
            ->get();

        // Melihat matakuliah pada sesi halaman
        $matakuliah = DB::table('seksis')
            ->join('matakuliahs', 'seksis.kode_mk', '=', 'matakuliahs.kode_mk')
            ->where('seksis.id', $id_seksi)
            ->get();

        // Fetch data dari tabel absensi di mana data akan disaring dengan where sesuai $id_seksi dan $id_pertemuan
        $absensis = DB::table('absensis')
            ->join('pertemuans', 'absensis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
            ->join('seksis', 'absensis.id_seksi', '=', 'seksis.id')
            ->join('users', 'absensis.id_user', '=', 'users.id')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
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
            ->count();

        // variabel penghitung peserta yang izin
        $hitung_absensi_izin = DB::table('absensis')
            ->where('keterangan', 'izin')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->count();

        // variabel penghitung peserta yang alfa
        $hitung_absensi_alfa = DB::table('absensis')
            ->where('keterangan', null)
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->count();

        // Variabel penghitung semua peserta
        $hitung_semua_peserta = DB::table('absensis')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->count();

        $persentasi_hadir = round(($hitung_absensi_hadir / $hitung_semua_peserta) * 100, 0);

        $persentasi_izin = round(($hitung_absensi_izin / $hitung_semua_peserta) * 100, 0);

        $persentasi_alfa = round(($hitung_absensi_alfa / $hitung_semua_peserta) * 100, 0);

        $persentasi_total = round((($hitung_absensi_hadir + $hitung_absensi_izin) / $hitung_semua_peserta) * 100, 0);

        // parsing data ke view
        return view('dosen.absensi.absensi_pertemuan', compact(
            'seksi',
            'kode_seksi',
            'absensis',
            'pertemuan',
            'hitung_absensi_hadir',
            'hitung_absensi_izin',
            'hitung_absensi_alfa',
            'qrcode',
            'qr_absensi',
            'qr_image',
            'qrcode_text_baru',
            'qrcode_baru',
            'matakuliah',
            'tanggal_pertemuan',
            'previous',
            'persentasi_hadir',
            'persentasi_izin',
            'persentasi_alfa',
            'persentasi_total'
        ));
    }

    function verifikasiAbsensi($id_absensi)
    {
        $absensi = Absensi::find($id_absensi);
        $absensi->verifikasi = '1';
        $absensi->update();

        return redirect()->back()->with('pesan-sukses', 'Data Absensi berhasil diverifikasi.');
    }

    function catatanAbsensi(Request $request, $id_absensi)
    {
        $absensi = Absensi::find($id_absensi);

        $req_cat_absensi = $request->catatan_absensi;

        if ($req_cat_absensi == null) {
            $absensi->keterangan = $request->radio_hadir;
            $absensi->save();
            return redirect()->back()->with('pesan-sukses', 'Catatan Absensi berhasil dibuat.');
        } else {
            $absensi->keterangan = $request->radio_hadir;
            $absensi->catatan = $request->catatan_absensi;
            $absensi->save();
            return redirect()->back()->with('pesan-sukses', 'Catatan Absensi berhasil dibuat.');
        }
    }

    function resetAbsensi($id_absensi)
    { 
        $keterangan_null = null;
        $catatan_null = null;
        $verifikasi_null = null;

        $absensi = Absensi::find($id_absensi);
        $absensi->keterangan = $keterangan_null;
        $absensi->catatan = $catatan_null;
        $absensi->verifikasi = $verifikasi_null;
        $absensi->save();

        return redirect()->back()->with('pesan-sukses', 'Data absensi berhasil direset.');
    }

    function downloadQRCode($id_seksi, $id_pertemuan)
    {
        $file_name = DB::table('absensis')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->value('qrcode_image');

        $file = Storage::disk('qrcodes')->get($file_name);

        return (new Response($file, 200))
            ->header('Content-Type', 'image/png');
    }

    function recoveryQRCode(Request $request, $id_seksi, $id_pertemuan)
    {
        $updated_at = date('Y-m-d H:i:s');

        $kode_seksi = $request->nama_seksi;

        $equal_id_pertemuan = sprintf("%06s", $id_pertemuan);

        $date_day = date("Ymd", strtotime($request->tanggal));

        DB::table('absensis')
            ->where('id_seksi', $id_seksi)
            ->where('id_pertemuan', $id_pertemuan)
            ->update(
                ['qrcode' => $request->qrcode_text_baru],
                ['updated_at' => $updated_at]
            );

        $image = $request->base64image;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = $kode_seksi . '-' . $equal_id_pertemuan . '-' . $date_day . '.png';

        File::put(storage_path('/app/public/qrcodes') . '/' . $imageName, base64_decode($image));

        return redirect()->back()->with('pesan-sukses', 'QR-Code berhasil diperbaharui.');
    }

    function editPertemuan(Request $request, $id_seksi, $id_pertemuan)
    {
        $pertemuan = Pertemuan::find($id_pertemuan);

        $validator = Validator::make(
            $request->all(),
            [
                'tanggal_picker' => 'required',
            ],
            [
                'tanggal_picker.required' => 'Wajib diisi.',
            ]
        );

        $updated_at = date('Y-m-d H:i:s');

        // mendapatkan kode_seksi dari database
        $kode_seksi = DB::table('seksis')
            ->where('seksis.id', $id_seksi)
            ->value('kode_seksi');

        $equal_id_pertemuan = sprintf("%06s", $id_pertemuan);

        $date_day = date("Ymd", strtotime($request->tanggal_picker));

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('pesan-gagal', 'Data Absensi pada pertemuan ini gagal diperbaharui!');
        }

        // membaca qrcode lama lalu menghapus file qrcode lama
        $nama_qrcode_lama = DB::table('absensis')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->value('qrcode_image');

        unlink(storage_path('app/public/qrcodes/' . $nama_qrcode_lama));

        // Update ke table pertemuan
        $pertemuan->tanggal = date("Y-m-d", strtotime($request->tanggal_picker));
        $pertemuan->materi = $request->materi;
        $pertemuan->updated_at = $updated_at;
        $pertemuan->save();

        // Update ke table absensi
        DB::table('absensis')
            ->where('id_seksi', $id_seksi)
            ->where('id_pertemuan', $id_pertemuan)
            ->update(
                ['qrcode_image' => $kode_seksi . '-' . $equal_id_pertemuan . '-' . $date_day . '.png']
            );

        $image = $request->base64image;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = $kode_seksi . '-' . $equal_id_pertemuan . '-' . $date_day . '.png';

        File::put(storage_path('/app/public/qrcodes') . '/' . $imageName, base64_decode($image));

        return redirect()->back()->with('pesan-sukses', 'Data Absensi pada pertemuan ini berhasil diubah.');
    }

    function deletePertemuan($id_seksi, $id_pertemuan)
    {
        // $pertemuan = Pertemuan::find($id_pertemuan);

        $pertemuan = DB::table('pertemuans')
            ->where('id_pertemuan', $id_pertemuan);

        $absensi = DB::table('absensis')
            ->where('id_pertemuan', $id_pertemuan)
            ->where('id_seksi', $id_seksi);

        $previous = "/absensi_dosen/detail/$id_seksi";

        // membaca qrcode lama lalu menghapus file qrcode lama
        $nama_qrcode_lama = DB::table('absensis')
            ->where('absensis.id_seksi', $id_seksi)
            ->where('absensis.id_pertemuan', $id_pertemuan)
            ->value('qrcode_image');

        if ($pertemuan != null && $absensi != null) {

            // membaca qrcode lama lalu menghapus file qrcode lama
            $nama_qrcode_lama = DB::table('absensis')
                ->where('absensis.id_seksi', $id_seksi)
                ->where('absensis.id_pertemuan', $id_pertemuan)
                ->value('qrcode_image');

            unlink(storage_path('app/public/qrcodes/' . $nama_qrcode_lama));

            $pertemuan->delete();
            $absensi->delete();

            return redirect($previous)->with(['pesan-sukses' => 'Pertemuan berhasil dihapus.']);
        }

        return redirect($previous)->with(['pesan-gagal' => 'Pertemuan gagal dihapus.']);
    }

    function printPertemuan($id_seksi, $id_pertemuan)
    {
        $seksi = Absensi::find($id_seksi);
        $pertemuan = Absensi::find($id_pertemuan);

        $previous = "/absensi_dosen/detail/$id_seksi";

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
        return view('dosen.print.print_absensi_pertemuan', compact(
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

        return view('dosen.print.print_absensi_persemester', compact(
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
