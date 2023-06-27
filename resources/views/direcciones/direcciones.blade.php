@extends('layout.app')

@section('titulo', 'Subneteo')

@section('contenido')
    <div class="col row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-5 mx-5 px-5">
        @foreach ($direcciones as $dir)
            <span>{{ join('.', $dir) }}</span>
        @endforeach
    </div>
@endsection
