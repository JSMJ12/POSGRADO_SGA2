@extends('adminlte::page')
@section('title', 'Docentes')
@section('content_header')
    <h1>Docentes</h1>
@stop
@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col-sm-6">
            <a href="{{ route('docentes.create') }}" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @if (isset($docentes))
            <div class="table-responsive">
                <table class="table table-bordered" id="docentes">
                    <thead>
                        <tr>
                            <th>Cédula / Pasaporte</th>
                            <th>Foto</th>
                            <th>Nombre completo</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Asignaturas</th>
                            <th>Cohortes</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($docentes as $docente)
                            <tr>
                                <td>{{ $docente->dni }}</td>
                                <td class="text-center">
                                    <img src="{{ asset($docente->image) }}" alt="Imagen de {{ $docente->name }}" style="max-width: 60px; border-radius: 50%;">
                                </td>
                                <td>{{ $docente->nombre1 }}<br>{{ $docente->nombre2 }}<br>{{ $docente->apellidop }}<br>{{ $docente->apellidom }}</td>
                                <td>{{ $docente->email }}</td>
                                <td>{{ $docente->tipo }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#asignaturasModal{{ $docente->dni }}" title="Ver Asignaturas">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#cohortesModal{{ $docente->dni }}" title="Ver Cohortes">
                                        <i class="fas fa-eye"></i>
                                    </button>                                
                                </td>                               
                                
                                <td style="width: 250px;">
                                    <div style="display: block; margin-bottom: 10px;">
                                        <div class="col-sm-6">
                                            <a href="{{ route('docentes.edit', $docente->dni) }}" class="btn btn-primary custom-btn btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="col-sm-6">
                                                <a href="{{ route('asignaturas_docentes.create1', $docente->dni) }}" class="btn btn-success custom-btn btn-sm" title="Agregar Asignaturas">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="col-sm-6">
                                            <a href="{{ url('/cohortes_docentes/create', $docente->dni) }}" class="btn btn-warning custom-btn btn-sm" title="Agregar Cohortes">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            
                                        </div>
                                    </div>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

@foreach ($docentes as $docente)
    <div class="modal fade" id="cohortesModal{{ $docente->dni }}" tabindex="-1" role="dialog" aria-labelledby="cohortesModalLabel{{ $docente->dni }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #28a745; color: white;">
                    <h5 class="modal-title" id="cohortesModalLabel{{ $docente->dni }}">Cohortes de {{ $docente->nombre1 }} {{ $docente->apellidop }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($docente->cohortes->isEmpty())
                        <div class="alert alert-info" role="alert">
                            No hay cohortes asignados a este docente.
                        </div>
                    @else
                        <form action="{{ route('guardarCambios') }}" method="POST">
                            @csrf
                            <input type="hidden" name="docente_dni" value="{{ $docente->dni }}">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Maestría</th>
                                            <th>Nombre del Cohorte</th>
                                            <th>Modalidad</th>
                                            <th>Aula</th>
                                            <th>Paralelo</th>
                                            <th>Asignaturas</th>
                                            <th>Estado</th>
                                            <th>Permiso de Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $shownCohortes = []; @endphp
                                        @foreach ($docente->cohortes as $cohorte)
                                            @if (!in_array($cohorte->id, $shownCohortes))
                                                @php $first = true; @endphp
                                                @foreach ($cohorte->asignaturas as $asignatura)
                                                    @if ($docente->asignaturas->contains($asignatura))
                                                        <tr>
                                                            @if ($first)
                                                                <td rowspan="{{ count($cohorte->asignaturas) }}">{{ $cohorte->maestria->nombre }}</td>
                                                                <td rowspan="{{ count($cohorte->asignaturas) }}">{{ $cohorte->nombre }}</td>
                                                                <td rowspan="{{ count($cohorte->asignaturas) }}">{{ $cohorte->modalidad }}</td>
                                                                @if ($cohorte->aula)
                                                                    <td rowspan="{{ count($cohorte->asignaturas) }}">{{ $cohorte->aula->nombre }}</td>
                                                                @else
                                                                    <td rowspan="{{ count($cohorte->asignaturas) }}">No disponible</td>
                                                                @endif
                                                                
                                                                @if ($cohorte->aula && $cohorte->aula->paralelo)
                                                                    <td rowspan="{{ count($cohorte->asignaturas) }}">{{ $cohorte->aula->paralelo->nombre }}</td>
                                                                @else
                                                                    <td rowspan="{{ count($cohorte->asignaturas) }}">No disponible</td>
                                                                @endif
                                                                
                                                                @php $first = false; @endphp
                                                            @endif
                                                            <td>{{ $asignatura->nombre }}</td>
                                                            <td>
                                                                <input type="hidden" name="asignatura_id[]" value="{{ $asignatura->id }}">
                                                                <input type="hidden" name="cohorte_id[]" value="{{ $cohorte->id }}">
                                                                @php
                                                                    $calificacion = $asignatura->calificacionVerificaciones()
                                                                        ->where('docente_dni', $docente->dni)
                                                                        ->where('cohorte_id', $cohorte->id)
                                                                        ->first();
                                                                    $calificado = $calificacion ? ($calificacion->calificado ? 'Calificado' : 'No calificado') : 'No calificado';
                                                                @endphp
                                                                {{ $calificado }}
                                                            </td>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input type="hidden" name="permiso_editar[{{ $docente->dni }}][{{ $asignatura->id }}][{{ $cohorte->id }}]" value="0">
                                                                    <input type="radio" id="permiso_editar_si_{{ $cohorte->id }}" name="permiso_editar[{{ $docente->dni }}][{{ $asignatura->id }}][{{ $cohorte->id }}]" value="1" class="form-check-input" {{ $calificacion && $calificacion->editar ? 'checked' : '' }}>
                                                                    <label for="permiso_editar_si_{{ $cohorte->id }}" class="form-check-label">Sí</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input type="radio" id="permiso_editar_no_{{ $cohorte->id }}" name="permiso_editar[{{ $docente->dni }}][{{ $asignatura->id }}][{{ $cohorte->id }}]" value="0" class="form-check-input" {{ !$calificacion || !$calificacion->editar ? 'checked' : '' }}>
                                                                    <label for="permiso_editar_no_{{ $cohorte->id }}" class="form-check-label">No</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                @php $shownCohortes[] = $cohorte->id; @endphp
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    @endif
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="asignaturasModal{{ $docente->dni }}" tabindex="-1" role="dialog" aria-labelledby="asignaturasModalLabel{{ $docente->dni }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #28a745; color: white;">
                    <h5 class="modal-title" id="asignaturasModalLabel{{ $docente->dni }}">Asignaturas de {{ $docente->nombre1 }} {{ $docente->apellidop }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($docente->asignaturas->isEmpty())
                        <div class="alert alert-info" role="alert">
                            No hay asignaturas asignadas a este docente.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Asignatura</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($docente->asignaturas as $asignatura)
                                        <tr>
                                            <td>{{ $asignatura->nombre }}</td>
                                            <td>
                                                <form action="{{ route('eliminar_asignatura', ['docente_dni' => $docente->dni, 'asignatura_id' => $asignatura->id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                
                
            </div>
        </div>
    </div>
    
@endforeach
@stop

@section('js')
<script>
    $('#docentes').DataTable({
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var nombreAsignatura = $(this).closest('tr').find('td:first').text().trim();

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminará la asignatura '" + nombreAsignatura + "'",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@stop