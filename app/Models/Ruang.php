<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    protected $table = "ruangs";
    protected $primaryKey = 'kode_ruang';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_ruang',
        'nama_ruang',
        'status',
        'created_at',
        'updated_at'
    ];

    public function seksi()
    {
        return $this->belongsTo(Seksi::class, 'kode_ruang', 'kode_ruang');
    }
}
