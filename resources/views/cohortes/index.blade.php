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
                                    <th>Inicio / Fin</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cohortes as $cohorte)
                                    <tr>
                                        <td>{{ $cohorte->id }}</td>
                                        <td>{{ $cohorte->nombre }}</td>
                                        <td>{{ $cohorte->maestria->nombre }}</td>
                                        <td>{{ $cohorte->periodo_academico->nombre }}</td>
                                        <td>
                                            @if ($cohorte->aula)
                                                {{ $cohorte->aula->nombre }}
                                            @else
                                                <span class="text-muted">No requerido</span>
                                            @endif
                                        </td>
                                        <td>{{ $cohorte->aforo }}</td>
                                        <td>{{ $cohorte->modalidad }}</td>
                                        <td>
                                            @if($cohorte->fecha_inicio)
                                                {{ \Carbon\Carbon::parse($cohorte->fecha_inicio)->format('d/m/Y') }}
                                            @else
                                                ------
                                            @endif
                                            /
                                            @if($cohorte->fecha_fin)
                                                {{ \Carbon\Carbon::parse($cohorte->fecha_fin)->format('d/m/Y') }}
                                            @else
                                                ------
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('cohortes.edit', $cohorte->id) }}" class="btn btn-outline-primary btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <form id="delete-form-{{ $cohorte->id }}" action="{{ route('cohortes.destroy', $cohorte) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-outline-danger btn-sm delete-btn" data-id="{{ $cohorte->id }}" title="Eliminar">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const cohorteId = button.getAttribute('data-id');
                
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('delete-form-' + cohorteId);
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@stop
