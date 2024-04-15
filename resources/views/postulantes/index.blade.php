@extends('adminlte::page')

@section('title', 'Postulantes')

@section('content_header')
    <h1>Postulantes</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="postulantes">
                    <thead>
                        <tr>
                            <th>Cedula</th>
                            <th>Nombre</th>
                            <th>Correo Electrónico</th>
                            <th>Celular</th>
                            <th>Título Profesional</th>
                            <th>Maestría</th>
                            <th>PDFs</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($postulantes as $postulante)
                            <tr>
                                <td>{{ $postulante->dni }}</td>
                                <td>{{ $postulante->apellidop }} <br> {{ $postulante->apellidom }} <br> {{ $postulante->nombre1 }} <br> {{ $postulante->nombre2 }}</td>
                                <td>{{ $postulante->correo_electronico }}</td>
                                <td>{{ $postulante->celular }}</td>
                                <td>{{ $postulante->titulo_profesional }}</td>
                                <td>{{ $postulante->maestria->nombre }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ asset('storage/' . $postulante->pdf_cedula) }}" target="_blank" class="btn btn-outline-primary btn-sm mx-1">
                                            <i class="fas fa-file-pdf"></i> Cédula
                                        </a>
                                        <a href="{{ asset('storage/' . $postulante->pdf_papelvotacion) }}" target="_blank" class="btn btn-outline-success btn-sm mx-1">
                                            <i class="fas fa-file-pdf"></i> Papel Votación
                                        </a>
                                        <a href="{{ asset('storage/' . $postulante->pdf_titulouniversidad) }}" target="_blank" class="btn btn-outline-warning btn-sm mx-1">
                                            <i class="fas fa-file-pdf"></i> Título Universidad
                                        </a>
                                        @if($postulante->pdf_conadis)
                                            <a href="{{ asset('storage/' . $postulante->pdf_conadis) }}" target="_blank" class="btn btn-outline-info btn-sm mx-1">
                                                <i class="fas fa-file-pdf"></i> CONADIS
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="btn-group-vertical" role="group" aria-label="Acciones">
                                        <a href="{{ route('postulantes.show', $postulante->dni) }}" class="btn btn-outline-info btn-sm mb-1" title="Ver Detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('postulantes.destroy', $postulante->dni) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este postulante?')" title="Eliminar">
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

@stop

@section('js')
    <script>
    
        $('#postulantes').DataTable({
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