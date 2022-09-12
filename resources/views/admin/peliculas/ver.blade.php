<?php
/** @var \App\Models\Pelicula $pelicula */
?>
@extends('layouts.admin')

@section('title', $pelicula->titulo)

@section('main')
    <h1 class="mb-3">{{ $pelicula->titulo }}</h1>

    <div class="row mb-3">
        <div class="col-4">
            @if($pelicula->portada != null && file_exists(public_path('imgs/' . $pelicula->portada)))
                <img src="{{ url('imgs/' . $pelicula->portada) }}" alt="{{ $pelicula->portada_descripcion }}">
            @else
                Acá iría una imagen default que diga "Sin imagen" o algo así...
            @endif
        </div>
        <div class="col-8">
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
@endsection
