@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@extends('adminlte::page')
@section('title', 'Calificar')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('calificaciones.store') }}" method="POST">
                @csrf
                <input type="hidden" name="docente_dni" value="{{ $docente_dni }}">
                <input type="hidden" name="asignatura_id" value="{{ $asignatura_id }}">
                <input type="hidden" name="cohorte_id" value="{{ $cohorte_id }}">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Alumno</th>
                                <th>Nota Actividades</th>
                                <th>Nota Prácticas</th>
                                <th>Nota Autónomo</th>
                                <th>Examen Final</th>
                                <th>Recuperación</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnos as $alumno)
                                <tr>
                                    <td>{{ $alumno->nombre1 }} {{ $alumno->apellidop }}</td>
                                    <input type="hidden" name="alumno_dni[]" value="{{ $alumno->dni }}">
                                    <td>
                                        <input class="form-control nota-input" type="number" step="0.01" name="nota_actividades[{{ $alumno->dni }}]" max="3.0" oninput="calcularTotal(this)">
                                    </td>
                                    <td>
                                        <input class="form-control nota-input" type="number" step="0.01" name="nota_practicas[{{ $alumno->dni }}]" max="3.0" oninput="calcularTotal(this)">
                                    </td>
                                    <td>
                                        <input class="form-control nota-input" type="number" step="0.01" name="nota_autonomo[{{ $alumno->dni }}]" max="3.0" oninput="calcularTotal(this)">
                                    </td>
                                    <td>
                                        <input class="form-control nota-input" type="number" step="0.01" name="examen_final[{{ $alumno->dni }}]" max="3.0" oninput="calcularTotal(this)">
                                    </td>
                                    <td>
                                        <input class="form-control nota-input" type="number" step="0.01" name="recuperacion[{{ $alumno->dni }}]" max="3.0" oninput="calcularTotal(this)">
                                    </td>
                                    <td>
                                        <input class="form-control total-input" type="number" step="0.01" name="total[{{ $alumno->dni }}]" readonly>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary">Calificar</button>
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Agregar estilos adicionales aquí si es necesario */
        .table th, .table td {
            text-align: center;
        }
    </style>
@stop

@section('js')
    <script>
        function calcularTotal(input) {
            var fila = input.closest('tr');
            var notas = fila.querySelectorAll('.nota-input');
            var total = 0;
            
            notas.forEach(function(nota) {
                total += parseFloat(nota.value) || 0;
            });

            fila.querySelector('.total-input').value = total.toFixed(2);
        }
    </script>
@stop