<?php
define("base_url", "http://www.ecolac.com.devel/");
define("default_controller", "ProductoController");
define("default_action", "index");
define("default_pantallas", array(
    'usuario/registrar',
    'usuario/login',
    'usuario/logout',
    'usuario/agregar',
    'usuario/registroCompleto',
    'usuario/autenticacion',
    'categoria/tipo',
    'usuario/perfil',
    'producto/selectsucursal'
));
define("logged_pantallas", array(
    'pedido/realizar',
    'pedido/agregar',
    'direccion/registro',
    'direccion/editar',
    'direccion/agregar',
    'direccion/actualizar',
    'usuario/actualizarperfil',
    'usuario/historialcompras',
    'pedido/detallepedido',
    'carrito/agregar',
    'carrito/agregarAjax',
    'carrito/eliminar',
    'carrito/index'
));
define("products_path", 'files/images/productos');
define("users_path", 'files/images/usuarios');
