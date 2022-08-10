<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelajarans', function (Blueprint $table) {
            $table->id();
            $table->string('id_matkul')->nullable();
            $table->string('id_user')->nullable();
            $table->string('mitra')->nullable();
            $table->string('hari')->nullable();
            $table->string('jam_awal')->nullable();
            $table->string('jam_akhir')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('status')->nullable()->comment('1 aktif 2 nonaktif');


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
        Schema::dropIfExists('pembelajarans');
    }
};
