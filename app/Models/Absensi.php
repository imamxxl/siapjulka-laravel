<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensis';
    protected $primaryKey = 'id_absensi';
    // protected $keyType = 'big';
    protected $fillable = [
        'id_absensi',
        'id_pertemuan',
        'id_seksi',
        'id_user',
        'imei_absensi',
        'qrcode',
        'qrcode_image',
        'keterangan',
        'file',
        'catatan',
        'verifikasi',
        'created_at',
        'updated_at'
    ];

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class);
    }

    protected $hidden = ['imei_absensi', 'qrcode_image', 'created_at', 'updated_at' ];
}
