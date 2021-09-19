<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'kode_admin';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_admin',
        'user_id',
        'nama_admin',
        'nip_admin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
