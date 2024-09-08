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
                            <table class="table table-bordered table-striped" id="maestrias">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Coordinador</th>
                                        <th>Asignaturas</th>
                                        <th>Precios</th>
                                        <th></th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($maestrias as $maestria)
                                        @include('modales.editar_maestria_modal')
                                        @include('modales.anadir_asignatura_modal')
                                        <tr>
                                            <td>{{ $maestria->id }}</td>
                                            <td>{{ $maestria->nombre }}</td>
                                            <td>
                                                @foreach($docentes as $docente)
                                                    @if($docente->dni === $maestria->coordinador)
                                                        {{ $docente->nombre1 }} {{ $docente->nombre2 }} {{ $docente->apellidop }} {{ $docente->apellidom }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <ul>
                                                    @if ($maestria->asignaturas->count() > 0)
                                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#asignaturasModal{{ $maestria->id }}" title="Ver Asignaturas">
                                                            <i class="fas fa-book"></i>
                                                        </button>
                                                        @include('modales.mostrar_asignaturas_modal')
                                                    @else
                                                        <li>No hay asignaturas</li>
                                                    @endif
                                                </ul>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>Matricula: </strong> ${{ $maestria->matricula }}<br>
                                                    <strong>Arancel:</strong> ${{ $maestria->arancel }}<br>
                                                    <strong>Inscripción:</strong> ${{ $maestria->inscripcion }}
                                                </div>
                                            </td>
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

    @include('modales.crear_maestria_modal')

@stop
@section('js')
<script>
    $(document).ready(function () {
        $('#maestrias').DataTable({
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
    }

    .asignatura-item:hover {
        color: #28B463;
    }
</style>

@stop
