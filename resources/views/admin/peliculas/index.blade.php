<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Pelicula[] $peliculas */
?>
@extends('layouts.admin')

@section('title', 'Administración de Películas')

@section('main')
    <h1 class="mb-3">Administrar de Películas</h1>

    <p class="mb-3">
        <a href="{{ route('admin.peliculas.nueva.form') }}">Publicar una nueva película</a>
    </p>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Precio</th>
            <th>País</th>
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
                <td>{{ $pelicula->fecha_estreno }}</td>
                <td>
                    {{-- Como segundo parámetro de route(), pasamos un array con los valores para cada
                     parámetro de ruta que se necesite. --}}
                    <a href="{{ route('admin.peliculas.ver', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-primary">Ver</a>
                    <a href="{{ route('admin.peliculas.editar.form', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-secondary">Editar</a>
                    <a href="{{ route('admin.peliculas.eliminar.confirmar', ['id' => $pelicula->pelicula_id]) }}" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
