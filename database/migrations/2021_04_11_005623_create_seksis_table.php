<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateSeksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_seksi', 20)->unique();
            $table->string('token')->nullable();
            $table->string('kode_jurusan', 11)->nullable();
            $table->foreign('kode_jurusan')->references('kode_jurusan')->on('jurusans')->onDelete('cascade');
            $table->string('kode_mk', 11)->nullable();
            $table->foreign('kode_mk')->references('kode_mk')->on('matakuliahs')->onDelete('cascade');
            $table->string('kode_dosen', 11)->nullable();
            $table->foreign('kode_dosen')->references('kode_dosen')->on('dosens')->onDelete('cascade');
            $table->string('kode_ruang', 11)->nullable();
            $table->foreign('kode_ruang')->references('kode_ruang')->on('ruangs')->onDelete('cascade');
            $table->string('hari')->nullable();
            $table->string('jadwal_mulai')->nullable();
            $table->string('jadwal_selesai')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('seksis');
    }
}