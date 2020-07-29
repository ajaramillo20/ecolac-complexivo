<div class="contenedor div-form">
    <?php
    if (isset($_SESSION['registroTipoError'])) {
        echo '<p class="error">' . $_SESSION['registroTipoError'] . '</p>';
    }
    ?>
    <h1>Registro de tipo de productos</h1>
    <form action="<?= base_url ?>tipo/agregar" method="POST" class="form-registro">
        <h2>Tipo de producto</h2>
        <div class="contenedor-inputs">
            <input type="text" name="nombre" placeholder="Nombre" required="true" class="input-100" />
            <input type="submit" value="Guardar" class="btn-enviar" />
        </div>
    </form>
</div>