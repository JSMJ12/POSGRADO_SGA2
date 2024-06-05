@extends('adminlte::page')

@section('title', 'Postulantes')

@section('content_header')
    <h1>Postulantes</h1>
@stop
@section('content')
@include('layouts.alerts')
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
                                    <div class="d-flex justify-content-center">
                                        <table>
                                            @if(!$postulante->pdf_titulouniversidad && !$postulante->pdf_papelvotacion && !$postulante->pdf_hojavida && !$postulante->pdf_cedula && !$postulante->pago_matricula)
                                                <li class="d-inline-block mx-2">
                                                    No hay archivos disponibles
                                                </li>
                                            @endif
                                            <tr>
                                                <td>
                                                    @if($postulante->pdf_cedula)
                                                        <a href="{{ asset('storage/' . $postulante->pdf_cedula) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-file-pdf"></i> Cédula
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($postulante->pdf_papelvotacion)
                                                        <a href="{{ asset('storage/' . $postulante->pdf_papelvotacion) }}" target="_blank" class="btn btn-outline-success btn-sm">
                                                            <i class="fas fa-file-pdf"></i> Papel Votación
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    @if($postulante->pdf_titulouniversidad)
                                                        <a href="{{ asset('storage/' . $postulante->pdf_titulouniversidad) }}" target="_blank" class="btn btn-outline-warning btn-sm">
                                                            <i class="fas fa-file-pdf"></i> Título Universidad
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($postulante->pdf_hojavida)
                                                        <a href="{{ asset('storage/' . $postulante->pdf_hojavida) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                            <i class="fas fa-file-pdf"></i> Hoja de Vida
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-center">
                                                    @if($postulante->pdf_conadis)
                                                        <a href="{{ asset('storage/' . $postulante->pdf_conadis) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                            <i class="fas fa-file-pdf"></i> CONADIS
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-center">
                                                    @if($postulante->pago_matricula)
                                                        <a href="{{ asset('storage/' . $postulante->pago_matricula) }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                                            <i class="fas fa-file-pdf"></i> Comprobante de Pago
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>                              
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <ul class="list-group">
                                            <li class="list-group-item text-center">
                                                <a href="{{ route('postulantes.show', $postulante->dni) }}" class="btn btn-outline-info btn-sm mb-1" title="Ver Detalles">
                                                    <i class="fas fa-eye"></i> Ver Detalles
                                                </a>
                                            </li>
                                            
                                            <li class="list-group-item text-center">
                                                <!-- Botón para eliminar postulante -->
                                                <form action="{{ route('postulantes.destroy', $postulante->dni) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este postulante?')" title="Eliminar">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </li>
                                            
                                            @if (!$postulante->status && $postulante->pdf_cedula && $postulante->pdf_papelvotacion && $postulante->pdf_titulouniversidad && $postulante->pdf_hojavida)
                                                <li class="list-group-item text-center">
                                                    <!-- Botón para marcar como Apto -->
                                                    <form action="{{ route('postulantes.aceptar', $postulante->dni) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirm('¿Estás seguro de que deseas marcar a este postulante como Apto?')" title="Marcar como Apto">
                                                            <i class="fas fa-check"></i> Aceptar
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
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