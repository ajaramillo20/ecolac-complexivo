function ConfirmDelete(ruta) {
    $.confirm({
        title: 'Advertencia!',
        theme: 'supervan',
        content: '¿Esta seguro?',
        buttons: {

            Confirmar: function () {
                window.location.href = ruta;
            },
            Cancelar: function () {

            }
        }
    });
}

function MostrarMensaje(mensaje, titulo = 'Mensaje') {
    $.alert({        
        theme: 'supervan',
        title: titulo,
        content: mensaje,        
    });
}