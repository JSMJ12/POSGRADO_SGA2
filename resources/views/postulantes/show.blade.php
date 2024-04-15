@extends('adminlte::page')

@section('title', 'Detalles del Postulante')

@section('content_header')
    
@stop


@section('content')
    <div class="container">

        <div class="card">
            <div class="container-fluid bg-success py-3">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="m-0">{{ $postulante->apellidop }} {{ $postulante->apellidom }}, {{ $postulante->nombre1 }} {{ $postulante->nombre2 }}</h1>
                    </div>
                    <div class="col-md-6 text-right">
                        <img src="{{ asset('storage/' . $postulante->imagen) }}" alt="Imagen de {{ $postulante->nombre }}" style="max-width: 150px; border-radius: 5px;">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Maestría</dt>
                            <dd class="col-sm-8">{{ $postulante->maestria->nombre }}</dd>

                            <dt class="col-sm-4">Cédula</dt>
                            <dd class="col-sm-8">{{ $postulante->dni }}</dd>

                            <dt class="col-sm-4">Correo Electrónico</dt>
                            <dd class="col-sm-8">{{ $postulante->correo_electronico }}</dd>

                            <dt class="col-sm-4">Celular</dt>
                            <dd class="col-sm-8">{{ $postulante->celular }}</dd>

                            <dt class="col-sm-4">Título Profesional</dt>
                            <dd class="col-sm-8">{{ $postulante->titulo_profesional }}</dd>

                            <dt class="col-sm-4">Universidad Título</dt>
                            <dd class="col-sm-8">{{ $postulante->universidad_titulo }}</dd>

                            <dt class="col-sm-4">Sexo</dt>
                            <dd class="col-sm-8">{{ $postulante->sexo }}</dd>

                            <dt class="col-sm-4">Fecha de Nacimiento</dt>
                            <dd class="col-sm-8">{{ $postulante->fecha_nacimiento }}</dd>

                            <dt class="col-sm-4">Nacionalidad</dt>
                            <dd class="col-sm-8">{{ $postulante->nacionalidad }}</dd>

                            <dt class="col-sm-4">Discapacidad</dt>
                            <dd class="col-sm-8">{{ $postulante->discapacidad }}</dd>

                            <dt class="col-sm-4">Porcentaje de Discapacidad</dt>
                            <dd class="col-sm-8">{{ $postulante->porcentaje_discapacidad }}</dd>

                            <dt class="col-sm-4">Código CONADIS</dt>
                            <dd class="col-sm-8">{{ $postulante->codigo_conadis }}</dd>

                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Provincia</dt>
                            <dd class="col-sm-8">{{ $postulante->provincia }}</dd>

                            <dt class="col-sm-4">Etnia</dt>
                            <dd class="col-sm-8">{{ $postulante->etnia }}</dd>

                            <dt class="col-sm-4">Nacionalidad Indígena</dt>
                            <dd class="col-sm-8">{{ $postulante->nacionalidad_indigena }}</dd>

                            <dt class="col-sm-4">Cantón</dt>
                            <dd class="col-sm-8">{{ $postulante->canton }}</dd>

                            <dt class="col-sm-4">Dirección</dt>
                            <dd class="col-sm-8">{{ $postulante->direccion }}</dd>

                            <dt class="col-sm-4">Tipo de Colegio</dt>
                            <dd class="col-sm-8">{{ $postulante->tipo_colegio }}</dd>

                            <dt class="col-sm-4">Cantidad de Miembros del Hogar</dt>
                            <dd class="col-sm-8">{{ $postulante->cantidad_miembros_hogar }}</dd>

                            <dt class="col-sm-4">Ingreso Total del Hogar</dt>
                            <dd class="col-sm-8">{{ $postulante->ingreso_total_hogar }}</dd>

                            <dt class="col-sm-4">Nivel de Formación del Padre</dt>
                            <dd class="col-sm-8">{{ $postulante->nivel_formacion_padre }}</dd>

                            <dt class="col-sm-4">Nivel de Formación de la Madre</dt>
                            <dd class="col-sm-8">{{ $postulante->nivel_formacion_madre }}</dd>

                            <dt class="col-sm-4">Origen de Recursos para Estudios</dt>
                            <dd class="col-sm-8">{{ $postulante->origen_recursos_estudios }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

