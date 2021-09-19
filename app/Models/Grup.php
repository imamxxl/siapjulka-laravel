<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{
    use HasFactory;

    protected $table = "grups";
    protected $primaryKey = 'kode_grup';
    protected $keyType = 'string';
    protected $fillable = [
        'kode_grup',
        'nama_grup',
        'kapasitas',
        'status',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
