{{--
Vamos a pedir que este template "extienda" o "herede" el template de [layouts/main.blade.php].
La directiva @extends(path) hace exactamente eso.
Donde el "path" debe ser la ruta, a partir de [resources/views] al archivo a extender, sin extensión y
reemplazando las "/" con ".".
--}}
@extends('layouts.main') {{-- Esto busca el archivo [resources/views/layouts/main.blade.php] --}}

{{--@section('title') Página Principal @endsection--}}
{{-- Como abrir y cerrar @section es algo engorroso para solo imprimir un string, Laravel provee una
 alternativa: --}}
@section('title', 'Página Principal') {{-- El segundo parámetro es el contenido. --}}

{{--
Por defecto, cualquier contenido que agreguemos después del @extends va a imprimirse antes del contenido
del archivo heredado.
Para que esto no suceda, tenemos que aclarar en qué espacio "cedido" por el template de layout queremos
ubicar el contenido.
Esto es lo que logramos con la directiva @section('name') y @endsection.
--}}
@section('main') {{-- 'main' es el nombre del @yield() que pusimos en el layout. --}}
<h1>Hola :D</h1>
@endsection
