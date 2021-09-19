<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('nim', 11)->primary();
            $table->string('tahun', 11);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama_mahasiswa');
            $table->string('kode_jurusan', 11)->nullable();
            $table->foreign('kode_jurusan')->references('kode_jurusan')->on('jurusans')->onDelete('cascade');
            $table->string('kode_grup', 20)->nullable();
            $table->foreign('kode_grup')->references('kode_grup')->on('grups')->onDelete('cascade');
            $table->string('imei_mahasiswa')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswas');
    }
}