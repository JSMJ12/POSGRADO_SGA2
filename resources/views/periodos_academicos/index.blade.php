@extends('adminlte::page')
@section('title', 'Periodos Academicos')
@section('content_header')
    <h1>Periodos Academicos</h1>
@stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            
                        </div>
                        <div class="col-md-4 text-right">
                            <button id="crearPeriodoModalBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarPeriodoModal">Crear Periodo Academico</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="periodos">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($periodos_academicos->count() > 0)
                                @foreach($periodos_academicos as $periodo_academico)
                                <tr data-bs-toggle="modal" data-bs-target="#editarPeriodoModal{{ $periodo_academico->id }}">
                                    <td>{{ $periodo_academico->id }}</td>
                                    <td>{{ $periodo_academico->nombre }}</td>
                                    <td>{{ $periodo_academico->isVigente() ? 'Vigente' : 'No vigente' }}</td>
                                    <td>{{ $periodo_academico->fecha_inicio }}</td>
                                    <td>{{ $periodo_academico->fecha_fin }}</td>
                                    <td>
                                        <form action="{{ route('periodos_academicos.destroy', $periodo_academico->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i> Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Modal Editar Periodo Academico -->
                                <div class="modal fade" id="editarPeriodoModal{{ $periodo_academico->id }}" tabindex="-1" aria-labelledby="editarPeriodoModal{{ $periodo_academico->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editarPeriodoModal{{ $periodo_academico->id }}Label">Editar Periodo Académico</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('periodos_academicos.update', $periodo_academico->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                
                                                    <div class="mb-3 row">
                                                        <label for="nombre" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ $periodo_academico->nombre }}" required autocomplete="nombre" autofocus>
                                                            @error('nombre')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                
                                                    <div class="mb-3 row">
                                                        <label for="fecha_inicio" class="col-md-4 col-form-label text-md-end">{{ __('Fecha de Inicio') }}</label>
                                                        <div class="col-md-8">
                                                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ optional($periodo_academico->fecha_inicio)->format('Y-m-d') }}">
                                                        </div>
                                                    </div>
                                
                                                    <div class="mb-3 row">
                                                        <label for="fecha_fin" class="col-md-4 col-form-label text-md-end">{{ __('Fecha de Fin') }}</label>
                                                        <div class="col-md-8">
                                                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ optional($periodo_academico->fecha_fin)->format('Y-m-d') }}">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3 row">
                                                        <div class="col-md-12 text-center">
                                                            <button type="submit" class="btn btn-primary">{{ __('Actualizar') }}</button>
                                                            <a href="{{ route('periodos_academicos.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @endforeach
                                @else
                                    <p>No hay periodos académicos disponibles.</p>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Periodo Academico -->
<div class="modal fade" id="crearPeriodoModal" tabindex="-1" aria-labelledby="crearPeriodoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearPeriodoModalLabel">Crear Periodo Academico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('periodos_academicos.store') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>

                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fecha_inicio" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Inicio') }}</label>
                    
                        <div class="col-md-6">
                            <input id="fecha_inicio" type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio"  required autocomplete="fecha_inicio">
                    
                            @error('fecha_inicio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="fecha_fin" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Fin') }}</label>
                    
                        <div class="col-md-6">
                            <input id="fecha_fin" type="date" class="form-control @error('fecha_fin') is-invalid @enderror" name="fecha_fin"  required autocomplete="fecha_fin">
                    
                            @error('fecha_fin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Guardar') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
    $('#periodos').DataTable({
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
<script>
    $(document).ready(function() {
        $('#crearPeriodoModalBtn').on('click', function() {
            $('#crearPeriodoModal').modal('show');
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#periodos tbody tr').on('click', function() {
            var modalId = $(this).data('bs-target');
            $(modalId).modal('show');
        });
    });
</script>
@stop