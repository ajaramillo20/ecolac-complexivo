<?php if (isset($_SESSION['entregassucursalMensaje'])) {
    App::ShowMessage($_SESSION['entregassucursalMensaje'], 'Confirmación');
    App::UnsetSessionVar('entregassucursalMensaje');
}
if (isset($_SESSION['entregassucursalError'])) {
    App::ShowMessage($_SESSION['entregassucursalError'], 'Error');
    App::UnsetSessionVar('entregassucursalError');
}
?>
<div class="miTabla">
    <h2>Listado entregas</h2>
    <div class="contenedor-filtros">
        <label for="roles">Estado:</label>
        <select class="input-100" name="estado" id="estado">
            <option value="">
                Todos
            </option>
            <?php if (isset($estados)) : ?>
                <?php foreach ($estados as $est) : ?>

                    <option value="<?= $est ?>" <?= isset($_SESSION['VENARGS']->estado) && $est == $_SESSION['VENARGS']->estado ? 'selected' : ''; ?>>
                        <?= $est ?>
                    </option>

                <?php endforeach; ?>
            <?php endif; ?>

        </select>
        <label for="fecha">Fecha:</label>
        <input class="input-100" type="date" name="fecha" id="fecha" value="<?= isset($_SESSION['VENARGS']->fec) ? $_SESSION['VENARGS']->fec : "" ?>">

        <label for="nombre">Cliente:</label>
        <input class="input-100" type="text" name="nombre" id="nombre" value="<?= isset($_SESSION['VENARGS']->nombre) ? $_SESSION['VENARGS']->nombre : "" ?>">
        <div class="contenedor">
            <a class="btnaccion input-48 icon-search" href="javascript:void(0);" onclick="onChange()">Buscar</a>
            <a class="btnaccion input-48 icon-cancel" href="javascript:void(0);" onclick="cleanFilters()">Limpiar filtros</a>
        </div>
    </div>
    <div class="contenedor">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Sucursal</th>
                    <th>Repartidor</th>
                    <th>Dirección</th>
                    <th class="thAction">Detalles</th>
                    <th class="thAction">Entregar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $ped) : ?>

                    <tr>
                        <td data-label="ID"><?= $ped->ped_id ?></td>
                        <td data-label="Cliente"><?= $ped->usr_nombre ?></td>
                        <td data-label="FECHA"><?= StringFormat::DateFormat($ped->ped_fecha) ?></td>
                        <td data-label="ESTADO"><?= $ped->pes_nombre ?></td>
                        <td data-label="SUCURSAL"><?= $ped->suc_nombre ?></td>
                        <td data-label="REPARTIDOR"><?= $ped->rep_nombre ?></td>
                        <td data-label="Dirección de entrega"><?= $ped->dir_direccion ?></td>
                        <td data-label="Detalles"><a href="<?= base_url . 'pedido/detallepedido&id=' . $ped->ped_id ?>" class="icon-eye">Detalles</a></td>
                        <td data-label="Detalles"><a href="<?= base_url . 'pedido/gestionentrega&id=' . $ped->ped_id ?>" class="icon-paper-plane">Entregar</a></td>
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
    $("#estado").change(onChange);
    $("#fecha").change(onChange);
    $("#nombre").keydown(function(e) {
        if (e.keyCode == 13) {
            onChange();
        }
    });

    function cleanFilters() {
        document.getElementById('estado').value = '';
        document.getElementById('fecha').value = '';
        document.getElementById('nombre').value = '';
        onChange();
    }

    function onChange(pag = '1') {
        let est = $('#estado').val();
        let fec = $('#fecha').val();
        let nom = $('#nombre').val();

        console.log(est + fec + nom);
        let params = "&pag=" + pag;
        console.log("pag:" + pag);
        if (est) {
            params += "&est=" + est;
        }

        if (fec) {
            params += "&fec=" + fec;
        }

        if (nom) {
            params += "&nom=" + nom;
        }

        var baseurl = '<?= base_url . 'pedido/setEntregasAjaxParams' ?>' + params;
        $.ajax({
            type: "POST",
            url: baseurl,
            success: function(result) {
                window.location.reload();
            }
        });
    }
</script>