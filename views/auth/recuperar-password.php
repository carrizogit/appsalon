<h1 class="nombre-pagina">Recuperar mi Contraseña</h1>
<p class="descripcion-pagina">Coloca tu nueva contraseña a continuacion</p>

<?php include_once __DIR__ .  '/../templates/alertas.php';  ?>

<?php if($error) return; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña:</label>
        <input type="password" placeholder="Contraseña" id="password" name="password">
    </div>

    <input type="submit" class="boton" value="Guardar">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>
</div> 