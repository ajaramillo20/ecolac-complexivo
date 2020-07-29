<?php

if (isset($_SESSION['userconnect'])) {
    $pantallas = AppController::GetMenuByRol($_SESSION['userconnect']->rol_id);
}

?>

<a href="<?= base_url ?>">Inicio</a>
<a href="<?= base_url ?>">Productos</a>
<?php if (!isset($_SESSION['userconnect'])) : ?>

    <a href="<?= base_url ?>usuario/login">Ingresar</a>

<?php else : ?>

    <?php foreach ($pantallas as $p) : ?>
        <?php if ($p->pnt_menu) : ?>

            <a href="<?= base_url . $p->pnt_vinculo ?>"><?= $p->pnt_nombre ?></a>

        <?php endif; ?>
    <?php endforeach; ?>

    <a class="icon-user" href="<?= base_url ?>usuario/perfil">(<?= $_SESSION['userconnect']->usr_nombre ?>)</a>
    <a class="icon-logout" href="<?= base_url ?>usuario/logout"></a>

<?php endif; ?>