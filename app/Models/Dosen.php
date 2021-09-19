<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = "dosens";
    protected $primaryKey = 'kode_dosen';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_dosen',
        'user_id',
        'nama_dosen',
        'nip_dosen',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
