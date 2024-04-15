@extends('adminlte::page')
@section('title', 'Matriculas')
@section('content_header')
    <h1>Matriculación</h1>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        @if ($cohortes->isEmpty())
            <div class="alert alert-info">
                No hay cohortes activos disponibles para matriculación.
            </div>
        @else
            @foreach($cohortes as $cohorte)
                <h4>{{ $cohorte->maestria->nombre }} {{ $cohorte->nombre }} - Paralelo: {{ $cohorte->aula->paralelo->nombre }} - Periodo Academico: {{ $cohorte->periodo_academico->nombre }}  {{ $cohorte->periodo_academico->status }}</h4>
                @if ($cohorte->asignaturas->isEmpty())
                    <div class="alert alert-warning">
                        No se han asignado docentes ni asignaturas para este cohorte.
                    </div>
                @else
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Docente</th>
                                <th>Asignaturas</th>
                                <th>Aforo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cohorte->asignaturas as $asignatura)
                                @if ($asignatura->docentes->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center">No hay docentes asignados a esta asignatura.</td>
                                    </tr>
                                @else
                                    @foreach($asignatura->docentes as $docente)
                                        <tr>
                                            <td>{{ $docente->nombre1 }} {{ $docente->nombre2 }} {{ $docente->apellidop }} {{ $docente->apellidom }}</td>
                                            <td>{{ $asignatura->nombre }}</td>
                                            <td>{{ $cohorte->aforo }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <form method="POST" action="{{ route('matriculas.store') }}">
                        @csrf
                        <input type="hidden" name="alumno_dni" value="{{ $alumno->dni }}">
                        <input type="hidden" name="cohorte_id" value="{{ $cohorte->id }}">
                        @foreach($cohorte->asignaturas as $asignatura)
                            @foreach($asignatura->docentes as $docente)
                                <input type="hidden" name="asignatura_ids[]" value="{{ $asignatura->id }}">
                                <input type="hidden" name="docente_dnis[]" value="{{ $docente->dni }}">
                            @endforeach
                        @endforeach
                        <div class="mb-3"> 
                            <button type="submit" class="btn btn-sm btn-primary"> 
                                <i class="fas fa-graduation-cap"></i> Matricular
                            </button>
                        </div>                
                    </form>
                @endif
            @endforeach
        @endif
    </div>
</div>
@stop
