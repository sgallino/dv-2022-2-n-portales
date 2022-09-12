<?php
/** @var \Illuminate\Support\ViewErrorBag $errors */
/** @var \App\Models\Pelicula $pelicula */

// $errors es una variable que siempre existe en _todas_ las vistas, que es una colección de los mensajes
// de error de validación, con métodos para su uso.
// Para su uso,
?>
@extends('layouts.admin')

@section('title', 'Editar la Película ' . $pelicula->titulo)

@section('main')
    <h1 class="mb-3">Editando "{{ $pelicula->titulo }}"</h1>

    <form action="{{ route('admin.peliculas.editar.ejecutar', ['id' => $pelicula->pelicula_id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input
                type="text"
                id="titulo"
                name="titulo"
                class="form-control"
                value="{{ old('titulo', $pelicula->titulo) }}"
                @if($errors->has('titulo')) aria-describedby="error-titulo" @endif
            >
            @if($errors->has('titulo'))
                <div class="text-danger" id="error-titulo"><span class="visually-hidden">Error: </span> {{ $errors->first('titulo') }}</div>
            @endif
        </div>
        {{-- Podemos también usar la directiva, directamente. --}}
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input
                type="text"
                id="precio"
                name="precio"
                class="form-control"
                value="{{ old('precio', $pelicula->precio) }}"
                @error('precio') aria-describedby="error-precio" @enderror
            >
            {{-- Dentro de la directiva @error, Laravel provee automáticamente una variable "$message" con el primer mensaje de error de ese campo. --}}
            @error('precio')
                <div class="text-danger" id="error-precio"><span class="visually-hidden">Error: </span> {{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="fecha_estreno" class="form-label">Fecha de Estreno</label>
            <input
                type="date"
                id="fecha_estreno"
                name="fecha_estreno"
                class="form-control"
                value="{{ old('fecha_estreno', $pelicula->fecha_estreno) }}"
                @error('fecha_estreno') aria-describedby="error-fecha_estreno" @enderror
            >
            {{-- Dentro de la directiva @error, Laravel provee automáticamente una variable "$message" con el primer mensaje de error de ese campo. --}}
            @error('fecha_estreno')
            <div class="text-danger" id="error-fecha_estreno"><span class="visually-hidden">Error: </span> {{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea
                id="descripcion"
                name="descripcion"
                class="form-control"
            >{{ old('descripcion', $pelicula->descripcion) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="portada" class="form-label">Portada</label>
            <input
                type="file"
                id="portada"
                name="portada"
                class="form-control"
            >
        </div>
        <div class="mb-3">
            <label for="portada_descripcion" class="form-label">Descripción de la Portada</label>
            <input
                type="text"
                id="portada_descripcion"
                name="portada_descripcion"
                class="form-control"
                value="{{ old('portada_descripcion', $pelicula->portada_descripcion) }}"
            >
        </div>
        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>
@endsection
