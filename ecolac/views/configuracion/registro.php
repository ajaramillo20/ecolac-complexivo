<div class="contenedor div-form">
    <?php
    if (isset($_SESSION['configuracionRegistroError'])) {
        App::ShowMessage($_SESSION['configuracionRegistroError'], 'Error');
        App::UnsetSessionVar('configuracionRegistroError');
    }

    $link = isset($entidad) ? base_url . 'configuracion/actualizar' : base_url . 'configuracion/agregar';
    $titulo = isset($entidad) ? 'Editar configuración' : 'Actualizar configuración';
    ?>
    <h1><?= $titulo ?></h1>
    <form action="<?= $link ?>" method="POST" class="form-registro">
        <h2>Configuración</h2>
        <div class="contenedor-inputs">
            <input hidden type="text" name="id" placeholder="Nombre" value="<?= isset($entidad) ? $entidad->conf_id : '' ?>" class="input-100" />
            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" placeholder="Nombre" value="<?= isset($entidad) ? $entidad->conf_descripcion : '' ?>" required="true" class="input-100" />
            <label for="valor">Valor</label>
            <input type="text" name="valor" placeholder="Nombre" required="true" value="<?= isset($entidad) ? $entidad->conf_valor : '' ?>" class="input-100" />
            <input type="submit" value="<?= isset($entidad) ? 'Actualizar' : 'Agregar'; ?>" class="btn-enviar" />
        </div>
    </form>
</div>