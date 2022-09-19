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
        Schema::create('peliculas_tienen_generos', function (Blueprint $table) {
            // Definimos la FK de películas usando la forma abreviada de Laravel.
            // Nota: Solo sirve para referenciar PKs que sean UNSIGNED BIGINT.
            $table->foreignId('pelicula_id')->constrained('peliculas', 'pelicula_id');

            // Como el genero_id es un TINYINT, tenemos que usar la forma "común" para crear la FK.
            $table->unsignedTinyInteger('genero_id');
            $table->foreign('genero_id')->references('genero_id')->on('generos');

            // Definimos la PK como combinación de las dos FKs recién creadas.
            $table->primary(['pelicula_id', 'genero_id']);

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
        Schema::dropIfExists('peliculas_tienen_generos');
    }
};
