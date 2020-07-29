<div class="contenedor div-form">
    <h1>Autenticación</h1>
    <?php 
    
    if(isset($_SESSION['loginError']))
    {
        echo '<p class="error">' . $_SESSION['loginError'] . '</p>';
        App::UnsetSessionVar('loginError');
    }

    if(isset($_SESSION['userconnect']))
    {
        App::UnsetSessionVar('loginError');
        App::Redirect(base_url);
    }
    ?>
    <form action="<?=base_url?>usuario/autenticacion" method="POST" class="form-registro">
        <h2>Ingresa tus datos</h2>
        <div class="contenedor-inputs">
            
            <input type="email" name="correo" placeholder="Correo" required="true" class="input-100"/>                        
            <input type="password" name="contrasena" placeholder="Contraseña" required="true" class="input-100" />                                      
            <input type="submit" value="Ingresar" class="btn-enviar"  />                
        </div>            
    </form>
    <p class="link_recuperar">Registrate <a href="<?=base_url?>usuario/registrar">aqui</a></p>
</div>
<br/>