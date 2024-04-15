@extends('adminlte::page')
@section('title', 'Usuarios')
@section('content_header')
    <h1>Usuarios</h1>
@stop
@section('css')
    <style>
        .send-message {
            cursor: pointer;
        }
    </style>
@stop
@section('content')
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <a href="{{ route('usuarios.create') }}" class="btn btn-primary float-left"><i class="fas fa-plus"></i> Agregar nuevo</a>
            </div>
        </div>
        @if (isset($usuarios))
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="usuarios">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    @can('admin.usuarios.disable')
                                        <th>Estatus</th>
                                        <th>Roles</th>
                                        <th>Acciones</th>
                                    @endcan
                                    <th>Mensajería</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td class="text-center">{{ $usuario->id }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset($usuario->image) }}" alt="Imagen de {{ $usuario->name }}" style="max-width: 60px; border-radius: 50%;" loading="lazy">
                                        </td>
                                        <td class="text-center">{{ $usuario->name }}</td>
                                        <td class="text-center">{{ $usuario->apellido }}</td>
                                        <td class="text-center">{{ $usuario->email }}</td>
                                        @can('admin.usuarios.disable')
                                            <td class="text-center">{{ $usuario->status }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($usuario->roles as $role)
                                                        <li>{{ $role->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-outline-primary btn-sm" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            
                                                @if ($usuario->status == 'ACTIVO')
                                                    <form action="{{ route('usuarios.disable', $usuario->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Deshabilitar">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('usuarios.enable', $usuario->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-outline-success btn-sm" title="Reactivar">
                                                            <i class="fas fa-check-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        @endcan 
                                        <td class="text-center">
                                            <i class="fas fa-envelope send-message" data-toggle="modal" data-target="#sendMessageModal{{ $usuario->id }}" title="Enviar mensaje"></i>
                                            <!-- Modal de mensajes -->
                                            <div class="modal fade" id="sendMessageModal{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="sendMessageModalLabel{{ $usuario->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="sendMessageModalLabel{{ $usuario->id }}">Enviar mensaje a {{ $usuario->name }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Formulario de envío de mensaje aquí -->
                                                            <form id="sendMessageForm{{ $usuario->id }}" action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <!-- Campos del formulario -->
                                                                <div class="form-group">
                                                                    <label for="message">Mensaje</label>
                                                                    <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="attachment">Adjunto</label>
                                                                    <input type="file" class="form-control-file" id="attachment" name="attachment">
                                                                </div>
                                                                <!-- Campo oculto para receiver_id -->
                                                                <input type="hidden" name="receiver_id" value="{{ $usuario->id }}">
                                                                <!-- Fin de campos del formulario -->
                                                                <button type="submit" class="btn btn-primary">Enviar</button>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Fin del modal -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
        @endif
    </div>
@stop
@section('js')
    <script>
        $('#usuarios').DataTable({
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

        function sendMessage(userId) {
        // Obtener los datos del formulario
        var formData = new FormData(document.getElementById('sendMessageForm' + userId));

        // Enviar solicitud al servidor para almacenar el mensaje
        fetch('{{ route("messages.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => response.json())
        .then(data => {
            // Manejar la respuesta del servidor, si es necesario
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });

        // Cerrar el modal después de enviar el mensaje
        $('#sendMessageModal' + userId).modal('hide');
        

}
    </script>
@stop