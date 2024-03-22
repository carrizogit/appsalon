<h1 class="nombre-pagina">Olvide mi Contraseña</h1>
<p class="descripcion-pagina">Repuera tu cuenta escribiendo tu email y confirmar</p>

<?php include_once __DIR__ .  '/../templates/alertas.php';  ?>

<form class="formulario" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="Email" id="email" name="email">
    </div>

    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>


<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>
</div> 