@extends('adminlte::page')
@section('title', 'Cohortes')
@section('content_header')
    <h1>Cohortes</h1>
@stop
@section('content')
<div class="container">

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col">
                    <a href="{{ route('cohortes.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear Cohorte</a>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="cohortes">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Maestría</th>
                                    <th>Periodo Académico</th>
                                    <th>Aula</th>
                                    <th>Aforo</th>
                                    <th>Modalidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cohortes as $cohorte)
                                    <tr>
                                        <td>{{ $cohorte->id }}</td>
                                        <td>{{ $cohorte->nombre }}</td>
                                        <td>{{ $cohorte->maestria->nombre }}</td>
                                        <td>{{ $cohorte->periodo_academico->nombre }}</td>
                                        <td>{{ $cohorte->aula->nombre }}</td>
                                        <td>{{ $cohorte->aforo }}</td>
                                        <td>{{ $cohorte->modalidad }}</td>
                                        <td>
                                            <a href="{{ route('cohortes.edit', $cohorte->id) }}" class="btn btn-outline-primary btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('cohortes.destroy', $cohorte) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
    $('#cohortes').DataTable({
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
