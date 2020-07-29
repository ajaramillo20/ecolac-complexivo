<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8" />
    <title>ECOLAC</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url ?>Recursos/css/fontello.css" />
    <link rel="stylesheet" href="<?= base_url ?>Recursos/css/estilos.css" />
    <script src="<?= base_url ?>Recursos/js/EcolacJS.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
</head>

<body>
    <header>
        <div class="contenedor">
            <h1><img src="<?= base_url ?>Recursos/img/appicon.png" />ECOLAC</h1>
            <input type="checkbox" id="menu-bar" />
            <label class="icon-menu" for="menu-bar"></label>
            <nav class="menu">
                <a href="<?= base_url ?>">Inicio</a>
                <a href="<?= base_url ?>">Productos</a>
                <?php if (!isset($_SESSION['userconnect'])) : ?>
                    <a href="<?= base_url ?>usuario/login">Ingresar</a>
                <?php else : ?>
                    <?php $pantallas = AppController::GetMenuByRol($_SESSION['userconnect']->rol_id); ?>
                    <?php foreach ($pantallas as $p) : ?>
                        <?php if ($p->pnt_menu) : ?>
                            <a href="<?= base_url . $p->pnt_vinculo ?>"><?= $p->pnt_nombre ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <a class="icon-user" href="<?= base_url ?>usuario/perfil">(<?= $_SESSION['userconnect']->usr_nombre ?>)</a>
                    <a class="icon-logout" href="<?= base_url ?>usuario/logout"></a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main>
        <section id="banner">
            <img src="<?= base_url ?>Recursos/img/banner.jpg" />
            <div class="contenedor">
                <h2>ECOLAC</h2>
                <p>Productos de calidad</p>
                <a>Leer mas</a>
            </div>
        </section>