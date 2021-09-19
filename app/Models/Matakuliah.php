<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Matakuliah extends Model
{
    protected $table = "matakuliahs";
    protected $primaryKey = 'kode_mk';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'kode_jurusan',
        'sks',
        'status',
        'created_at',
        'updated_at'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Matakuliah::class, 'kode_jurusan', 'kode_jurusan');
    }
}
