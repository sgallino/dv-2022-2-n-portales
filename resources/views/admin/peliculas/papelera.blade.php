<?php
/** @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator|\App\Models\Pelicula[] $peliculas */
/** @var array $buscarParams */
?>
@extends('layouts.admin')

@section('title', 'Películas Eliminadas')

@section('main')
    <h1 class="mb-3">Papelera de Reciclaje de Películas</h1>

    <p class="mb-3">
        <a href="{{ route('admin.peliculas.listado') }}">Volver al listado</a>
    </p>

    {{--<section class="mb-3">
        <h2 class="mb-3">Buscador</h2>

        <form action="{{ route('admin.peliculas.listado') }}" method="get">
            <div class="mb-3">
                <label for="b-titulo" class="form-label">Título</label>
                <input type="text" id="b-titulo" name="titulo" class="form-control" value="{{ $buscarParams['titulo'] ?? null }}">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </section>--}}

    @if($peliculas->isNotEmpty())
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Precio</th>
            <th>País</th>
            <th>Géneros</th>
            <th>Clasificación</th>
            <th>Fecha de Estreno</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($peliculas as $pelicula)
            <tr>
                <td>{{ $pelicula->pelicula_id }}</td>
                <td>{{ $pelicula->titulo }}</td>
                <td>$ {{ $pelicula->precio }}</td>
                {{-- Para acceder al registro de una tabla relacionada definida en el modelo, usamos la
                 propiedad dinámica de Eloquent llamada igual que el método que definió la relación.
                 En nuestro caso, creamos un método "pais()" para definir la relación con paises, así que
                 la propiedad para acceder a la instancia de Pais asociada será "pais". --}}
                <td>{{ $pelicula->pais->abreviatura }}</td>
                <td>
                    {{-- isNotEmpty() es un método de las Collections de Laravel. --}}
                    {{--@if($pelicula->generos->isNotEmpty())
                        @foreach($pelicula->generos as $genero)
                            <span class="badge bg-secondary">{{ $genero->nombre }}</span>
                        @endforeach
                    @else
                        No especificado.
                    @endif--}}
                    {{-- Rescribiendo lo anterior con el bucle de Blade forelse: --}}
                    @forelse($pelicula->generos as $genero)
                        <span class="badge bg-secondary">{{ $genero->nombre }}</span>
                    @empty
                        No especificado.
                    @endforelse
                </td>
                <td>{{ $pelicula->clasificacion->abreviatura }}</td>
                <td>{{ $pelicula->fecha_estreno }}</td>
                <td>
                    <div class="d-flex gap-1">
                        {{-- Como segundo parámetro de route(), pasamos un array con los valores para cada
                         parámetro de ruta que se necesite. --}}
                        {{--<a href="{{ route('admin.peliculas.ver', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-primary">Ver</a>--}}
                        {{-- TODO: Que el eliminar pida una confirmación. --}}
                        <form action="{{ route('admin.peliculas.restaurar.ejecutar', ['id' => $pelicula->pelicula_id]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary">Restaurar</button>
                        </form>
                        <form action="{{ route('admin.peliculas.eliminar-definitivamente.ejecutar', ['id' => $pelicula->pelicula_id]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <p>No hay películas eliminadas.</p>
    @endif

    {{--{{ $peliculas->links() }}--}}
@endsection
