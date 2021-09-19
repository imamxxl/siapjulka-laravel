<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = "mahasiswas";
    protected $primaryKey = 'nim';
    protected $keyType = 'string';
    protected $fillable = [
        'nim',
        'tahun',
        'user_id',
        'nama_mahasiswa',
        'kode_jurusan',
        'kode_grup',
        'imei_mahasiswa',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
