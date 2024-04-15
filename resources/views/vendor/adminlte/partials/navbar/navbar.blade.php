<nav class="main-header navbar {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }} {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">
    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
        {{-- Mostrar el icono de notificaciones con el número --}}
        <li class="nav-item">
            <a id="notificacionesModalLink" class="nav-link" href="#">
                <i class="fa fa-bell"></i> {{-- Icono de campana para notificaciones --}}
                <span class="badge badge-warning" id="cantidadDeNuevasNotificaciones">{{ $cantidadDeNuevasNotificaciones }}</span> {{-- Número de nuevos mensajes --}}
            </a>
        </li>
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>
</nav>

<div class="modal fade" id="notificacionesModal" tabindex="-1" role="dialog" aria-labelledby="notificacionesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="notificacionesModalLabel">Notificaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se llenarán dinámicamente las notificaciones mediante JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script>
    $(document).ready(function () {
        $('#notificacionesModalLink').click(function (event) {
            event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
            
            // Realizar una solicitud AJAX para obtener los datos de las notificaciones
            $.get('/notificaciones', function (data) {
                // Limpiar el contenido del modal antes de actualizarlo
                $('#notificacionesModal .modal-body').empty();

                // Verificar si hay notificaciones
                if (data.notificaciones && data.notificaciones.length > 0) {
                    // Construir el contenido del modal con los datos de las notificaciones
                    var modalContent = '<ul>';
                    data.notificaciones.forEach(function (notificacion) {
                        var mensaje = notificacion.data.message.message;
                        var remitente = notificacion.data.message.sender.name;
                        var receptor = notificacion.data.message.receiver.name;
                        modalContent += '<li data-message-id="' + notificacion.id + '">De: ' + remitente + '<br>' + ' Mensaje: ' + mensaje + '</li>';
                    });
                    modalContent += '</ul>';
                } else {
                    // Si no hay notificaciones, mostrar un mensaje en el modal
                    var modalContent = '<p>No hay notificaciones disponibles.</p>';
                }

                // Agregar el contenido al cuerpo del modal
                $('#notificacionesModal .modal-body').html(modalContent);

                // Agregar un evento de clic a cada mensaje para redirigir
                $('#notificacionesModal .modal-body li').click(function() {
                    var messageId = $(this).data('message-id');
                    window.location.href = '/mensajes/buzon' // Redirigir a la vista del mensaje
                });

                // Mostrar la cantidad de nuevas notificaciones en el badge del icono de campana
                $('#cantidadDeNuevasNotificaciones').text(data.cantidadNotificacionesNuevas);

                // Mostrar el modal
                $('#notificacionesModal').modal('show');
            }).fail(function() {
                // En caso de error en la solicitud AJAX, mostrar un mensaje de error
                $('#notificacionesModal .modal-body').html('<p>Error al obtener las notificaciones.</p>');
                $('#cantidadDeNuevasNotificaciones').text('0');
                $('#notificacionesModal').modal('show');
            });

            // Configurar Laravel Echo para suscribirse a los eventos de Pusher
            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
            });

            var channel = pusher.subscribe('private-canal_p');
            channel.bind('App\\Events\\NewMessageNotificationEvent', function(data) {
                // Manejar el evento recibido y actualizar la interfaz de usuario según sea necesario
                console.log('Nuevo mensaje recibido:', data);
            });
        });
    });
</script>


