<?php
/** @var \App\Models\Pelicula $pelicula */
// TODO: Hacer una sub-vista para reutilizar en el eliminar.
?>
@extends('layouts.admin')

@section('title', $pelicula->titulo)

@section('main')
    <h1 class="mb-3">{{ $pelicula->titulo }}</h1>

    <div class="row mb-3">
        <div class="col-4">
            {{-- Usando la forma 1 de upload (moviendo a una carpeta indicada manualmente). --}}
{{--            @if($pelicula->portada != null && file_exists(public_path('imgs/' . $pelicula->portada)))--}}
{{--                <img src="{{ url('imgs/' . $pelicula->portada) }}" alt="{{ $pelicula->portada_descripcion }}">--}}
            {{-- Usando la forma 2 de upload (API Storage). --}}
{{--            @if($pelicula->portada != null && file_exists(storage_path('app/public/imgs/' . $pelicula->portada)))--}}
{{--                <img src="{{ url('storage/imgs/' . $pelicula->portada) }}" alt="{{ $pelicula->portada_descripcion }}" class="mw-100">--}}
            @if($pelicula->portada != null && Storage::disk('public')->has('imgs/' . $pelicula->portada))
                <img src="{{ Storage::disk('public')->url('imgs/' . $pelicula->portada) }}" alt="{{ $pelicula->portada_descripcion }}" class="mw-100">
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
                <dt>País de origen</dt>
                <dd>{{ $pelicula->pais->nombre }} ({{ $pelicula->pais->abreviatura }})</dd>
            </dl>
        </div>
    </div>

    <hr>

    <h2 class="mb-3">Sinopsis</h2>

    {{ $pelicula->descripcion }}
@endsection
