@extends('adminlte::page')
@section('title', 'Usuarios')
@section('content_header')
    <h1>Usuarios</h1>
@stop
@section('css')
    <style>
        .send-message {
            cursor: pointer;
        }
    </style>
@stop


@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col-sm-6">
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Agregar nuevo</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="usuarios">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            @can('admin.usuarios.disable')
                                <th>Estatus</th>
                                <th>Roles</th>
                                <th>Acciones</th>
                            @endcan
                            <th>Mensajería</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>   
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#usuarios').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('usuarios.index') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'foto', name: 'foto', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'apellido', name: 'apellido' },
                { data: 'email', name: 'email' },
                @can('admin.usuarios.disable')
                    { data: 'status', name: 'status' },
                    { data: 'roles', name: 'roles' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                @endcan
                { data: 'mensajeria', name: 'mensajeria', orderable: false, searchable: false }
            ],
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
 