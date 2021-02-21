<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitOnRespondentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('respondents', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

            $table->unsignedBigInteger('sub_unit_id')->nullable();
            $table->foreign('sub_unit_id')->references('id')->on('sub_units')->onDelete('cascade');

            $table->unsignedBigInteger('lokasi_kerja_id')->nullable();
            $table->foreign('lokasi_kerja_id')->references('id')->on('lokasi_kerjas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('respondents', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['sub_unit_id']);
            $table->dropForeign(['lokasi_kerja_id']);
        });
    }
}
