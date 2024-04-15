@extends('adminlte::page')

@section('title', 'Aulas')

@section('content_header')
    <h1>Aulas</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6 text-end">
                    <button id="crearAulaBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearAulaModal">Crear Aula</button>
                </div>
                <div class="col-6 text-end">
                    <button class="btn btn-primary" id="crearParaleloBtn"><i class="fas fa-plus"></i>Crear Paralelo</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="aulas">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Piso</th>
                            <th>Código</th>
                            <th>Paralelo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aulas as $aula)
                            <tr data-bs-toggle="modal" data-bs-target="#editarAulaModal-{{ $aula->id }}">
                                <td>{{ $aula->id }}</td>
                                <td>{{ $aula->nombre }}</td>
                                <td>{{ $aula->piso }}</td>
                                <td>{{ $aula->codigo }}</td>
                                <td>{{ $aula->paralelo->nombre }}</td>
                                <td>
                                    <form action="{{ route('aulas.destroy', $aula->id) }}" method="POST" style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta aula?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- Modal Editar Aula -->
                            <div class="modal fade" id="editarAulaModal-{{ $aula->id }}" tabindex="-1" aria-labelledby="editarAulaModalLabel-{{ $aula->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editarAulaModalLabel-{{ $aula->id }}">Editar Aula</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('aulas.update', $aula->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $aula->nombre }}">
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="piso" class="form-label">Piso</label>
                                                    <input type="text" class="form-control" id="piso" name="piso" value="{{ $aula->piso }}">
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="codigo" class="form-label">Código</label>
                                                    <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $aula->codigo }}">
                                                </div>
                                            
                                                <div class="mb-3">
                                                    <label for="paralelos_id" class="form-label">Paralelo</label>
                                                    <select class="form-control" id="paralelos_id" name="paralelos_id">
                                                        @foreach ($paralelos as $paralelo)
                                                            <option value="{{ $paralelo->id }}" @if ($aula->paralelos_id == $paralelo->id) selected @endif>{{ $paralelo->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal Crear Paralelo -->
<div class="modal fade" id="crearParaleloModal" tabindex="-1" aria-labelledby="crearParaleloModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearParaleloModalLabel">Crear Paralelo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('paralelos.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="paralelo-nombre">Nombre:</label>
                        <input type="text" class="form-control" id="paralelo-nombre" name="nombre" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Crear Aula -->
<div class="modal fade" id="crearAulaModal" tabindex="-1" aria-labelledby="crearAulaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearAulaModalLabel">Crear Aula</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('aulas.store') }}" method="POST">
                    @csrf
        
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="piso" class="form-label">Piso</label>
                        <input type="text" class="form-control" id="piso" name="piso" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="paralelos_id" class="form-label">Paralelo</label>
                        <select class="form-control" id="paralelos_id" name="paralelos_id" required>
                            <option value="" selected disabled>Seleccione un paralelo</option>
                            @foreach ($paralelos as $paralelo)
                                <option value="{{ $paralelo->id }}">{{ $paralelo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script>
 
    $('#aulas').DataTable({
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

    $('#crearParaleloBtn').click(function() {
        $('#crearParaleloModal').modal('show');
    });

</script>
<script>
    $(document).ready(function() {
        $('#crearAulaBtn').on('click', function() {
            $('#crearAulaModal').modal('show');
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#aulas').on('click', 'tbody tr', function() {
            var targetModal = $(this).data('bs-target');
            $(targetModal).modal('show');
        });
    });
</script>

@stop