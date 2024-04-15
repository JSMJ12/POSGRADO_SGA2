@extends('adminlte::page')
@section('title', 'Maestrias')
@section('content_header')
    <h1>Maestrias</h1>
@stop
@section('content')
    <div class="container">
        <div class="mb-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createMaestriaModal">
                <i class="fas fa-plus"></i> Nueva Maestria
            </button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="maestrias">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Coordinador</th>
                                        <th>Asignaturas</th>
                                        <th>Precio</th>
                                        <th>Fecha Inicio - Fin</th>
                                        <th></th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($maestrias as $maestria)
                                    <div class="modal fade" id="editMaestriaModal{{ $maestria->id }}" tabindex="-1" role="dialog" aria-labelledby="editMaestriaModalLabel{{ $maestria->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editMaestriaModalLabel{{ $maestria->id }}">Editar Maestria</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('maestrias.update', $maestria) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="maestria-nombre">Nombre:</label>
                                                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $maestria->nombre }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="coordinador">Coordinador:</label>
                                                            <input type="text" class="form-control" id="coordinador" name="coordinador" value="{{ $maestria->coordinador }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="precio_total">Precio Total:</label>
                                                            <input type="number" class="form-control" id="precio_total" name="precio_total" value="{{ $maestria->precio_total }}" required step="0.01" min="0">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fecha_inicio">Fecha de Inicio:</label>
                                                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $maestria->fecha_inicio }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fecha_fin">Fecha de Fin:</label>
                                                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ $maestria->fecha_fin }}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="addAsignaturaModal{{ $maestria->id }}" tabindex="-1" role="dialog" aria-labelledby="addAsignaturaModalLabel{{ $maestria->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addAsignaturaModalLabel{{ $maestria->id }}">Crear Asignatura</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('asignaturas.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="nombre">Nombre:</label>
                                                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="codigo_asignatura">Código de Asignatura:</label>
                                                            <input type="text" class="form-control" id="codigo_asignatura" name="codigo_asignatura" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="credito">Crédito:</label>
                                                            <input type="number" class="form-control" id="credito" name="credito" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="itinerario">Itinerario:</label>
                                                            <input type="text" class="form-control" id="itinerario" name="itinerario">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="itinerario">Unidad Curricular:</label>
                                                            <input type="text" class="form-control" id="unidad_curricular" name="unidad_curricular">
                                                        </div>
                                                        <input type="hidden" name="maestria_id" value="{{ $maestria->id }}">
                                                        <button type="submit" class="btn btn-primary">Agregar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <tr>
                                        <td>{{ $maestria->id }}</td>
                                        <td>{{ $maestria->nombre }}</td>
                                        <td>{{ $maestria->coordinador }}</td>
                                        <td>
                                            <ul>
                                                @if ($maestria->asignaturas->count() > 0)
                                                    @foreach($maestria->asignaturas as $asignatura)
                                                        <li class="asignatura-item" style="text-decoration: none;" data-toggle="modal" data-target="#editAsignaturaModal{{ $asignatura->id }}" data-asignatura="{{ $asignatura }}">{{ $asignatura->nombre }}</li>
                                                        <div class="modal fade" id="editAsignaturaModal{{ $asignatura->id }}" tabindex="-1" role="dialog" aria-labelledby="editAsignaturaModalLabel{{ $asignatura->id }}" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editAsignaturaModalLabel{{ $asignatura->id }}">Editar Asignatura</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="POST" action="{{ route('asignaturas.update', $asignatura->id) }}" enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="maestria_id" value="{{ $maestria->id }}">
                                                                            <div class="form-group">
                                                                                <label for="nombre">Nombre:</label>
                                                                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $asignatura->nombre) }}" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="codigo_asignatura">Código de asignatura:</label>
                                                                                <input type="text" class="form-control" id="codigo_asignatura" name="codigo_asignatura" value="{{ old('codigo_asignatura', $asignatura->codigo_asignatura) }}" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="credito">Crédito:</label>
                                                                                <input type="number" class="form-control" id="credito" name="credito" value="{{ old('credito', $asignatura->credito) }}" required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="itinerario">Itinerario:</label>
                                                                                <input type="text" class="form-control" id="itinerario" name="itinerario" value="{{ old('itinerario', $asignatura->itinerario) }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="itinerario">Unidad Curricular:</label>
                                                                                <input type="text" class="form-control" id="unidad_curricular" name="unidad_curricular" value="{{ old('unidad_curricular', $asignatura->itinerario) }}">
                                                                            </div>
                                                                            <button type="submit" class="btn btn-sm btn-primary float-left">Guardar cambios</button>
                                                                        </form>
                                                                        <form action="{{ route('asignaturas.destroy', $asignatura->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-danger float-right" style="margin-left: 5px" onclick="confirmDelete(this.form)">{{ __('Eliminar') }}</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <li>No hay asignaturas</li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td>{{ $maestria->precio_total }}</td>
                                        <td>{{ $maestria->fecha_inicio }} - {{ $maestria->fecha_fin }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addAsignaturaModal{{ $maestria->id }}" title="Agregar Asignatura">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 10px;">
                                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editMaestriaModal{{ $maestria->id }}" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                        
                                                @if ($maestria->status == 'ACTIVO')
                                                    <form action="{{ route('maestrias.disable', $maestria->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Deshabilitar">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('maestrias.enable', $maestria->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-success" title="Reactivar">
                                                            <i class="fas fa-check-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif
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


    <div class="modal fade" id="createMaestriaModal" tabindex="-1" role="dialog" aria-labelledby="createMaestriaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMaestriaModalLabel">Crear Maestria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('maestrias.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="maestria-nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="coordinador">Coordinador:</label>
                            <input type="text" class="form-control" id="coordinador" name="coordinador">
                        </div>
                        <div class="form-group">
                            <label for="precio_total">Precio Total:</label>
                            <input type="number" class="form-control" id="precio_total" name="precio_total" step="0.01" min="0">
                        </div>
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de Inicio:</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de Fin:</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
<script>
    $(document).ready(function () {
    $('#maestrias').DataTable({
        lengthMenu: [5, 10, 15, 20, 40, 45, 50, 100], // Set the options for the dropdown
        pageLength: {{ $perPage }},
        responsive: true, 
        colReorder: true,
        keys: true,
        autoFill: true, // Asegúrate de tener una coma aquí
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
    });
});

</script>
<script>
    $(document).ready(function () {
        $('#createMaestriaModal').on('hidden.bs.modal', function () {
            // Restablecer el formulario cuando el modal se cierra
            $(this).find('form').trigger('reset');
        });
    });
</script>
@foreach($maestrias as $maestria)
    @if($maestria->asignaturas->count() > 0)
        <script>
            $(document).ready(function () {
                $('#editMaestriaModal{{ $maestria->id }}').on('hidden.bs.modal', function () {
                    // Restablecer el formulario cuando el modal se cierra
                    $(this).find('form').trigger('reset');
                });
            });
        </script>
    @endif
@endforeach
<script>
    $(document).ready(function() {
        // Abrir el modal al hacer clic en el botón "Agregar Asignatura"
        $('.btn-agregar-asignatura').click(function() {
            var maestriaId = $(this).data('maestria-id');
            $('#addAsignaturaModal' + maestriaId).modal('show');
        });

        // Cerrar el modal al hacer clic en el botón "Cerrar"
        $('.btn-cerrar-modal').click(function() {
            var maestriaId = $(this).data('maestria-id');
            $('#addAsignaturaModal' + maestriaId).modal('hide');
        });

        // Cerrar el modal al hacer clic en el botón "Cancelar" o al hacer clic fuera del modal
        $('.modal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.asignatura-item').on('click', function() {
            var asignatura = $(this).data('asignatura');
            var modalId = '#editAsignaturaModal' + asignatura.id;
            $(modalId).modal('show');
        });
    });
</script>

@stop
@section("css")
<style>
    .asignatura-item {
        cursor: pointer;
        text-decoration: underline;
    }

    .asignatura-item:hover {
        color: #28B463;
    }
</style>

@stop