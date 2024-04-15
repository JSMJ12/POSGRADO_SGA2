@extends('adminlte::page')
@section('title', 'Dashboard Postulante')
@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <img src="{{ asset('images/unesum.png') }}" alt="University Logo" class="logo">
                        <img src="{{ asset('images/oie_transparent (1).png') }}" alt="University Seal" class="seal">
                        <div class="university-info text-center d-flex align-items-center flex-column">
                            <span class="university-name">UNIVERSIDAD ESTATAL DEL SUR DE MANABÍ</span>
                            <span class="institute">INSTITUTO DE POSGRADO</span>
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="2">Maestría</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>{{ $postulante->maestria->nombre }}</strong></td>
                                    
                                        <td><span class="text-muted">Precio:</span> {{ $postulante->maestria->precio_total }}</td>
                                    </tr>
                                    <tr>
                                        <td><span class="text-muted">Inicio:</span> {{ $postulante->maestria->fecha_inicio }}</td>
                                        <td><span class="text-muted">Fin:</span> {{ $postulante->maestria->fecha_fin }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                        
    
                        <form action="{{ route('dashboard_postulante.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="pdf_cedula">PDF Cédula / Pasaporte:</label>
                                <input type="file" name="pdf_cedula" class="form-control-file" accept=".pdf">
                            </div>

                            <div class="form-group">
                                <label for="pdf_papelvotacion">PDF Papel de Votación:</label>
                                <input type="file" name="pdf_papelvotacion" class="form-control-file" accept=".pdf">
                            </div>

                            <div class="form-group">
                                <label for="pdf_titulouniversidad">PDF Título de Universidad:</label>
                                <input type="file" name="pdf_titulouniversidad" class="form-control-file" accept=".pdf">
                            </div>

                            <div class="form-group">
                                <label for="pdf_hojavida">PDF Hoja de Vida:</label>
                                <input type="file" name="pdf_hojavida" class="form-control-file" accept=".pdf">
                            </div>

                            @if($postulante->discapacidad == 'Sí')
                                <div class="form-group" id="divPDFConadis">
                                    <label for="pdf_conadis">PDF CONADIS:</label>
                                    <input type="file" name="pdf_conadis" class="form-control-file" accept=".pdf">
                                </div>
                            @endif

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
<style>
    .header {
            text-align: center;
            margin-top: 10px;
        }
        .logo {
            width: 74px;
            height: 80px;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .seal {
            width: 74px;
            height: 73px;
            position: absolute;
            top: 20px;
            right: 10px;
        }
        .university-name {
            font-size: 14pt;
            font-weight: bold;
        }
        .institute {
            font-size: 10pt;
        }
        .divider {
            width: 100%;
            height: 2px;
            background-color: #000;
            margin: 10px 0;
        }
        .custom-select-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .card-header {
        height: 120px; /* Ajusta la altura según tus necesidades */
        padding: 20px; /* Ajusta el padding según tus necesidades */
    }


</style>
@stop