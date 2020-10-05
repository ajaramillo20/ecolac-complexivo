<div class="contenedor div-form">
    <?php
    if (isset($_SESSION['registroTipoError'])) {
        App::ShowMessage($_SESSION['registroTipoError'], 'Error');
    }
    $link = isset($entity) ? base_url . 'tipo/actualizar' : base_url . 'tipo/agregar';
    $titulo = isset($entity) ? 'Editar tipo' : 'Registrar tipo';
    ?>
    <h1><?= $titulo ?></h1>
    <form action="<?= $link ?>" method="POST" class="form-registro">
        <h2>Tipo de producto</h2>
        <div class="contenedor-inputs">
            <input hidden type="text" name="id" placeholder="Nombre" value="<?= isset($entity) ? $entity->tip_id : '' ?>" class="input-100" />
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" placeholder="Nombre" value="<?= isset($entity) ? $entity->tip_nombre : '' ?>" required="true" class="input-100" />
            <input type="submit" value="Guardar" class="btn-enviar" />
        </div>
    </form>
</div>