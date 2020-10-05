<div class="miTabla">
    <h3>Gestion de usuarios</h3>
    <?php
    if (isset($_SESSION['usuarioGestionMensaje'])) {
        echo '<p class="succes">' . $_SESSION['usuarioGestionMensaje'] . '</p>';
        App::UnsetSessionVar('usuarioGestionMensaje');
    }
    if (isset($_SESSION['usuarioGestionError'])) {
        echo '<p class="error">' . $_SESSION['usuarioGestionError'] . '</p>';
        App::UnsetSessionVar('usuarioGestionError');
    } ?>


    <div class="contenedor-filtros">

        <label for="rol">Rol:</label>
        <select class="input-100" name="rol" id="rol">
            <option value="">
                Todos
            </option>
            <?php if (isset($roles)) : ?>
                <?php foreach ($roles as $rol) : ?>

                    <option value="<?= $rol->rol_id ?>" <?= isset($_SESSION['USRARGS']->rol) && $rol->rol_id == $_SESSION['USRARGS']->rol ? 'selected' : ''; ?>>
                        <?= $rol->rol_nombre ?>
                    </option>

                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <label for="nombre">Nombre:</label>
        <input class="input-100" type="text" value="<?= isset($_SESSION['USRARGS']->nombre) ? $_SESSION['USRARGS']->nombre : ''  ?>" name="nombre" id="nombre">

        <label for="correo">Correo:</label>
        <input class="input-100" type="text" value="<?= isset($_SESSION['USRARGS']->correo) ? $_SESSION['USRARGS']->correo : ''  ?>" name="correo" id="correo">

        <!-- <input class="input-100 icon-search" type="button" onclick="onChange()" value="Buscar"> -->
        <div class="contenedor">
            <a class="btnaccion input-48 icon-search" href="javascript:void(0);" onclick="onChange()">Buscar</a>
            <a class="btnaccion input-48 icon-cancel" href="javascript:void(0);" onclick="cleanFilters()">Limpiar filtros</a>
        </div>
    </div>

    <div class="contenedor">
        <a class="btn icon-user-plus" href="<?= base_url ?>usuario/registro">Agregar nuevo usuario</a>

        <table>
            <thead>
                <tr>
                    <th class="thAction">Id</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th class="thAction">Editar</th>
                    <th class="thAction">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usr) : ?>
                    <tr>
                        <td data-label="id"><?= $usr->usr_id ?></td>
                        <td data-label="Nombre"><?= $usr->usr_nombre ?></td>
                        <td data-label="Correo"><?= $usr->usr_correo ?></td>
                        <td data-label="Rol"><?= $usr->rol_nombre ?></td>
                        <td data-label="editar"><a class="icon-eye btn-action" href="<?= base_url . 'usuario/editar&id=' . $usr->usr_id ?>">Editar</a></td>
                        <td data-label="eliminar"><a onclick="return ConfirmDelete('<?= base_url ?>usuario/eliminar&id=<?= $usr->usr_id ?>');" class="icon-trash btn-action" href="#">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
            <tbody>
        </table>
    </div>
</div>

<div class="miTabla">
    <p> <?= $paginaActual . ' de ' . $paginas->Paginas ?></p>
    <div class="contenedor">
        <?php if ($paginaActual > 1) : ?>
            <a class="btnaccion icon-angle-circled-left" href="javascript:void(0);" onclick="onChange(<?= $paginaActual - 1 ?>);"></a>
        <?php endif; ?>
        <?php if ($paginaActual < $paginas->Paginas) : ?>
            <a class="btnaccion icon-angle-circled-right" href="javascript:void(0);" onclick="onChange(<?= $paginaActual + 1 ?>);"></a>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    $("#rol").change(onChange);
    $("#nombre").keydown(function(e) {
        if (e.keyCode == 13) {
            onChange();
        }
    });
    $("#correo").keydown(function(e) {
        if (e.keyCode == 13) {
            onChange();
        }
    });



    function cleanFilters() {
        document.getElementById('rol').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('correo').value = '';
        onChange();
    }

    function onChange(pag = '1') {
        let rol = $('#rol').val();
        let nombre = $('#nombre').val();
        let correo = $('#correo').val();

        console.log(rol + nombre + correo);
        let params = "&pag=" + pag;
        console.log("pag:" + pag);
        if (rol) {
            params += "&rol=" + rol;
        }

        if (nombre) {
            params += "&nombre=" + nombre;
        }

        if (correo) {
            params += "&correo=" + correo;
        }

        var baseurl = '<?= base_url . 'usuario/SeUsrGestionAjax' ?>' + params;
        console.log(baseurl);
        $.ajax({
            type: "POST",
            url: baseurl,
            success: function(result) {
                window.location.reload();
            }
        });
    }
</script>