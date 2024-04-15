@extends('adminlte::page')
@section('title', 'Crear Nota')
@section('content_header')
    <h1>Calificar a {{ $alumno->nombre1 }} {{ $alumno->nombre2 }} {{ $alumno->apellidop }} {{ $alumno->apellidom }}</h1>
@stop
@section('content')
<form action="{{ route('notas.store') }}" method="POST">
    @csrf

    <input type="hidden" name="alumno_dni" value="{{ $alumno->dni }}">

    <table>
        <thead>
            <tr>
                <th>Asignatura</th>
                <th>|</th>
                <th>Nota Actividades</th>
                <th>Nota Prácticas</th>
                <th>Nota Autónomo</th>
                <th>Examen Final</th>
                <th>Recuperación</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asignaturas as $asignatura)
                <tr>
                    <td>{{ $asignatura->nombre }}</td>
                    <input type="hidden" name="asignatura_id" value="{{ $asignatura->id }}">
                    <td>|</td> <!-- celda vacía para separar -->
                    <td>
                        <input type="number" step="0.01" name="nota_actividades[{{ $asignatura->id }}]" max="3.0" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="nota_practicas[{{ $asignatura->id }}]" max="3.0" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="nota_autonomo[{{ $asignatura->id }}]" max="3.0" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="examen_final[{{ $asignatura->id }}]" max="3.0" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="recuperacion[{{ $asignatura->id }}]" max="3.0">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="total[{{ $asignatura->id }}]" max="10" required>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Agregar</button>
</form>

@stop