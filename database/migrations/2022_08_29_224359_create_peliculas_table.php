<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Contiene las instrucciones con las modificaciones que queremos realizar en la base de datos.
     *
     * @return void
     */
    public function up()
    {
        /*
         * Laravel trae una "fachada" ('façade') llamada "Schema" que permite la manipulación de la
         * estructura de una base de datos de manera agnóstica (le da lo mismo si es MySQL/MariaDB, SQLite,
         * etc).
         * Entre sus métodos, está "create()" que crea una nueva tabla en la base de datos.
         * Recibe 2 parámetros:
         * 1. String. El nombre de la tabla.
         * 2. Closure. Función que recibe automáticamente una instancia de la clase "Blueprint" ("plano de
         *  construcción") y debe tener las instrucciones para la creación de la tabla.
         */
        Schema::create('peliculas', function (Blueprint $table) {
            /*
             * La tabla películas va a tener los siguientes campos:
             * - pelicula_id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY_KEY
             * - titulo                 VARCHAR(60)     NOT NULL
             * - precio                 INT             NOT NULL UNSIGNED
             * - fecha_estreno          DATE            NOT NULL
             * - descripcion            TEXT            NOT NULL
             * - portada                VARCHAR(255)    NULL
             * - portada_descripcion    VARCHAR(255)    NULL
             */

            // El método "id()" crea una columna llamada "id" con las siguientes características:
            //      BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY_KEY
            // El nombre lo podemos personalizar como parámetro de la función.
            $table->id("pelicula_id");
            // Para los VARCHAR tenemos que usar el método "string()".
            // Todos los campos son creados como NOT NULL, a menos de que indiquen lo contrario.
            $table->string('titulo', 60);
//            $table->integer('precio')->unsigned();
            $table->unsignedInteger('precio');
            $table->date('fecha_estreno');
            $table->text('descripcion');
            $table->string('portada', 255)->nullable();
            $table->string('portada_descripcion', 255)->nullable();

            // El último campo que vamos a ver que nos agregaron es "timestamps()".
            // Este método crea 2 columnas:
            // 1. created_at    TIMESTAMP
            // 2. updated_at    TIMESTAMP
            // Estos dos campos son utilizados automáticamente por el ORM de Laravel, "Eloquent".
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Contiene las instrucciones para deshacer las modificaciones realizadas en el método "up()".
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peliculas');
    }
};
