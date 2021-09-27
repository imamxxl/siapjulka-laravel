<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $table = "participants";
    protected $fillable = [
        'id_participant',
        'id_seksi',
        'user_id',
        'imei_participant',
        'keterangan',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['imei_participant', 'created_at', 'updated_at'];
}
