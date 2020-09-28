<?php if (isset($_SESSION['pedidotoGestionMensaje'])) {
    App::ShowMessage($_SESSION['pedidotoGestionMensaje'], 'Confirmación');
    App::UnsetSessionVar('pedidotoGestionMensaje');
}
if (isset($_SESSION['pedidotoGestionError'])) {
    App::ShowMessage($_SESSION['pedidotoGestionError'], 'Error');
    App::UnsetSessionVar('pedidotoGestionError');
}
?>
<div class="miTabla">
    <h2>Lista pedidos / Ventas</h2>

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
                    <th>Vendedor</th>
                    <th>Dirección</th>
                    <th class="thAction">Detalles</th>
                    <th class="thAction">Despachar</th>
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
                        <td data-label="VENDEDOR"><?= $ped->ven_nombre ?></td>
                        <td data-label="Dirección de entrega"><?= $ped->dir_direccion ?></td>
                        <td data-label="Detalles"><a href="<?= base_url . 'pedido/detallepedido&id=' . $ped->ped_id ?>" class="icon-eye">Detalles</a></td>
                        <td data-label="Despachar"><a href="<?= base_url . 'pedido/gestionpedido&id=' . $ped->ped_id ?>" class="icon-caja">Despachar</a></td>

                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>