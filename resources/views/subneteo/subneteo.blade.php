@extends('layout.app')

@section('titulo', 'Subneteo')

@section('contenido')
    <div class="col row row-cols-2">
        <div class="col p-1">
            <div class="col h-100 border border-dark rounded p-3">
                <h6>Paso 1</h6>

                <label class="col-12">Dirección IP: {{ join('.', $direccion) }} / {{ $indice * 8 }}</label>
                <label class="col-12">Submáscara: {{ join('.', $submascara) }}</label>
                <label class="col-12">Subredes: {{ $subredes }}</label>
            </div>
        </div>
        <div class="col p-1">
            <div class="col h-100 border border-dark rounded p-3">
                <h6>Paso 2</h6>

                <label class="col-12">2<sup>n</sup> - 2 &ge; {{ $subredes }}</label>
                <label class="col-12">2<sup>{{ $n }}</sup> - 2 &ge; {{ $subredes }}</label>
                <label class="col-12">{{ $r }} &ge; {{ $subredes }}</label>
                <label class="col-12">n = {{ $n }}</label>
            </div>
        </div>
        <div class="col p-1">
            <div class="col h-100 border border-dark rounded p-3">
                <h6>Paso 3</h6>

                <label class="col-12">
                    {{ join('.', array_slice($submascara, 0, $indice)) }}
                    @for ($i = $indice * 8; $i < 32; $i++)
                        {{ $i % 8 == 0 ? '.' : '' }}

                        @if ($i == $indice * 8)
                            <del>
                            @elseif ($i == $indice * 8 + $n)
                            </del>
                        @endif

                        0
                    @endfor
                </label>
                <label class="col-12">{{ join('.', array_replace($submascara, [$indice => $subOcteto])) }}</label>
                <label class="col-12">Submáscara de red: {{ join('.', array_replace($submascara, [$indice => $subOcteto])) }}</label>
            </div>
        </div>
        <div class="col p-1">
            <div class="col h-100 border border-dark rounded p-3">
                <h6>Paso 4</h6>

                <label class="col-12">256 - {{ $subOcteto }} = {{ $salto }}</label>
                <label class="col-12">Salto de red: {{ $salto }}</label>
            </div>
        </div>
        <div class="col p-1">
            <div class="col h-100 border border-dark rounded p-3">
                <h6>Paso 5</h6>

                <label class="col-12">2<sup>m</sup> - 2 = 2<sup>{{ $m }}</sup> - 2 = {{ pow(2, $m) - 2 }}</label>
            </div>
        </div>
    </div>

    <table class="table table-striped table-hover mt-5">
        <thead>
            <tr>
                <th>Subred</th>
                <th>IP de Red</th>
                <th>Primera Útil</th>
                <th>Última Útil</th>
                <th>IP Broadcast</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datosDirecciones as $subred => $dir)
                <tr>
                    <td>{{ $subred }}</td>
                    <td>{{ join('.', $dir['Red']) }}</td>
                    <td>{{ join('.', $dir['PrimeraUtil']) }}</td>
                    <td>{{ join('.', $dir['UltimaUtil']) }}</td>
                    <td>{{ join('.', $dir['Broadcast']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
