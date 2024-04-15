@extends('adminlte::page')
@section('title', 'Secretarios')
@section('content_header')
    <h1>Secretarios</h1>
@stop

@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col-sm-6">
            <a href="{{ route('secretarios.create') }}" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                @if (isset($secretarios))
                    <table class="table table-bordered" id="secretarios">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nombres</th>
                                <th>Email</th>
                                <th>Seccion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($secretarios as $secretario)
                                <tr>
                                    <td>{{ $secretario->id }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset($secretario->image) }}" alt="Imagen de {{ $secretario->name1 }}" style="max-width: 60px; border-radius: 50%;">
                                    </td>
                                    <td>
                                        {{ $secretario->apellidop }}<br>
                                        {{ $secretario->apellidom }}<br>
                                        {{ $secretario->nombre1 }}<br>
                                        {{ $secretario->nombre2 }}
                                    </td>
                                    <td>{{ $secretario->email }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mostrarSeccionModal_{{ $secretario->seccion->id }}" title="Mostrar Sección">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editarSeccionModal_{{ $secretario->seccion->id }}" title="Editar Seccion">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="{{ route('secretarios.edit', $secretario->id) }}" class="btn btn-primary" title="Editar Secretario">
                                            <i class="fas fa-edit"></i>
                                        </a>                            
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

@if (isset($secretarios))
    <!-- Modales fuera del bucle -->
    @foreach ($secretarios as $secretario)
        <div class="modal fade" id="mostrarSeccionModal_{{ $secretario->seccion->id }}" tabindex="-1" role="dialog" aria-labelledby="mostrarSeccionModalLabel_{{ $secretario->seccion->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #28a745; color: white;">
                        <h5 class="modal-title" id="mostrarSeccionModalLabel_{{ $secretario->seccion->id }}">Información de la Sección</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal para mostrar la sección -->
                        <p><strong>Nombre de la sección:</strong> {{ $secretario->seccion->nombre }}</p>
                        <p><strong>Maestrías asociadas:</strong></p>
                        <ul>
                            @foreach ($secretario->seccion->maestrias as $maestria)
                                <li>{{ $maestria->nombre }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editarSeccionModal_{{ $secretario->seccion->id }}" tabindex="-1" role="dialog" aria-labelledby="editarSeccionModalLabel_{{ $secretario->seccion->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #28a745; color: white;">
                        <h5 class="modal-title" id="editarSeccionModalLabel_{{ $secretario->seccion->id }}">Editar Sección</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('secciones.update', $secretario->seccion->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nombre">Nombre de la sección:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $secretario->seccion->nombre }}" required>
                            </div>
                            <div class="form-group">
                                <label for="maestrias">Maestrías asociadas:</label>
                                @foreach ($maestrias as $maestria)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="maestria_{{ $secretario->id }}_{{ $maestria->id }}" name="maestrias[]" value="{{ $maestria->id }}" {{ in_array($maestria->id, $secretario->seccion->maestrias->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="maestria_{{ $secretario->id }}_{{ $maestria->id }}">{{ $maestria->nombre }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#secretarios').DataTable({
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
    });
</script>
@stop