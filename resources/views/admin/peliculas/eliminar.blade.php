<?php
/** @var \App\Models\Pelicula $pelicula */
?>
@extends('layouts.admin')

@section('title', "Eliminar la película " . $pelicula->titulo)

@section('main')
    <h1 class="mb-3">Eliminar {{ $pelicula->titulo }}</h1>

    <div class="row mb-3">
        <div class="col-6">
            Acá va a ir la portada...
        </div>
        <div class="col">
            <dl>
                <dt>Precio</dt>
                <dd>$ {{ $pelicula->precio }}</dd>
                <dt>Fecha de Estreno</dt>
                <dd>{{ $pelicula->fecha_estreno }}</dd>
            </dl>
        </div>
    </div>

    <hr>

    <h2 class="mb-3">Sinopsis</h2>

    {{ $pelicula->descripcion }}

    <hr class="my-3">

    <form action="{{ route('admin.peliculas.eliminar.ejecutar', ['id' => $pelicula->pelicula_id]) }}" method="post">
        @csrf
        <h2 class="mb-3">Confirmar Eliminación</h2>
        <p class="mb-3">Estás a punto de eliminar la película <b>{{ $pelicula->titulo }}</b>. Esta acción es (por ahora) irreversible. ¿Querés continuar?</p>
        <button type="submit" class="btn btn-danger">Sí, eliminar</button>
    </form>
@endsection
