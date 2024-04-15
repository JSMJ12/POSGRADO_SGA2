@extends('adminlte::page')
@section('title', 'Secciones')
@section('content_header')
    <h1>Secciones</h1>
@stop
@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-4">
            <a href="{{ route('secciones.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Crear Sección</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="secciones">
                            <thead class="">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Maestrías</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($secciones as $seccion)
                                    <tr>
                                        <td>{{ $seccion->id }}</td>
                                        <td>{{ $seccion->nombre }}</td>
                                        <td>
                                            <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#maestriasModal{{ $seccion->id }}">
                                                Ver Maestrías
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="maestriasModal{{ $seccion->id }}" tabindex="-1" role="dialog" aria-labelledby="maestriasModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="maestriasModalLabel">Maestrías de {{ $seccion->nombre }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @foreach ($seccion->maestrias as $maestria)
                                                                {{ $maestria->nombre }}
                                                                @if (!$loop->last)
                                                                    ,
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('secciones.edit', $seccion) }}" class="btn btn-outline-primary btn-sm mr-2" title="Editar Sección">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('secciones.destroy', $seccion) }}" method="POST" onsubmit="return confirm('¿Está seguro de que desea eliminar esta sección?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar Sección">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
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
@stop
@section('js')
<script>
    $('#secciones').DataTable({
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