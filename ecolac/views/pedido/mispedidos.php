<div class="miTabla">
    <h3>Mis pedidos</h3>
    <?php if (isset($_SESSION['pedidoMisPedidosMensaje'])) {
        App::ShowMessage($_SESSION['pedidoMisPedidosMensaje'], 'Confirmación');
        App::UnsetSessionVar('pedidoMisPedidosMensaje');
    }
    if (isset($_SESSION['pedidoMisPedidosError'])) {
        App::ShowMessage($_SESSION['pedidoMisPedidosError'], 'Error');
        App::UnsetSessionVar('pedidoMisPedidosError');
    }
    ?>

    <div class="contenedor-filtros">
        <label for="fecha">Fecha:</label>
        <input name="fecha" id="fecha" value="<?= isset($_SESSION['PEDARGS']->ped_fecha) ? $_SESSION['PEDARGS']->ped_fecha : '' ?>" class="input-100" type="date">

        <label for="estado">Estado:</label>
        <select class="input-100" name="estado" id="estado">
            <option value="">
                Todos
            </option>
            <?php if (isset($estados)) : ?>
                <?php foreach ($estados as $est) : ?>

                    <option value="<?= $est ?>" <?= isset($_SESSION['PEDARGS']->pes_id) && $est == $_SESSION['PEDARGS']->pes_id ? 'selected' : ''; ?>>
                        <?= $est ?>
                    </option>

                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <label for="direccion">Dirección:</label>
        <select class="input-100" name="direccion" id="direccion">
            <option value="">
                Todos
            </option>
            <?php if (isset($direcciones)) : ?>
                <?php foreach ($direcciones as $dir) : ?>

                    <option value="<?= $dir->dir_id ?>" <?= isset($_SESSION['PEDARGS']->dir_id) && $dir->dir_id == $_SESSION['PEDARGS']->dir_id ? 'selected' : ''; ?>>
                        <?= $dir->dir_direccion ?>
                    </option>

                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <label for="pedid">Pedido id:</label>
        <input class="input-100" type="text" value="<?= isset($_SESSION['PEDARGS']->ped_id) ? $_SESSION['PEDARGS']->ped_id : ''  ?>" name="pedid" id="pedid">

        <!-- <input class="input-100 icon-search" type="button" onclick="onChange()" value="Buscar"> -->
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
                    <th>Fecha</th>
                    <th>Costo</th>
                    <th>Estado</th>
                    <th>Direccion de entrega</th>
                    <th>Sucursal</th>
                    <th>Ciudad</th>
                    <th class="thAction">Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $ped) : ?>
                    <tr>
                        <td data-label="ID"><?= $ped->ped_id ?></td>
                        <td data-label="FECHA"><?= StringFormat::DateFormat($ped->ped_fecha) ?></td>
                        <td data-label="COSTO"><?= $ped->ped_costo ?></td>
                        <td data-label="ESTADO"><?= $ped->pes_nombre ?></td>
                        <td data-label="Dirección de entrega"><?= $ped->dir_direccion ?></td>
                        <td data-label="Sucursal"><?= $ped->suc_nombre ?></td>
                        <td data-label="Ciudad"><?= $ped->ciu_nombre ?></td>
                        <td data-label="Detalles"><a href="<?= base_url . 'pedido/detallepedido&id=' . $ped->ped_id ?>" class="icon-eye"></a></td>
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
    $("#fecha").change(onChange);
    $("#estado").change(onChange);
    $("#direccion").change(onChange);
    $("#pedid").keydown(function(e) {
        if (e.keyCode == 13) {
            onChange();
        }
    });

    function cleanFilters() {
        document.getElementById('fecha').value = '';
        document.getElementById('estado').value = '';
        document.getElementById('direccion').value = '';
        document.getElementById('pedid').value = '';
        onChange();
    }

    function onChange(pag = '1') {
        let fec = $('#fecha').val();
        let est = $('#estado').val();
        let dir = $('#direccion').val();
        let ped = $('#pedid').val();

        console.log(fec + est + dir + ped);
        let params = "&pag=" + pag;
        console.log("pag:" + pag);
        if (fec) {
            params += "&fec=" + fec;
        }

        if (est) {
            params += "&est=" + est;
        }

        if (dir) {
            params += "&dir=" + dir;
        }

        if (ped) {
            params += "&ped=" + ped;
        }

        var baseurl = '<?= base_url . 'pedido/setMisPedidosAjaxParams' ?>' + params;
        $.ajax({
            type: "POST",
            url: baseurl,
            success: function(result) {
                window.location.reload();
            }
        });
    }
</script>