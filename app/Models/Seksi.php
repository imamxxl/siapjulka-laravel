<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seksi extends Model
{
    protected $table = "seksis";
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'kode_seksi',
        'password',
        'kode_jurusan',
        'kode_mk',
        'kode_dosen',
        'kode_ruang',
        'hari',
        'jadwal_mulai',
        'jadwal_selesai',
        'status',
        'created_at',
        'updated_at'
    ];
}
