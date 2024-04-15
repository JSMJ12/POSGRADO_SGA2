@extends('adminlte::page')
@section('title', 'Alumnos')

@section('content_header')
    <h1>Alumnos</h1>
@stop
@section('css')


@stop

@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col-sm-6">
            <a href="{{ route('alumnos.create') }}" class="btn btn-primary float-left">
                <i class="fas fa-plus"></i> Agregar nuevo
            </a>
        </div>
    </div>
    @if(session('error'))
        <div class="row mb-2">
            <div class="col-sm-12">
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: '{{ session('error') }}',
                    });
                </script>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id='alumnos'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Foto</th>
                                    <th>Nombre Completo</th>
                                    <th>DNI</th>
                                    <th>Maestria</th>
                                    <th>Email Institucional</th>
                                    <th>Sexo</th>
                                    <th>Matriculas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumnos as $alumno)
                                <tr>
                                    <td>{{ $alumno->dni }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset($alumno->image) }}" alt="Imagen de {{ $alumno->name }}" style="max-width: 60px; border-radius: 50%;">
                                    </td>
                                    <td>
                                        {{ $alumno->nombre1 }}<br>
                                        {{ $alumno->nombre2 }}<br>
                                        {{ $alumno->apellidop }}<br>
                                        {{ $alumno->apellidom }}
                                    </td>
                                    <td>{{ $alumno->dni }}</td>
                                    <td>{{ $alumno->maestria->nombre }}</td>
                                    <td>{{ $alumno->email_institucional }}</td>
                                    <td>{{ $alumno->sexo }}</td>
                                    <td>
                                        <!-- Botón para abrir el modal -->
                                        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#matriculasModal{{ $alumno->dni }}" title="Ver Matrícula">
                                            <i class="fas fa-eye"></i> <!-- Icono de ojo -->
                                        </button>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column align-items-center text-center">
                                            @can('dashboard_admin')
                                                <div class="mb-2">
                                                    <a href="{{ route('alumnos.edit', $alumno->dni) }}" class="btn btn-outline-primary btn-sm" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            @endcan
                                    
                                            <div class="d-flex flex-row">
                                                @if ($alumno->maestria->cohorte->count() > 0)
                                                    <div class="mr-2">
                                                        @php
                                                            $alumnoDNI = $alumno->dni;
                                                        @endphp
                                                        <a href="{{ url('/matriculas/create', $alumnoDNI) }}" class="btn btn-outline-success btn-sm" title="Matricular">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                    
                                                <div class="align-self-center mb-2">
                                                    @if ($alumno->notas->count() > 0 && $alumno->maestria->asignaturas->count() > 0 && $alumno->notas->count() == $alumno->maestria->asignaturas->count())
                                                        <a href="{{ route('record.show', $alumno->dni) }}" class="btn btn-outline-warning btn-sm" title="Record Académico">
                                                            <i class="fas fa-file-alt"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                    
                                                @if ($alumno->notas->count() > 0 && $alumno->maestria->asignaturas->count() > 0 && $alumno->notas->count() == $alumno->maestria->asignaturas->count())
                                                    <div class="ml-2">
                                                        <a href="#" class="btn btn-outline-danger btn-sm" title="Titulación">
                                                            <!-- Agrega aquí el icono adecuado para la titulación -->
                                                            <i class="fas fa-graduation-cap"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                    
                                            @can('dashboard_admin')
                                                <div class="mt-2">
                                                    @php
                                                        $alumnoDNI = $alumno->dni;
                                                    @endphp
                                                    <a href="{{ url('/notas/create', $alumnoDNI) }}" class="btn btn-outline-info btn-sm" title="Calificar">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                </div>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</div>

<!-- Modales para mostrar información de matrículas -->
@foreach ($alumnos as $alumno)
    <div class="modal fade" id="matriculasModal{{ $alumno->dni }}" tabindex="-1" role="dialog" aria-labelledby="matriculasModalLabel{{ $alumno->dni }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0e4439; color: white;">
                    <h5 class="modal-title" id="matriculasModalLabel{{ $alumno->dni }}">Matrículas de {{ $alumno->nombre1 }} {{ $alumno->apellidop }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white;">&times;</span> <!-- Color rojo para el botón de cerrar -->
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Asignatura</th>
                                <th>Docente</th>
                                <th>Cohorte</th>
                                <th>Aula</th>
                                <th>Paralelo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumno->matriculas as $matricula)
                                <tr>
                                    <td>{{ $matricula->asignatura->nombre }}</td>
                                    <td>{{ $matricula->docente ? $matricula->docente->nombre1 : 'Nombre no disponible' }} {{ $matricula->docente ? $matricula->docente->apellidop : 'Apellido Paterno no disponible' }} {{ $matricula->docente ? $matricula->docente->apellido2 : 'Apellido Materno no disponible' }}</td>
                                    <td>{{ $matricula->cohorte->nombre }}</td>
                                    <td>{{ $matricula->cohorte->aula->nombre }}</td>
                                    <td>{{ $matricula->cohorte->aula->paralelo->nombre }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button> <!-- Cambio de color a rojo para el botón de cerrar -->
                </div>
            </div>
        </div>
    </div>
@endforeach

@stop

@section('js')
<script>
$('#alumnos').DataTable({
    paging: true, // Asegúrate de que la paginación esté habilitada
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
