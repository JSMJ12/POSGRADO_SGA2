@extends('adminlte::page')
@section('title', 'Crear Secretario')
@section('content_header')
    <h1>Crear Secretario</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('secretarios.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nombre">Primer Nombre:</label>
                    <input type="text" name="nombre1" id="nombre" class="form-control">
                </div>
                <div class="form-group">
                    <label for="nombre">Segundo Nombre:</label>
                    <input type="text" name="nombre2" id="nombre" class="form-control">
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido Paterno:</label>
                    <input type="text" name="apellidop" id="pellido" class="form-control">
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido Materno:</label>
                    <input type="text" name="apellidom" id="pellido" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo:</label>
                    <select name="sexo" id="sexo" class="form-control">
                        <option value="">Seleccione el sexo</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni" required>
                </div>
                <div class="form-group">
                    <label for="docen_foto">Foto:</label>
                    <input type="file" name="image" id="image" class="form-control-file">
                </div>
                
                <div class="form-group">
                    <label for="seccion_id">Sección:</label>
                    <select name="seccion_id" id="seccion_id" class="form-control">
                        <option value="">Seleccione una sección</option>
                        @foreach($secciones as $seccion)
                            <option value="{{ $seccion->id }}">{{ $seccion->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('secretarios.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@stop