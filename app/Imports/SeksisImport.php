<?php

namespace App\Imports;

use App\Models\Seksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class SeksisImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Seksi([
            'kode_seksi' => $row[1],
            'token' => $row[2],
            'kode_jurusan' => $row[3],
            'kode_mk' => $row[4],
            'kode_dosen' => $row[5],
            'kode_ruang' => $row[6],
            'hari' => $row[7],
            'jadwal_mulai' => $row[8],
            'jadwal_selesai' => $row[9],
            'status' => $row[10],
            'created_at' => $row[11],
            'updated_at' => $row[12],
        ]);
    }
}
