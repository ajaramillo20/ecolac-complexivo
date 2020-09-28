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
        <input name="fecha" id="fecha" class="input-100" type="date">

        <label for="estado">Estado:</label>
        <select class="input-100" name="estado" id="estado">
            <option value="">
                Todos
            </option>
            <?php if (isset($estados)) : ?>
                <?php foreach ($estados as $est) : ?>

                    <option value="<?= $est ?>" <?= isset($_SESSION['PEDARGS']->estado) && $est == $_SESSION['PEDARGS']->estado ? 'selected' : ''; ?>>
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
        <input class="input-100" type="text" name="pedid" id="pedid" >

        <!-- <input class="input-100 icon-search" type="button" onclick="onChange()" value="Buscar"> -->
        <div class="contenedor">
            <a class="btnaccion input-48 icon-search" href="javascript:void(0);" onclick="onChange()" >Buscar</a>
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
                        <td data-label="Ciudad"><?= $ped->ciu_nombre ?></td>
                        <td data-label="Detalles"><a href="<?= base_url . 'pedido/detallepedido&id=' . $ped->ped_id ?>" class="icon-eye"></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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