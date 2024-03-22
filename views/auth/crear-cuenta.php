<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Completa el siguiente formulario para crear una cuenta</p>

<?php include_once __DIR__ .  '/../templates/alertas.php';  ?>

<form class="formulario" action="/crear-cuenta" method="POST">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" placeholder="Nombre" id="nombre" name="nombre" value="<?php echo s($usuario->nombre); ?>">
    </div>

    <div class="campo">
        <label for="apellido">Apellido:</label>
        <input type="text" placeholder="Apellido" id="apellido" name="apellido" value="<?php echo s($usuario->apellido); ?>">
    </div>

    <div class="campo">
        <label for="telefono">Telefono:</label>
        <input type="tel" placeholder="Telefono" id="telefono" name="telefono" value="<?php echo s($usuario->telefono); ?>">
    </div>

    <div class="campo">
        <label for="email">Email:</label>
        <input type="mail" placeholder="Email" id="email" name="email" value="<?php echo s($usuario->email); ?>">
    </div>

    <div class="campo">
        <label for="password">Contraseña:</label>
        <input type="password" placeholder="Contraseña" id="password" name="password">
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>
    <a href="/olvide">¿Olvisdaste tu contraseña?</a>
</div>