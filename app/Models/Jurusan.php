<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = "jurusans";
    protected $primaryKey = 'kode_jurusan';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
        'status',
        'created_at',
        'updated_at'
    ];

    public function matakuliah()
    {
        return $this->hasMany(Matakuliah::class, 'kode_jurusan', 'kode_jurusan');
    }
}
