<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    protected $table = 'pertemuans';
    protected $primaryKey = 'id_pertemuan';
    protected $fillable = [
        'id_pertemuan',
        'id_seksi',
        'tanggal',
        'materi',
        'created_at',
        'updated_at'
    ];

    public function getId()
    {
        return $this->id_pertemuan;
    }

    public function absensi()
    {
        return $this->hasOne(Absensi::class);
    }
}
