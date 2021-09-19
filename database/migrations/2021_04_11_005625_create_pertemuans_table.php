<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePertemuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertemuans', function (Blueprint $table) {
            $table->bigIncrements('id_pertemuan');
            $table->unsignedBigInteger('id_seksi')->nullable();
            $table->foreign('id_seksi')->references('id')->on('seksis')->onDelete('cascade');
            $table->date('tanggal')->nullable();
            $table->longText('materi')->nullable();
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
        Schema::dropIfExists('pertemuans');
    }
}
