<?php
if (isset($_SESSION['userconnect'])) {
    $usr = $_SESSION['userconnect'];
}
?>

<section id="bienvenida">

    <h2 class="icono"><a class="icon-user"></a></h2>
    <h2><?= 'Hola ' . $usr->usr_nombre ?></h2>
    <p>En esta sección podras modificar tu información</p>
</section>

<div class="contenedor div-form">

    <form action="<?= base_url . 'usuario/actualizarperfil' ?>" class="form-registro" enctype="multipart/form-data" method="POST">
        <div class="redondos info-redondo">
            <img src=<?= base_url . "Recursos/img/ecolacLogo.jpg" ?> />

            <div id="div_file">
                <h4 class="icon-pencil-neg">Cambiar foto de perfil
                </h4>
                <input class="inputImagen" type="file" />
            </div>
        </div>
        <div class="contenedor-inputs">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" placeholder="Nombre" required value="<?= isset($entity) ? $entity->usr_nombre : '' ?>" class="input-100" />
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" placeholder="Usuario" required value="<?= isset($entity) ? $entity->usr_usuario : '' ?>" class="input-100" />
            <label for="correo">Correo</label>
            <input type="email" name="correo" placeholder="Correo" required value="<?= isset($entity) ? $entity->usr_correo : '' ?>" class="input-100" />
            <label for="telefono">Telefono</label>
            <input type="text" name="telefono" placeholder="Telefono" required value="<?= isset($entity) ? $entity->usr_telefono : '' ?>" class="input-100" />
            <label for="contrasena">Contraseña</label>
            <input type="password" name="contrasena" placeholder="Contraseña" class="input-100" />
            <input type="submit" value="Actualizar datos" class="btn-enviar" />
        </div>
    </form>
</div>