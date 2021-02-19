<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespondentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respondents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('nik')->unique();
            $table->string('objid_posisi')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('band')->nullable();
            $table->string('lokasi_kerja')->nullable();
            $table->string('sub_unit')->nullable();
            $table->string('unit')->nullable();
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
        Schema::dropIfExists('respondents');
    }
}
