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
 */
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);

Route::get('nosotros', [\App\Http\Controllers\NosotrosController::class, 'index']);

Route::get('admin/peliculas', [\App\Http\Controllers\AdminPeliculasController::class, 'index']);
