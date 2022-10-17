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
        Schema::table('peliculas', function (Blueprint $table) {
            $table->unsignedTinyInteger('clasificacion_id')->after('pais_id');
            $table->foreign('clasificacion_id')->references('clasificacion_id')->on('clasificaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peliculas', function (Blueprint $table) {
            $table->dropColumn('clasificacion_id');
        });
    }
};
