<?php

namespace App\Http\Middleware;

use App\Models\Pelicula;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/*
 * Como podemos ver, los Middleware son clases comunes y corrientes.
 * El único requisito es que tengan un método "handle" que reciba, al menos, 2 argumentos:
 * 1. Request. El objeto de la petición que se está pidiendo ejecutar. Es lo mismo que recibimos en los
 *  Controllers.
 * 2. Closure. Una función que ejecuta el siguiente paso en el procesamiento de la petición (ej: próximo
 *  middleware).
 *
 * Debe retornar siempre una respuesta o una respuesta de redireccionamiento.
 */
class EsMayorDeEdad
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Vamos a preguntar si la película tiene como clasificacion que es para mayores de 18 años,
        // y de así serlo, si el usuario ya confirmó que es mayor de edad.
        // De no haberlo hecho, lo redireccionamos a la pantalla de confirmación.
        // Si lo confirma, vamos a guardar una variable de sesión "mayorDeEdad" con el valor "true".

        // Para obtener la película, necesitamos el id.
        // El id lo estamos recibiendo como un parámetro de ruta.
        // Los detalles de la ruta son parte, en Laravel, de la petición.
        // Por lo tanto, tenemos que pedirle a la petición que nos de la ruta, para pedirle que nos de
        // el parámetro "id".
        $id = $request->route()->parameter('id');
        $pelicula = Pelicula::findOrFail($id);
        if($pelicula->clasificacion_id == 4 && !Session::has('mayorDeEdad')) {
            return redirect()
                ->route('confirmar-mayoria-edad.form', ['id' => $id]);
        }

        // Este return indica que la petición puede seguir su curso.
        return $next($request);
    }
}
