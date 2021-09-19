<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->bigIncrements('id_absensi');
            $table->unsignedBigInteger('id_pertemuan')->nullable();
            $table->foreign('id_pertemuan')->references('id_pertemuan')->on('pertemuans')->onDelete('cascade');
            $table->unsignedBigInteger('id_seksi')->nullable();
            $table->foreign('id_seksi')->references('id')->on('seksis')->onDelete('cascade');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('imei_absensi')->unique()->nullable();
            $table->string('qrcode')->nullable();
            $table->string('qrcode_image')->nullable();
            $table->string('keterangan')->nullable();
            $table->longText('catatan')->nullable();
            $table->boolean('verifikasi')->nullable();
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
        Schema::dropIfExists('absensis');
    }
}
