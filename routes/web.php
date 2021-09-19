<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\GrupController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\SeksiController;
use App\Http\Controllers\SeksiDosenController;
use App\Http\Controllers\AbsensiDosenController;
use App\Http\Controllers\AbsensiMahasiswaController;
use App\Http\Controllers\CariKelasController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// For Admin

// Home
Route::get('/', [DashboardController::class, 'index']);
// Route::get('/dashboard_admin', [DashboardController::class, 'indexAdmin'])->name('dashboard_admin');

// User
Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/user/nonaktif', [UserController::class, 'indexNonaktif'])->name('user_nonaktif');
Route::post('/user/add/insert_user_admin', [UserController::class, 'insertUserAdmin']);
Route::post('/user/add/insert_user_dosen', [UserController::class, 'insertUserDosen']);
Route::post('/user/add/insert_user_mahasiswa', [UserController::class, 'insertUserMahasiswa']);
Route::post('/user/change_password/{id}', [UserController::class, 'changePassword']);
Route::post('/user/update/{id}', [UserController::class, 'update']);
Route::get('/user/nonaktif/{id}', [UserController::class, 'nonaktif']);
Route::get('/user/aktif/{id}', [UserController::class, 'aktif']);

// Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/admin/nonaktif', [AdminController::class, 'indexNonaktif'])->name('admin_nonaktif');
Route::post('/admin/add/insert', [AdminController::class, 'insert']);
Route::post('/admin/update/{id}', [AdminController::class, 'update']);
Route::get('/admin/nonaktif/{id}', [AdminController::class, 'nonaktif']);
Route::get('/admin/aktif/{id}', [AdminController::class, 'aktif']);

// Dosen
Route::get('/dosen', [DosenController::class, 'index'])->name('dosen');
Route::get('/dosen/nonaktif', [DosenController::class, 'indexNonaktif'])->name('dosen_nonaktif');
Route::post('/dosen/add/insert', [DosenController::class, 'insert']);
Route::post('/dosen/update/{id}', [DosenController::class, 'update']);
Route::get('/dosen/nonaktif/{id}', [DosenController::class, 'nonaktif']);
Route::get('/dosen/aktif/{id}', [DosenController::class, 'aktif']);

// Mahasiswa
Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa');
Route::get('/mahasiswa/nonaktif', [MahasiswaController::class, 'indexNonaktif'])->name('mahasiswa_nonaktif');
Route::post('/mahasiswa/add/insert', [MahasiswaController::class, 'insert']);
Route::post('/mahasiswa/update/{id}', [MahasiswaController::class, 'update']);
Route::get('/mahasiswa/nonaktif/{id}', [MahasiswaController::class, 'nonaktif']);
Route::get('/mahasiswa/aktif/{id}', [MahasiswaController::class, 'aktif']);
Route::get('/mahasiswa/reset_imei/{id}', [MahasiswaController::class, 'resetIMEI']);

// Matakuliah
Route::get('/matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah');
Route::get('/matakuliah/nonaktif', [MatakuliahController::class, 'indexNonaktif'])->name('matakuliah_nonaktif');
Route::post('/matakuliah/add/insert', [MatakuliahController::class, 'insert']);
Route::post('/matakuliah/update/{kode_mk}', [MatakuliahController::class, 'update']);
Route::get('/matakuliah/nonaktif/{kode_mk}', [MatakuliahController::class, 'nonaktif']);
Route::get('/matakuliah/aktif/{kode_mk}', [MatakuliahController::class, 'aktif']);

// Jurusan
Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan');
Route::get('/jurusan/nonaktif', [JurusanController::class, 'indexNonaktif'])->name('jurusan_nonaktif');
Route::post('/jurusan/add/insert', [JurusanController::class, 'insert']);
Route::post('/jurusan/update/{kode_jurusan}', [JurusanController::class, 'update']);
Route::get('/jurusan/nonaktif/{kode_jurusan}', [JurusanController::class, 'nonaktif']);
Route::get('/jurusan/aktif/{kode_jurusan}', [JurusanController::class, 'aktif']);

// Grup
Route::get('/grup', [GrupController::class, 'index'])->name('grup');
Route::get('/grup/nonaktif', [GrupController::class, 'indexNonaktif'])->name('grup_nonaktif');
Route::post('/grup/add/insert', [GrupController::class, 'insert']);
Route::post('/grup/update/{kode_grup}', [GrupController::class, 'update']);
Route::get('/grup/nonaktif/{kode_grup}', [GrupController::class, 'nonaktif']);
Route::get('/grup/aktif/{kode_grup}', [GrupController::class, 'aktif']);

// Ruangan
Route::get('/ruang', [RuangController::class, 'index'])->name('ruang');
Route::get('/ruang/nonaktif', [RuangController::class, 'indexNonaktif'])->name('ruang_nonaktif');
Route::post('/ruang/add/insert', [RuangController::class, 'insert']);
Route::post('/ruang/update/{kode_ruang}', [RuangController::class, 'update']);
Route::get('/ruang/nonaktif/{kode_ruang}', [RuangController::class, 'nonaktif']);
Route::get('/ruang/aktif/{kode_ruang}', [RuangController::class, 'aktif']);

// Seksi
Route::get('/seksi', [SeksiController::class, 'index'])->name('seksi');
Route::get('/seksi/nonaktif', [SeksiController::class, 'indexNonaktif'])->name('seksi_nonaktif');
Route::post('/seksi/add/insert_ptik', [SeksiController::class, 'insertPTIK']);
Route::post('/seksi/add/insert_pte', [SeksiController::class, 'insertPTE']);
Route::post('/seksi/add/insert_d3te', [SeksiController::class, 'insertD3TE']);
Route::get('/seksi/detail/{id}', [SeksiController::class, 'detail']);
Route::post('/seksi/detail/add_participant/', [SeksiController::class, 'addParticipant']);
Route::get('/seksi/hapus_peserta/{id_participant}', [SeksiController::class, 'deleteParticipant']);
Route::get('/seksi/verifikasi_peserta/{id_participant}', [SeksiController::class, 'verifParticipant']);
Route::post('/seksi/update/{id}', [SeksiController::class, 'update']);
Route::post('/seksi/reset_token/{id}', [SeksiController::class, 'resetToken']);
Route::get('/seksi/nonaktif/{id}', [SeksiController::class, 'nonaktif']);
Route::get('/seksi/aktif/{id}', [SeksiController::class, 'aktif']);

//Absensi
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
Route::get('/absensi/detail/{id}', [AbsensiController::class, 'detailAbsensi']);
Route::get('/absensi/lihat_peserta/{id}', [AbsensiController::class, 'lihatPeserta']);
Route::post('/absensi/insert_pertemuan_absensi/', [AbsensiController::class, 'insertPertemuanAbsensi']);
Route::get('/absensi/detail/{id_seksi}/pertemuan/{id_pertemuan}', [AbsensiController::class, 'detailPertemuan']);
Route::get('/absensi/verifikasi_absensi/{id_absensi}', [AbsensiController::class, 'verifikasiAbsensi']);
Route::post('/absensi/catatan_absensi/{id_absensi}', [AbsensiController::class, 'catatanAbsensi']);
Route::get('/absensi/reset_absensi/{id_absensi}', [AbsensiController::class, 'resetAbsensi']);
Route::get('/download/seksi{id_seksi}/qrcode{id_pertemuan}', [AbsensiController::class, 'downloadQRCode']);
Route::post('/recovery/qrcode/absensi/{id_seksi}/pertemuan/{id_pertemuan}', [AbsensiController::class, 'recoveryQRCode']);
Route::post('/edit/seksi/{id_seksi}/pertemuan/{id_pertemuan}', [AbsensiController::class, 'editPertemuan']);
Route::get('/delete/seksi/{id_seksi}/pertemuan/{id_pertemuan}', [AbsensiController::class, 'deletePertemuan']);
Route::get('/absensi/detail/{id_seksi}/pertemuan/{id_pertemuan}/print', [AbsensiController::class, 'printPertemuan']);
Route::get('/absensi/detail/{id_seksi}/print', [AbsensiController::class, 'printPerSemester']);

// For Dosen

// Dashboard
Route::get('/dashboard_dosen', [DashboardController::class, 'indexDosen']);

// Seksi
Route::get('/seksi_dosen', [SeksiDosenController::class, 'index'])->name('seksi_dosen');
Route::get('/seksi_dosen/nonaktif', [SeksiDosenController::class, 'indexNonaktif'])->name('seksi_dosen_nonaktif');
Route::post('/seksi_dosen/insert_seksi', [SeksiDosenController::class, 'insertSeksi']);
Route::get('/seksi_dosen/detail/{id}', [SeksiDosenController::class, 'detail']);
Route::post('/seksi_dosen/detail/add_participant/', [SeksiDosenController::class, 'addParticipant']);
Route::get('/seksi_dosen/hapus_peserta/{id_participant}', [SeksiDosenController::class, 'deleteParticipant']);
Route::get('/seksi_dosen/verifikasi_peserta/{id_participant}', [SeksiDosenController::class, 'verifParticipant']);
Route::post('/seksi_dosen/update/{id}', [SeksiDosenController::class, 'update']);
Route::post('/seksi_dosen/reset_token/{id}', [SeksiDosenController::class, 'resetToken']);
Route::get('/seksi_dosen/nonaktif/{id}', [SeksiDosenController::class, 'nonaktif']);
Route::get('/seksi_dosen/aktif/{id}', [SeksiDosenController::class, 'aktif']);

// Absensi
Route::get('/absensi_dosen', [AbsensiDosenController::class, 'index'])->name('absensi-dosen');
Route::get('/absensi_dosen/detail/{id}', [AbsensiDosenController::class, 'detailAbsensi']);
Route::get('/absensi_dosen/lihat_peserta/{id}', [AbsensiDosenController::class, 'lihatPeserta']);
Route::post('/absensi_dosen/insert_pertemuan_absensi/', [AbsensiDosenController::class, 'insertPertemuanAbsensi']);
Route::get('/absensi_dosen/detail/{id_seksi}/pertemuan/{id_pertemuan}', [AbsensiDosenController::class, 'detailPertemuan']);
Route::get('/absensi_dosen/verifikasi_absensi/{id_absensi}', [AbsensiDosenController::class, 'verifikasiAbsensi']);
Route::post('/absensi_dosen/catatan_absensi/{id_absensi}', [AbsensiDosenController::class, 'catatanAbsensi']);
Route::get('/absensi_dosen/reset_absensi/{id_absensi}', [AbsensiDosenController::class, 'resetAbsensi']);
Route::get('/download_dosen/seksi{id_seksi}/qrcode{id_pertemuan}', [AbsensiDosenController::class, 'downloadQRCode']);
Route::post('/recovery_dosen/qrcode/absensi/{id_seksi}/pertemuan/{id_pertemuan}', [AbsensiDosenController::class, 'recoveryQRCode']);
Route::post('/edit_dosen/seksi/{id_seksi}/pertemuan/{id_pertemuan}', [AbsensiDosenController::class, 'editPertemuan']);
Route::get('/delete_dosen/seksi/{id_seksi}/pertemuan/{id_pertemuan}', [AbsensiDosenController::class, 'deletePertemuan']);
Route::get('/absensi_dosen/detail/{id_seksi}/pertemuan/{id_pertemuan}/print', [AbsensiDosenController::class, 'printPertemuan']);
Route::get('/absensi_dosen/detail/{id_seksi}/print', [AbsensiDosenController::class, 'printPerSemester']);

// For Mahasiswa

// Dashboard
Route::get('/dashboard_mahasiswa', [DashboardController::class, 'indexMahasiswa']);

// Kelas
Route::get('/cari_kelas', [CariKelasController::class, 'index']);
Route::get('/cari_kelas/detail', [CariKelasController::class, 'cariKelas']);
Route::post('/cari_kelas/detail/tambah_participant', [CariKelasController::class, 'tambahParticipant']);

// Absensi
Route::get('/absensi_mahasiswa', [AbsensiMahasiswaController::class, 'index'])->name('absensi-mahasiswa');
Route::get('/absensi_mahasiswa/detail/{id}', [AbsensiMahasiswaController::class, 'detailAbsensi']);
Route::get('/absensi_mahasiswa/lihat_peserta/{id}', [AbsensiMahasiswaController::class, 'lihatPeserta']);
Route::post('/absensi_mahasiswa/insert_pertemuan_absensi/', [AbsensiMahasiswaController::class, 'insertPertemuanAbsensi']);
Route::get('/absensi_mahasiswa/detail/{id_seksi}/pertemuan/{id_pertemuan}', [AbsensiMahasiswaController::class, 'detailPertemuan']);
Route::get('/absensi_mahasiswa/verifikasi_absensi/{id_absensi}', [AbsensiMahasiswaController::class, 'verifikasiAbsensi']);
Route::post('/absensi_mahasiswa/catatan_absensi/{id_absensi}', [AbsensiMahasiswaController::class, 'catatanAbsensi']);
Route::get('/absensi_mahasiswa/reset_absensi/{id_absensi}', [AbsensiMahasiswaController::class, 'resetAbsensi']);
Route::get('/download_mahasiswa/seksi{id_seksi}/qrcode{id_pertemuan}', [AbsensiMahasiswaController::class, 'downloadQRCode']);
Route::post('/recovery_mahasiswa/qrcode/absensi/{id_seksi}/pertemuan/{id_pertemuan}', [AbsensiMahasiswaController::class, 'recoveryQRCode']);
Route::post('/edit_mahasiswa/seksi/{id_seksi}/pertemuan/{id_pertemuan}', [AbsensiMahasiswaController::class, 'editPertemuan']);
Route::get('/delete_mahasiswa/seksi/{id_seksi}/pertemuan/{id_pertemuan}', [AbsensiMahasiswaController::class, 'deletePertemuan']);
Route::get('/absensi_mahasiswa/detail/{id_seksi}/pertemuan/{id_pertemuan}/print', [AbsensiMahasiswaController::class, 'printPertemuan']);
Route::get('/absensi_mahasiswa/detail/{id_seksi}/print', [AbsensiMahasiswaController::class, 'printPerSemester']);