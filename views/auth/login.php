<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php include_once __DIR__ .  '/../templates/alertas.php';  ?>


<form class="formulario" action="/" method="POST">
    <div class="campo">
        <label for="email">Email:</label>
        <!-- name permite leer el dato con post -->
        <input type="email" placeholder="Email" id="email" name="email">
    </div>
    <div class="campo">
        <label for="password">Contraseña:</label>
        <!-- name permite leer el dato con post -->
        <input type="password" placeholder="Contraseña" id="password" name="password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesion">

</form>

<div class="acciones">
    <a href="/crear-cuenta">Crear una cuenta</a>
    <a href="/olvide">¿Olvisdaste tu contraseña?</a>
</div>