@extends('adminlte::page')
@section('title', 'Dashboar')
@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h2>Asignaturas matriculadas:</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($asignaturas as $asignatura)
                            <li class="list-group-item">{{ $asignatura->nombre }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2>Notas:</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="nota">
                            <thead>
                                <tr>
                                    <th>Docente</th>
                                    <th>Aula</th>
                                    <th>Paralelo</th>
                                    <th>Asignatura</th>
                                    <th>Actividades de aprendizaje</th>
                                    <th>Prácticas de aplicación</th>
                                    <th>Aprendizaje autónomo</th>
                                    <th>Examen final</th>
                                    <th>Recuperación</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notas as $asignatura => $nota)
                                    <tr>
                                        <td>
                                            <div style="display: flex; align-items: center;">
                                                <img src="{{ $nota['docente_image'] }}" alt="Imagen del docente" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                                                <span>{{ $nota['docente'] }}</span>
                                            </div>
                                        </td>                                        
                                        <td>{{ $nota['aula'] }}</td>
                                        <td>{{ $nota['paralelo'] }}</td>
                                        <td>{{ $asignatura }}</td>
                                        <td>{{ $nota['actividades_aprendizaje'] }}</td>
                                        <td>{{ $nota['practicas_aplicacion'] }}</td>
                                        <td>{{ $nota['aprendizaje_autonomo'] }}</td>
                                        <td>{{ $nota['examen_final'] }}</td>
                                        <td>{{ $nota['recuperacion'] }}</td>
                                        <td>{{ $nota['total'] }}</td>
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
    $('#nota').DataTable({
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