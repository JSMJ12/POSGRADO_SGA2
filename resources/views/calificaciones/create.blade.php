@extends('adminlte::page')
@section('title', 'Calificar y Agregar Alumnos')

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
                            @if (count($alumnos) > 0)
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
                            @endif

                            <!-- Generar filas adicionales para nuevos alumnos -->
                            @for ($i = 0; $i < $aforoMaximo - count($alumnos); $i++)
                                <tr>
                                    <td>
                                        <input class="form-control" type="text" name="nuevo_alumno[dni][]" placeholder="Cédula/Pasaporte">
                                        <input class="form-control mt-2" type="text" name="nuevo_alumno[nombre1][]" placeholder="Primer Nombre">
                                        <input class="form-control mt-2" type="text" name="nuevo_alumno[nombre2][]" placeholder="Segundo Nombre">
                                        <input class="form-control mt-2" type="text" name="nuevo_alumno[apellidop][]" placeholder="Apellido Paterno">
                                        <input class="form-control mt-2" type="text" name="nuevo_alumno[apellidom][]" placeholder="Apellido Materno">
                                    </td>
                                    <td>
                                        <input class="form-control nota-input" type="number" step="0.01" name="nuevo_nota_actividades[]" max="3.0" oninput="calcularTotal(this)">
                                    </td>
                                    <td>
                                        <input class="form-control nota-input" type="number" step="0.01" name="nuevo_nota_practicas[]" max="3.0" oninput="calcularTotal(this)">
                                    </td>
                                    <td>
                                        <input class="form-control nota-input" type="number" step="0.01" name="nuevo_nota_autonomo[]" max="3.0" oninput="calcularTotal(this)">
                                    </td>
                                    <td>
                                        <input class="form-control nota-input" type="number" step="0.01" name="nuevo_examen_final[]" max="3.0" oninput="calcularTotal(this)">
                                    </td>
                                    <td>
                                        <input class="form-control nota-input" type="number" step="0.01" name="nuevo_recuperacion[]" max="3.0" oninput="calcularTotal(this)">
                                    </td>
                                    <td>
                                        <input class="form-control total-input" type="number" step="0.01" name="nuevo_total[]" readonly>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Notas</button>
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>
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
