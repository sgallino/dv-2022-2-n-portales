<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use App\Models\Pais;
use App\Models\Pelicula;
use Illuminate\Http\Request;

class AdminPeliculasController extends Controller
{
    public function index()
    {
        // Obtenemos todas las películas de la tabla a través del modelo Pelicula.
//        $peliculas = Pelicula::all();
        /*
         |--------------------------------------------------------------------------
         | Cargando datos con relaciones
         |--------------------------------------------------------------------------
         | El método "all()" solo sirve si queremos traer _todo_ lo que la tabla
         | tiene, o sea todos sus registros, sin ningún tipo de agregado, como puede
         | ser las relaciones.
         |
         | Para poder agregar otras características, entonces nosotros primero vamos
         | definiendo las cosas que queremos sumar en consideración para la ejecución
         | de la consulta, y finalmente, ejecutamos el método "get()" para correr el
         | query.
         |
         | Por ejemplo, si queremos agregar relaciones al query, podemos hacerlo con
         | el método "with()".
         | Este método recibe un string o array de strings, que contengan los nombres
         | de las relaciones. Esto sería el nombre del método.
         */
        $peliculas = Pelicula::with(['pais', 'generos'])->get();

        // dd() (dump and die) es un helper de Laravel que imprime todo lo que tiene la variable que le
        // pasemos.
//        dd($peliculas);

        // Ahora necesitamos pasarle esa variable a la vista.
        // Esto lo hacemos con el segundo parámetro de la función "view()", que recibe un array asociativo,
        // donde las claves van a ser los nombres de las variables que la vista va a tener.
        return view('admin/peliculas/index', [
            'peliculas' => $peliculas,
//            'peliculas' => Pelicula::all(),
        ]);
    }

    // El parámetro "$id" sale del parámetro de la ruta "{id}".
    public function ver(int $id)
    {
        // Obtenemos la película correspondiente a este id.
        // Para esto, Laravel nos da el método find().
        // Ese método retorna una instancia de la clase de Eloquent con los datos del registro cuya PK
        // sea el valor provisto como argumento. Si no existe, retorna null.
//        $pelicula = Pelicula::find($id);
        // Si queremos que cuando un registro no exista, en vez de retornar null se lance una Exception,
        // podemos usar el método "findOrFail".
        // Este lanza una ModelNotFoundException, que Laravel, por defecto, captura y muestra un 404.
        $pelicula = Pelicula::findOrFail($id);

        return view('admin.peliculas.ver', [
            'pelicula' => $pelicula,
        ]);
    }

    public function nuevaForm()
    {
//        $paises = Pais::all();
        // Ordenamos los paises por su nombre.
        $paises = Pais::orderBy('nombre')->get();

        // Noten que en la función "view" podemos reemplazar las "/" de la ruta con ".".
        return view('admin.peliculas.nueva-form', [
            'paises' => $paises,
            'generos' => Genero::orderBy('nombre')->get(),
        ]);
    }

    public function nuevaGrabar(Request $request)
    {
        // Vamos finalmente a grabar.
        // El primer paso, obviamente, es obtener los datos del form.
        // Típicamente, esto lo hacíamos usando las súperglobales de php como $_POST.
        // Eso generalmente se desaconseja. Se recomienda evitar usar directamente esas variables, y en
        // su lugar, usar un intermediario que lidie con esa variable, sin que nadie más lo que haga.
        // ¿Por qué?
        // Por lo pronto, por 2 razones:
        // 1. Las súperglobales, como su nombre indica, son globales. Como toda variable global, suelen ser
        //  casi siempre un problema. Esto es problemático porque es una fuente de bugs enorme, sin mencionar
        //  que el código que usa variables globales es muy difícil de testear.
        // 2. $_POST solo levanta los datos que vengan con formato de form (campo=valor&campo2=valor2...),
        //  en el cuerpo de la petición y que estén el header correspondiente a un form. Esto ignora otras
        //  posibles y comunes formas de pasar datos, como formato JSON.
        // Los intermediarios, como la clase Request que Laravel nos provee, se encargan de obtener la data
        // según el formato de la petición.
        // La clase Request, entonces, contiene múltiples métodos para obtener información de la petición del
        // usuario.
        // Para tener acceso a la instancia con los datos de Request, debemos "inyectarla" como parámetro en
        // el método del Controller.

        // Pedimos todos los datos del formulario.
        // input() retorna todos los datos del formulario.
//        $data = $request->input();
        // Si solo queremos algunos, podemos pedirlos con el método only().
//        $data = $request->only(['titulo', 'precio', 'fecha_estreno']);

        // Si queremos todos, salvo alguno que otro, podemos excluir datos usando el método except().
        $data = $request->except(['_token']);

        // Validación
        // Laravel busca simplificarnos lo más posible el bajón de hacer las validaciones.
        // La clase Request tiene un método llamado "validate()", el cual recibe un array de las "reglas"
        // de validación.
        // Si las reglas pasan, retorna los valores que pasaron las reglas, y el programa continúa su curso.
        // Si uno o más campo fallan, entonces graba los valores actuales del form en una variable de sesión
        // "flash", graba los mensajes de error en otra, y redirecciona al usuario a la pantalla de la que
        // vino. Siempre y cuando sea una petición por HTTP común.
        // Los datos enviados por la sesión son luego levantados automágicamente por Laravel (ver vista).
        $request->validate(Pelicula::VALIDATE_RULES, Pelicula::VALIDATE_MESSAGES);

        /*
         |--------------------------------------------------------------------------
         | Upload de imagen
         |--------------------------------------------------------------------------
         | https://laravel.com/docs/9.x/requests#files
         */
        if($request->hasFile('portada')) {
            $portada = $request->file('portada');
            // Generamos un nombre para la imagen.
            // Por ejemplo, la fecha actual, seguida de "_", seguida del título de la película transformado
            // a un "slug" para la URL.
            // Para hacer el slug, usamos el método Str::slug().
            // Finalmente, le agregamos la extensión.
            $nombrePortada = date('YmdHis') . "_" . \Str::slug($data['titulo']) . "." . $portada->extension();

            // Movemos la portada a su ubicación final.
            // Para indicar el directorio, podemos ayudarnos con la función public_path() que genera la URL
            // absoluta a la carpeta public.
            // Forma 1: Moviendo el archivo a una ubicación indicada por nosotros.
//            $portada->move(public_path('imgs'), $nombrePortada);

            // Forma 2: Usando la API de Storage/Filesystem de Laravel.
            $portada->storeAs('imgs', $nombrePortada, 'public');

            $data['portada'] = $nombrePortada;
        }


        /*
         |--------------------------------------------------------------------------
         | Géneros
         |--------------------------------------------------------------------------
         | Como vimos en Programación 2, cuando tenemos datos de una tabla relacionada
         | en forma n:m, vamos a tener que insertar en la tabla pivot un registro por
         | cada id que nos llegue de esa relación. Por ejemplo, si tenemos los ids de
         | géneros [2, 4, 7], tendremos que insertar 3 registros, uno por cada id de
         | género.
         | Cada uno tiene que insertarse junto al id de la película.
         | Por eso, teníamos que primero insertar la película, obtener el id, y ahí
         | recién armar el INSERT con los múltiples registros a grabar.
         |
         | https://laravel.com/docs/9.x/eloquent-relationships#updating-many-to-many-relationships
         | Eloquent nos simplifica notablemente este proceso con ayuda de 3 métodos
         | de las relaciones n:m, que son:
         | - attach()
         | - detach()
         | - sync()
         |
         | Cualquiera de ellos debe llamarse sobre el método de la relación del modelo
         | "padre". Por ejemplo, tendremos que llamarlo desde el método "generos()" de
         | un modelo Pelicula.
         | La película ya la creamos, y obtuvimos la instancia correspondiente con el
         | $pelicula = Pelicula::create($data);
         |
         | Para grabar, entonces vamos a usar el método "attach()", que recibe un id
         | o array de ids a insertar.
         | Como puede no haber generos, nos aseguramos de poner un array vacío como
         | default.
         | Muy importante, noten que estamos llamando al _método_ "generos()", y no
         | a la _propiedad_ "generos".
         */

        /*
         |--------------------------------------------------------------------------
         | Transacciones
         |--------------------------------------------------------------------------
         | Tenemos 2 maneras de implementar transacciones con Laravel:
         | 1. La "manual", usando los métodos que corresponden a PDO.
         | 2. Usando un "Closure".
         */

        // Forma 1: "Manual", mayor control.
//        \DB::beginTransaction();
//        try {
//            // Usamos el método "static" Pelicula::create para grabar la data que le pasamos como parámetro.
//            // Retorna la instancia de película creada y grabada en la base.
//            $pelicula = Pelicula::create($data);
////            throw new \Exception(); // Descomentar para ver que no graba si algo sale mal.
//            $pelicula->generos()->attach($data['generos'] ?? []);
//            \DB::commit();
//            // ...
//        } catch(\Exception $e) {
//            \DB::rollBack();
//            // ...
//        }

        // Forma 2: Usando un Closure.
        // Cuando usamos un Closure, a diferencia de lo que pasa en JS, no tenemos acceso a las variables
        // definidas en el contexto superior (el que contiene al Closure).
        // Por ejemplo, $data no está disponible en el Closure, pese a que está definida en la función
        // superior.
        // Podemos hacer que sea accesible esa variable (o todas las que queramos), pero tenemos que hacerlo
        // de manera explícita.
        // Para "pasar" una variable a la función, agregamos la instrucción "use".
        try {
            \DB::transaction(function() use ($data) {
                $pelicula = Pelicula::create($data);
                $pelicula->generos()->attach($data['generos'] ?? []);
            });

            // Redireccionamos al listado.
            return redirect()
                ->route('admin.peliculas.listado')
                // Muchas veces vamos a querer mostrar mensajes de "feedback" al usuario luego de una acción
                // y su redireccionamiento.
                // Para esto, Laravel tiene el método "with()" de Redirect, que permite agregar variables
                // de sesión tipo "flash".
//            ->with('status.message', 'La película <b>' . e($pelicula->titulo) . '</b> fue creada exitosamente.')
                ->with('status.message', 'La película <b>' . e($data['titulo']) . '</b> fue creada exitosamente.')
                ->with('status.type', 'success');
        } catch(\Exception $e) {
            return redirect()
                ->route('admin.peliculas.nueva.form')
                // withInput() agrega los datos del form en una variable "flash" de sesión, para que estén
                // disponibles en la función "old()".
                ->withInput()
                ->with('status.message', 'Ocurrió un error inesperado al tratar de crear la película.')
                ->with('status.type', 'danger');
        }


    }

    public function editarForm(int $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        return view('admin.peliculas.editar-form', [
            'pelicula' => $pelicula,
            'paises' => Pais::orderBy('nombre')->get(),
            'generos' => Genero::orderBy('nombre')->get(),
        ]);
    }

    public function editarEjecutar(Request $request, int $id)
    {
        $request->validate(Pelicula::VALIDATE_RULES, Pelicula::VALIDATE_MESSAGES);

        $pelicula = Pelicula::findOrFail($id);

        $data = $request->except(['_token']);

        if($request->hasFile('portada')) {
            $portada = $request->file('portada');
            $nombrePortada = date('YmdHis') . "_" . \Str::slug($data['titulo']) . "." . $portada->extension();

            // Forma 1: Moviendo el archivo a una ubicación indicada por nosotros.
//            $portada->move(public_path('imgs'), $nombrePortada);

            // Forma 2: Usando la API de Storage/Filesystem de Laravel.
            $portada->storeAs('imgs', $nombrePortada, 'public');

            $data['portada'] = $nombrePortada;
            // Guardamos la portada vieja para poder eliminar luego del update...
            $portadaVieja = $pelicula->portada;
        }

        /*
         |--------------------------------------------------------------------------
         | Géneros
         |--------------------------------------------------------------------------
         | Con ayuda del método "sync()", podemos resolver fácilmente este apartado.
         | sync() recibe un id o array de ids, y se asegura de que solo esos ids
         | queden como registros en la tabla pivot. Si hay registros que sobran, los
         | elimina, si hay registros que faltan, los inserta.
         |
         | Como mencionamos antes, noten que lo invocamos desde el _método_ "generos()"
         | y no desde la _propiedad_ "generos".
         */

        try {
            \DB::transaction(function() use($data, $pelicula) {
                $pelicula->update($data);
                $pelicula->generos()->sync($data['generos'] ?? []);
            });

            // Borramos la portada vieja.
            if($portadaVieja ?? false) {
//            unlink(public_path('imgs/' . $portadaVieja));
                \Storage::disk('public')->delete('imgs/' . $portadaVieja);
            }

            return redirect()
                ->route('admin.peliculas.listado')
                ->with('status.message', 'La película <b>' . e($pelicula->titulo) . '</b> fue editada exitosamente.')
                ->with('status.type', 'success');
        } catch(\Exception $e) {
            return redirect()
                ->route('admin.peliculas.editar.form', ['id' => $id])
                // withInput() agrega los datos del form en una variable "flash" de sesión, para que estén
                // disponibles en la función "old()".
                ->withInput()
                ->with('status.message', 'Ocurrió un error inesperado al tratar de actualizar la película.')
                ->with('status.type', 'danger');
        }
    }

    public function eliminarConfirmar(int $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        return view('admin.peliculas.eliminar', [
            'pelicula' => $pelicula,
        ]);
    }

    public function eliminarEjecutar(int $id)
    {
        $pelicula = Pelicula::findOrFail($id);
        $portadaVieja = $pelicula->portada;

        /*
         |--------------------------------------------------------------------------
         | Géneros
         |--------------------------------------------------------------------------
         | Eliminamos los géneros con ayuda del método detach().
         | Noten, nuevamente, que este método se ejecuta desde el _método_ "generos()"
         | y no desde la _propiedad_ "generos".
         */
        try {
            \DB::transaction(function() use ($pelicula) {
                $pelicula->generos()->detach();
                $pelicula->delete();
            });

            // Borramos la portada vieja.
            if($portadaVieja ?? false) {
//            unlink(public_path('imgs/' . $portadaVieja));
                \Storage::disk('public')->delete('imgs/' . $portadaVieja);
            }

            return redirect()
                ->route('admin.peliculas.listado')
                ->with('status.message', 'La película <b>' . e($pelicula->titulo) . '</b> fue eliminada exitosamente.')
                ->with('status.type', 'success');
        } catch(\Exception $e) {
            return redirect()
                ->route('admin.peliculas.editar.form', ['id' => $id])
                // withInput() agrega los datos del form en una variable "flash" de sesión, para que estén
                // disponibles en la función "old()".
                ->withInput()
                ->with('status.message', 'Ocurrió un error inesperado al tratar de actualizar la película.')
                ->with('status.type', 'danger');
        }
    }
}
