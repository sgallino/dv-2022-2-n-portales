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
        Schema::create('paises', function (Blueprint $table) {
            // Para los "paises" cambiamos la PK a un SMALLINT (en vez de BIGINT).
            $table->smallIncrements('pais_id');
            $table->string('nombre', 125);
            $table->char('abreviatura', 3)->comment('Siguiendo el "alpha3" del ISO 3166. Por ejemplo: ARG, BRA.');
            $table->timestamps();

            // Agregamos el índice para el nombre del país.
            $table->index('nombre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paises');
    }
};
