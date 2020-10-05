<div class="miTabla">
    <h3>Gestion transacciones de usuario</h3>
    <?php if (isset($_SESSION['pantallaGestionMensaje'])) {
        //echo '<p class="succes">' . $_SESSION['pantallaGestionMensaje'] . '</p>';
        App::UnsetSessionVar('pantallaGestionMensaje');
    }
    if (isset($_SESSION['pantallaGestionError'])) {
        //echo '<p class="error">' . $_SESSION['pantallaGestionError'] . '</p>';
        App::UnsetSessionVar('pantallaGestionError');
    }
    ?>

    <div class="contenedor-filtros">
        <label for="roles">Sucursal:</label>
        <select class="input-100" name="roles" id="roles">
            <option value="">
                Todos
            </option>
            <?php if (isset($roles)) : ?>
                <?php foreach ($roles as $rol) : ?>

                    <option value="<?= $rol->rol_id ?>" <?= isset($_SESSION['PANARGS']->rol_id) && $rol->rol_id == $_SESSION['PANARGS']->rol_id ? 'selected' : ''; ?>>
                        <?= $rol->rol_nombre ?>
                    </option>

                <?php endforeach; ?>
            <?php endif; ?>

        </select>

        <label for="ruta">Ruta:</label>
        <input class="input-100" type="text" name="ruta" id="ruta" value="<?= isset($_SESSION['PROGARGS']->pro_nombre) ? $_SESSION['PROGARGS']->pro_nombre : "" ?>">
        <div class="contenedor">
            <a class="btnaccion input-48 icon-search" href="javascript:void(0);" onclick="onChange()">Buscar</a>
            <a class="btnaccion input-48 icon-cancel" href="javascript:void(0);" onclick="cleanFilters()">Limpiar filtros</a>
        </div>
    </div>

    <div class="contenedor">
        <a class="btn icon-plus" href="<?= base_url ?>pantalla/registrar">Agregar transacción a rol</a>
        <table>
            <thead>
                <tr>
                    <th class="thAction">Id</th>
                    <th>Pantalla</th>
                    <th>Ruta</th>
                    <th>Rol</th>
                    <th>Mostrar en menu</th>
                    <th class="thAction">Editar</th>
                    <th class="thAction">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pantallas as $pnt) : ?>
                    <tr>
                        <td data-label="Pantalla id"><?= $pnt->pnt_id ?></td>
                        <td data-label="Nombre"><?= $pnt->pnt_nombre ?></td>
                        <td data-label="Ruta"><?= $pnt->pnt_vinculo ?></td>
                        <td data-label="Rol"><?= $pnt->rol_nombre ?></td>
                        <td data-label="Mostrar en menu"><?= $pnt->pnt_menu ?></td>
                        <td data-label="Editar"><a class="icon-pencil-neg" href="<?= base_url ?>pantalla/editar&id=<?= $pnt->pnt_id ?>">Editar</a></td>
                        <td data-label="Eliminar"><a onclick="return ConfirmDelete('<?= base_url ?>pantalla/eliminar&id=<?= $pnt->pnt_id ?>');" class="icon-trash btn-action" href="#">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
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
    /* PREPARE THE SCRIPT */
    $("#roles").change(onChange);
    $("#ruta").keydown(function(e) {
        if (e.keyCode == 13) {
            onChange();
        }
    });

    function cleanFilters() {
        document.getElementById('roles').value = '';
        document.getElementById('ruta').value = '';
        onChange();
    }

    function onChange(pag = '1') {
        let rol = $('#roles').val();
        let ruta = $('#ruta').val();

        console.log(rol + ruta);
        let params = "&pag=" + pag;
        console.log("pag:" + pag);
        if (rol) {
            params += "&rol=" + rol;
        }

        if (ruta) {
            params += "&ruta=" + ruta;
        }

        var baseurl = '<?= base_url . 'pantalla/setGestionAjaxArgs' ?>' + params;
        $.ajax({
            type: "POST",
            url: baseurl,
            success: function(result) {
                window.location.reload();
            }
        });
    }
</script>