@extends('adminlte::page')
@section('title', 'Notas')
@section('content_header')
    <h1>Notas</h1>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        <div class="container">
            <div class="table-responsive">
                @if (count($notas) > 0)
                    <table class="table table-bordered" id="notas">
                        <thead>
                            <tr>
                                <th>Asignatura</th>
                                <th>Aula</th>
                                <th>Paralelo</th>
                                <th>Periodo</th>
                                <th>Cohorte</th>
                                <th>Docente</th>
                                <th>Alumno</th>
                                <th>DNI</th>
                                <th>Actividades de Aprendizaje (2,5)</th>
                                <th>
                                    Componentes de 
                                    Prácticas de Aplicacion
                                    y Experimentacion (2,5)
                                </th>
                                <th>
                                    Componente de 
                                    Aprendizaje Autónomo
                                    (2,5)
                                </th>
                                <th>Examen Final (2,5)</th>
                                <th>Recuperación</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notas as $nota)
                                <tr>
                                    <td>{{ $nota->asignatura->nombre }}</td>
                                    <td>{{ $nota->cohorte->aula->nombre }}</td>
                                    <td>{{ $nota->cohorte->aula->paralelo->nombre }}</td>
                                    <td>{{ $nota->cohorte->periodo_academico->nombre }}</td>
                                    <td>{{ $nota->cohorte->nombre }}</td>
                                    <td>
                                        {{ $nota->docente->nombre1 }}<br>
                                        {{ $nota->docente->nombre2 }}<br>
                                        {{ $nota->docente->apellidop }}<br>
                                    </td>
                                    <td>
                                        {{ $nota->alumno->nombre1 }}<br>
                                        {{ $nota->alumno->nombre2 }}<br>
                                        {{ $nota->alumno->apellidop }}<br>
                                    </td>
                                    <td>{{ $nota->alumno->dni }}</td>
                                    <td>{{ $nota->nota_actividades }}</td>
                                    <td>{{ $nota->nota_practicas }}</td>
                                    <td>{{ $nota->nota_autonomo }}</td>
                                    <td>{{ $nota->examen_final }}</td>
                                    <td>{{ $nota->recuperacion }}</td>
                                    <td>{{ $nota->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No hay notas registradas</p>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $('#notas').DataTable({
        lengthMenu: [5, 10, 15, 20, 40, 45, 50, 100], 
        pageLength: {{ $perPage }},
        responsive: true, 
        colReorder: true,
        keys: true,
        autoFill: true, 
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
    });
</script>
@stop