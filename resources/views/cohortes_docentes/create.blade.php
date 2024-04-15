@extends('adminlte::page')
@section('title', 'Docente Cohorte')
@section('content_header')
    <h1>Asignar Cohortes al Docente</h1>
@stop

@section('content')
<div class="container mt-5">
    <form method="GET">
        <div class="form-group">
            <label for="asignatura_id">Selecciona una asignatura:</label>
            <select class="form-control" id="asignatura_id" name="asignatura_id">
                <option value="">Todas las asignaturas</option>
                @foreach ($asignaturas as $asignatura)
                    <option value="{{ $asignatura->id }}" {{ $asignatura->id == $asignatura_id ? 'selected' : '' }}>{{ $asignatura->nombre }}</option>
                @endforeach
            </select>
        </div>
    </form>
    @foreach ($maestriaCohortes as $mc)
        <form action="{{ route('cohortes_docentes.store') }}" method="post" class="mb-4">
            @csrf
            <input type="hidden" name="docente_dni" value="{{ $docente->dni }}">
            <input type="hidden" name="asignatura_id" value="{{ $mc['asignatura']->id }}">
            
            <div class="card cohortes-container cohortes-{{ $mc['asignatura']->id }}">

                <div class="card">
                    <div class="card-body" style="background-color: #28a745; color: white;">
                        <div class="media">
                            <img src="{{ asset($docente->image) }}" alt="Imagen de {{ $docente->nombre }}" class="mr-3 rounded-circle" style="max-width: 80px;">
                            <div class="media-body">
                                <h4 class="mt-0">{{ $docente->nombre1 }} {{ $docente->nombre2 }} {{ $docente->apellidop }} {{ $docente->apellidom }}</h4>
                                <p>Asignatura: {{ $mc['asignatura']->nombre }}</p>
                                <p>Maestria: {{ $mc['maestria']->nombre }}</p>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($mc['cohortes'] as $cohorte)
                            <li class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="cohorte_id[]" value="{{ $cohorte->id }}" id="cohorte{{ $cohorte->id }}" {{ in_array($cohorte->id, old('cohorte_id', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cohorte{{ $cohorte->id }}">
                                        {{ $cohorte->nombre }} {{ $cohorte->modalidad }} - {{ $cohorte->aula->nombre }} ({{ $cohorte->aula->paralelo->nombre }})
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary" type="submit">Inscribir</button>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
</div>
@stop

@section('js')
<script>
    $(document).ready(function () {
        // Al cambiar la asignatura, filtrar y mostrar los cohortes
        $('#asignatura_id').on('change', function () {
            var asignaturaId = $(this).val();

            // Ocultar todos los contenedores de cohortes
            $('.cohortes-container').hide();

            // Mostrar solo los cohortes de la asignatura seleccionada
            $('.cohortes-' + asignaturaId).show();
        });
    });
</script>
    
@stop
