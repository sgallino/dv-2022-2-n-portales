<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * La clase Route nos permite definir las rutas de la aplicación.
 * Una "ruta" es una URL de nuestro sitio junto al método de HTTP (GET, POST, PUT, etc) con el que se
 * debe acceder.
 * Al definir la ruta, se nos va a pedir que le indiquemos cómo debe procesarse esa ruta. Es decir, qué
 * hay que hacer cuando el usuario acceda a dicha ruta.
 * Hay 2 posibilidades:
 * 1. Usar un Closure (función anónima) con el código que se debe ejecutar. Eso es lo que tiene el ejemplo
 * default que trae Laravel.
 * 2. Usar un array para indicar qué "controller" debe encargarse, y con qué método del mismo.
 *
 * Por ejemplo, la ruta que trae Laravel por defecto es esta:
 *
 *
 * Route::get('/', function () {
 *     return view('welcome');
 * });
 *
 * Ese código está definiendo una ruta que se accede por GET, a la URL "/", que es la raíz de la carpeta
 * "public/". Todas las rutas siempre parten de esa carpeta.
 * Luego, le pasa un Closure donde indica cómo debe procesarse esa petición. En este caso, renderizando
 * la vista "welcome".
 *
 * Esta forma de organizar las rutas de un proyecto tiene la ventaja de que separa completamente lo que
 * es la URL para el usuario de lo que es el código para el desarrollador.
 * Tenemos total flexibilidad para escribir URLs bien amigables para el usuario (mejorando la UX y el SEO)
 * así como de armar el código interno de la forma que más nos convenga.
 *
 * La contra es que vamos a tener que definir manualmente desde acá todas las rutas.
 *
 * Si bien el ejemplo de Laravel es con un Closure, en general evitamos hacer esto.
 * Siempre se prefiere usar controllers para asociar las rutas.
 * El motivo es simple. Si usamos Closures terminamos poniendo mucha lógica en este archivo, y deja de
 * ser una "hoja de rutas" de la página, a tener un montón de distintas responsabilidades.
 *
 * Vamos a crear una ruta que pida usar un "HomeController" con un método "home" para mostrar el contenido.
 *
 * Para definir el controller, pasamos el array que debe tener 2 valores:
 * 1. String. El FQN de la clase del controller.
 * 2. String. El nombre del método del controller que va a procesar la ruta.
 *
 * Para que esto funcione, vamos a necesitar crear el controller.
 * Por defecto, los controllers se ubican en la carpeta [app/Http/Controllers].
 *
 * Las rutas pueden, también, tener múltiples parámetros adicionales que podemos definirles, a través de
 * su interfaz fluida.
 * Por ejemplo, tenemos la propiedad "name" que permite definir un nombre a la ruta.
 * Esto no modifica en nada el HTML que se genera, pero nos permite que en el framework nos refiramos a las
 * rutas por su nombre, en vez de su URL.
 */
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [\App\Http\Controllers\HomeController::class, 'home'])
    ->name('home');

Route::get('nosotros', [\App\Http\Controllers\NosotrosController::class, 'index'])
    ->name('nosotros');

/*
 |--------------------------------------------------------------------------
 | Autenticación
 |--------------------------------------------------------------------------
 */
Route::get('iniciar-sesion', [\App\Http\Controllers\AuthController::class, 'loginForm'])
    ->name('auth.login.form')
    ->middleware(['guest']);
Route::post('iniciar-sesion', [\App\Http\Controllers\AuthController::class, 'loginEjecutar'])
    ->name('auth.login.ejecutar')
    ->middleware(['guest']);
Route::post('cerrar-sesion', [\App\Http\Controllers\AuthController::class, 'logout'])
    ->name('auth.logout')
    ->middleware(['auth']);

Route::get('recuperar-password-email', [\App\Http\Controllers\RecuperarPasswordController::class, 'emailRecuperarForm'])
    ->name('password.request')
    ->middleware(['guest']);

Route::post('recuperar-password-email', [\App\Http\Controllers\RecuperarPasswordController::class, 'emailRecuperarEnviar'])
    ->name('password.email')
    ->middleware(['guest']);

Route::get('restablecer-password/{token}', [\App\Http\Controllers\RecuperarPasswordController::class, 'restablecerPasswordForm'])
    ->name('password.reset')
    ->middleware(['guest']);

Route::post('restablecer-password', [\App\Http\Controllers\RecuperarPasswordController::class, 'restablecerPasswordEjecutar'])
    ->name('password.update')
    ->middleware(['guest']);

/*
 |--------------------------------------------------------------------------
 | Películas
 |--------------------------------------------------------------------------
 | Creamos (esto es opcional) un grupo de rutas.
 | Esto permite poner configuración común a todas las rutas que estén contenidas por el grupo.
 | Por ejemplo, ponemos un prefijo común para la URL de las rutas.
 */
Route::prefix('admin/peliculas')
    ->middleware(['auth']) // Requieren que el usuario esté autenticado.
    // Configuramos el Controller que, por defecto, todas las rutas del grupo deben usar.
    ->controller(\App\Http\Controllers\AdminPeliculasController::class)
    ->group(function() {
        Route::get('/','index')
            ->name('admin.peliculas.listado');

        Route::get('/nueva','nuevaForm')
            ->name('admin.peliculas.nueva.form');

        Route::post('/nueva','nuevaGrabar')
            ->name('admin.peliculas.nueva.grabar');

        /*
         * Un requerimiento típico en cualquier sistema web es tener valores en la URL.
         * Tradicionalmente, esto lo hacemos con el query string (?campo=valor...).
         * Pero para lo que URLs de pantallas de nuestro sitio, y no meramente valores de personalización (como una
         * búsqueda), es un problema que los datos estén en el query string. Esto se debe a que los buscadores como
         * Google penalizan las páginas que usan parámetros en el query string.
         * Es por eso que en general se busca que las URLs sean "amigables", y usen segmentos de la ruta para definir
         * los valores que son dinámicos.
         * Estos segmentos dinámicos de las URLs, Laravel los llama "parámetros de ruta".
         * Para identificarlos, usamos la sintaxis de {nombre} . Donde "nombre" se reemplaza por el nombre de la
         * variable en la que Laravel va a ofrecer el valor (ver método del controller).
         *
         * Opcionalmente, podemos poner "restricciones" que tienen que cumplir esos parámetros.
         */
        Route::get('/{id}','ver')
            ->name('admin.peliculas.ver')
        //    ->where('id', '[0-9]+')
            ->whereNumber('id');

        Route::get('/{id}/editar','editarForm')
            ->name('admin.peliculas.editar.form')
            ->whereNumber('id');

        Route::post('/{id}/editar','editarEjecutar')
            ->name('admin.peliculas.editar.ejecutar')
            ->whereNumber('id');


        Route::get('/{id}/eliminar','eliminarConfirmar')
            ->name('admin.peliculas.eliminar.confirmar')
            ->whereNumber('id');

        Route::post('/{id}/eliminar','eliminarEjecutar')
            ->name('admin.peliculas.eliminar.ejecutar')
            ->whereNumber('id');
    });
