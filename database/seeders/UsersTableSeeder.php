<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // created_at & updated_at
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        DB::table('users')->insert([
            'username' => '5335',
            'nama' => 'Delsina Faiza, S.t.,M.t.',
            'jk' => 'Perempuan',
            'password' => Hash::make('123456'),
            'status' => '1',
            'level' => 'admin',
            'avatar' => 'default.jpg',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);

        DB::table('admins')->insert([
            'kode_admin' => '5335',
            'user_id' => '1',
            'nama_admin' => 'Delsina Faiza, S.t.,M.t.',
            'nip_admin' => '198304132009122002',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);
    }
}
