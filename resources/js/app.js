import './bootstrap';


Echo.private('canal_p')
    .listen('NewMessageNotificationEvent', (e) => {
        console.log('Nuevo mensaje recibido:', e);
        handleNewNotification(e);
    })
    .listen('PostulanteAceptado', (e) => {
        console.log('Nuevo postulante aceptado:', e);
        handleNewNotification(e);
    });

function handleNewNotification(data) {
    let newNotification;
    if (data.type === 'NewMessageNotification') {
        newNotification = `<li data-message-id="${data.id}" data-type="NewMessageNotification">De: ${data.sender.name}<br>Mensaje: ${data.message}</li>`;
    } else if (data.type === 'PostulanteAceptadoNotification') {
        newNotification = `<li data-message-id="${data.id}" data-type="PostulanteAceptadoNotification">Mensaje: ${data.message}</li>`;
    }

    if ($('#notificacionesModal .modal-body ul').length === 0) {
        $('#notificacionesModal .modal-body').html(`<ul>${newNotification}</ul>`);
    } else {
        $('#notificacionesModal .modal-body ul').prepend(newNotification);
    }

    let currentCount = parseInt($('#cantidadDeNuevasNotificaciones').text());
    $('#cantidadDeNuevasNotificaciones').text(currentCount + 1);

    $('#notificacionesModal .modal-body li').first().click(function() {
        let messageId = $(this).data('message-id');
        let notificationType = $(this).data('type');

        if (notificationType === 'NewMessageNotification') {
            window.location.href = '/mensajes/buzon/';
        } else if (notificationType === 'PostulanteAceptadoNotification') {
            window.location.href = '/inicio';
        }
    });
}

$(document).ready(function () {
    $('#notificacionesModalLink').click(function (event) {
        event.preventDefault(); // Evitar el comportamiento predeterminado del enlace

        // Realizar una solicitud AJAX para obtener los datos de las notificaciones
        $.get('/notificaciones', function (data) {
            // Limpiar el contenido del modal antes de actualizarlo
            $('#notificacionesModal .modal-body').empty();

            // Verificar si hay notificaciones
            let modalContent;
            if (data.notificaciones && data.notificaciones.length > 0) {
                // Construir el contenido del modal con los datos de las notificaciones
                modalContent = '<ul>';
                data.notificaciones.forEach(function (notificacion) {
                    let mensaje;
                    let remitente;

                    if (notificacion.data.type === 'NewMessageNotification') {
                        mensaje = notificacion.data.message;
                        remitente = notificacion.data.sender.name;
                        modalContent += `<li data-message-id="${notificacion.id}" data-type="NewMessageNotification">De: ${remitente}<br>Mensaje: ${mensaje}</li>`;
                    } else if (notificacion.data.type === 'PostulanteAceptadoNotification') {
                        mensaje = notificacion.data.message;
                        modalContent += `<li data-message-id="${notificacion.id}" data-type="PostulanteAceptadoNotification">Mensaje: ${mensaje}</li>`;
                    }
                });
                modalContent += '</ul>';
            } else {
                // Si no hay notificaciones, mostrar un mensaje en el modal
                modalContent = '<p>No hay notificaciones.</p>';
            }

            // Agregar el contenido al cuerpo del modal
            $('#notificacionesModal .modal-body').html(modalContent);

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
    });
});
