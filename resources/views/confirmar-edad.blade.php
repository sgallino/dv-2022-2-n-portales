<?php
/** @var \App\Models\Pelicula $pelicula */
?>

@extends('layouts.main')

@section('title', 'Se necesita confirmar la mayoría de edad para continuar')

@section('main')
    <h1 class="mb-3">Confirmación necesaria</h1>

    <p class="mb-3">Para poder continuar a ver <b>{{ $pelicula->titulo }}</b> es necesario ser mayor de 18 años.</p>

    <form action="{{ route('confirmar-mayoria-edad.ejecutar', ['id' => $pelicula->pelicula_id]) }}" method="post">
        @csrf
        <a href="{{ route('admin.peliculas.listado') }}" class="btn btn-danger">No soy mayor de 18 años. ¡Sacame de acá!</a>
        <button type="submit" class="btn btn-primary">Sí, soy mayor de 18 años</button>
    </form>
@endsection
