@extends('adminlte::page')
@section('title', 'Pagos')

@section('content_header')
    <h1>Pagos Realizados y Pendientes</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <!-- Gráficos -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3>Pagos Realizados</h3>
                </div>
                <div class="card-body">
                    <canvas id="pagosChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3>Alumnos con Pagos Pendientes</h3>
                </div>
                <div class="card-body">
                    <canvas id="alumnosPendientesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabla de pagos -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Historial de Pagos</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="pagosTable">
                        <thead>
                            <tr>
                                <th>Cedula/Pasaporte</th>
                                <th>Monto</th>
                                <th>Fecha de Pago</th>
                                <th>Comprobante</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pagosDia as $pago)
                            <tr>
                                <td>{{ $pago->dni }}</td>
                                <td>${{ number_format($pago->monto, 2) }}</td>
                                <td>{{ $pago->fecha_pago }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $pago->archivo_comprobante) }}" target="_blank" class="btn btn-info btn-sm" title="Ver Comprobante">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    @if (!$pago->verificado)
                                        <form action="{{ route('pagos.verificar', $pago->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">Verificado</button>
                                        </form>
                                    @else
                                        <span class="badge badge-success">Verificado</span>
                                    @endif
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
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicializar DataTable
        $('#pagosTable').DataTable();
        
        // Datos para el gráfico de pagos realizados
        var ctx = document.getElementById('pagosChart').getContext('2d');
        var pagosChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Hoy', 'Este Mes', 'Este Año'],
                datasets: [{
                    label: 'Monto Total Pagado',
                    data: [{{ $pagosDiaTotal }}, {{ $pagosMesTotal }}, {{ $pagosAnioTotal }}],
                    backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Datos para el gráfico de alumnos con pagos pendientes
        var ctx2 = document.getElementById('alumnosPendientesChart').getContext('2d');
        var alumnosPendientesChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: [
                    @foreach($alumnosPendientes as $alumno)
                        "{{ $alumno->nombre1 }} {{ $alumno->apellido_paterno }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Alumnos con Pagos Pendientes',
                    data: [
                        @foreach($alumnosPendientes as $alumno)
                            1,
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    });
</script>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<style>
    .card-header {
        background-color: #079c36;
        color: white;
    }
    .card-body {
        padding: 20px;
    }
    table {
        width: 100%;
    }
    .table th, .table td {
        text-align: center;
    }
</style>
@stop
