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
    <section class="filters">
        <label for="sucursales">Sucursal:</label>
        <select class="input-filter" name="sucursales" id="sucursales">

            <?php if (isset($sucursales)) : ?>
                <?php while ($suc = $sucursales->fetch_object()) : ?>

                    <option value="<?= $suc->suc_id ?>" <?= isset($_SESSION['succonnect']) && $suc->suc_id == $_SESSION['succonnect']->suc_id ? 'selected' : ''; ?>>
                        <?= $suc->ciu_nombre . ': ' . $suc->suc_nombre ?>
                    </option>

                <?php endwhile; ?>
            <?php endif; ?>

        </select>

        <label for="sucursales">Estado:</label>
        <select class="input-filter" name="categorias" id="categorias">
            <option value="">
                Todos
            </option>
            <?php if (isset($tipos)) : ?>
                <?php while ($tip = $tipos->fetch_object()) : ?>

                    <option value="<?= $tip->tip_id ?>">
                        <?= $tip->tip_nombre ?>
                    </option>

                <?php endwhile; ?>
            <?php endif; ?>
        </select>

        <label for="">Fecha</label>
        <input type="date">
    </section>
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