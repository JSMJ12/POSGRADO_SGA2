@extends('adminlte::page')
@section('title', 'Dashboard Docente')
@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container">
        @foreach ($data as $asignatura)
            <div class="card mb-4">
                <div class="card-header toggle-body" data-toggle="cohorte_{{ $loop->index }}">
                    <strong>{{ $asignatura['nombre'] }}</strong>
                </div>
                
                @foreach ($asignatura['cohortes'] as $cohorte)
                    <div class="card-header toggle-body" data-toggle="cohorte_{{ $loop->parent->index }}_{{ $loop->index }}">
                        <strong>{{ $cohorte['nombre'] }}  Aula:</strong> {{ $cohorte['aula'] }} <strong> Paralelo: </strong> {{ $cohorte['paralelo'] }} <strong> Fecha límite: </strong> {{$cohorte['fechaLimite']}}
                        <div class="float-right" id="botones">
                            <a href="{{ $cohorte['excelUrl'] }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-excel"></i> Lista de Alumnos
                            </a>
                            @php
                                
                                $editar = false;
                                $calificacionVerificacion = DB::table('calificacion_verificacion')
                                    ->where('docente_dni', $cohorte['docenteId'])
                                    ->where('asignatura_id', $cohorte['asignaturaId'])
                                    ->where('cohorte_id', $cohorte['cohorteId'])
                                    ->first();

                                if ($calificacionVerificacion) {
                                    $editar = $calificacionVerificacion->editar;
                                }
                            @endphp
                            @if ($editar || ($cohorte['fechaLimite'] >= now() && auth()->user()->can('calificar') && $cohorte['pdfNotasUrl'] == null))
                                <a href="{{ $cohorte['calificarUrl'] }}" class="btn btn-primary btn-sm" id="btnCalificar">Calificar</a>
                            @endif
                        
                            @if ($notasExisten && $cohorte['pdfNotasUrl'] !== null)
                                <a href="{{ $cohorte['pdfNotasUrl'] }}" class="btn btn-danger btn-sm" id="btnPdfNotas" target="_blank">
                                    <i class="fas fa-file-pdf"></i> PDF de Notas
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body" id="cohorte_{{ $loop->parent->index }}_{{ $loop->index }}" style="display: none;">
                        <table class="table" id="docente">
                            <thead>
                                <tr>
                                    <th>Nombre Completo</th>
                                    <th>Calificar / Ver Notas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($cohorte['alumnos']))
                                    @foreach ($cohorte['alumnos'] as $alumno)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($alumno['imagen']) }}" alt="Imagen del alumno" class="img-thumbnail rounded-circle mr-3" style="width: 80px;">
                                                    <div>
                                                        <p class="mb-0 font-weight-bold">{{ $alumno['nombreCompleto'] }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ( $cohorte['pdfNotasUrl'] !== null)
                                                    <a href="{{ $alumno['verNotasUrl'] }}">Ver Notas</a>
                                                @else
                                                    <a href="{{ $cohorte['calificarUrl'] }}" class="btn btn-primary btn-sm" id="btnCalificar">Calificar</a>
                                                @endif
                                            
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No hay alumnos en este cohorte.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
            @if ($notasExisten)
                <script>
                    $(document).ready(function(){
                        $('#btnPdfNotas_{{ $loop->index }}').show();
                    });
                </script>
            @endif
        @endforeach
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function(){
            $(".toggle-body").click(function(){
                var target = $(this).data('toggle');
                $("#" + target).toggle();
            });
        });
    </script>
@stop
