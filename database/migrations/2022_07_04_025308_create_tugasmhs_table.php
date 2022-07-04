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
        Schema::create('tugasmhs', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->nullable();
            $table->string('id_tugas')->nullable();
            $table->string('isi_tm')->nullable();
            $table->string('tgl_tm')->nullable();

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
        Schema::dropIfExists('tugasmhs');
    }
};
