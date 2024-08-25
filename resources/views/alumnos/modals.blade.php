@foreach ($alumnos as $alumno)
    <div class="modal fade" id="matriculasModal{{ $alumno->dni }}" tabindex="-1" role="dialog" aria-labelledby="matriculasModalLabel{{ $alumno->dni }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0e4439; color: white;">
                    <h5 class="modal-title" id="matriculasModalLabel{{ $alumno->dni }}">Matrículas de {{ $alumno->nombre1 }} {{ $alumno->apellidop }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white;">&times;</span> <!-- Color rojo para el botón de cerrar -->
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Asignatura</th>
                                <th>Docente</th>
                                <th>Cohorte</th>
                                <th>Aula</th>
                                <th>Paralelo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumno->matriculas as $matricula)
                                <tr>
                                    <td>{{ $matricula->asignatura->nombre }}</td>
                                    <td>{{ $matricula->docente ? $matricula->docente->nombre1 : 'Nombre no disponible' }} {{ $matricula->docente ? $matricula->docente->apellidop : 'Apellido Paterno no disponible' }} {{ $matricula->docente ? $matricula->docente->apellido2 : 'Apellido Materno no disponible' }}</td>
                                    <td>{{ $matricula->cohorte->nombre }}</td>
                                    <td>
                                        @if ($matricula->cohorte->aula)
                                            {{ $matricula->cohorte->aula->nombre }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($matricula->cohorte->aula && $matricula->cohorte->aula->paralelo)
                                            {{ $matricula->cohorte->aula->paralelo->nombre }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button> <!-- Cambio de color a rojo para el botón de cerrar -->
                </div>
            </div>
        </div>
    </div>
@endforeach
