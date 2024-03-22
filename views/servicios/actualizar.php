<h1 class="nombre-pagina">Actualizar Servicios</h1>
<p class="descripcion-pagina">Administracion de servicios</p>

<?php
    include_once __DIR__ .'/../templates/barra.php';
    include_once __DIR__ .'/../templates/alertas.php';
?>

<!-- //le sacamos el action xq anteriormente mandamos el id por la url -->
<form method="POST" class="formulario">

    <?php include_once  __DIR__ . '/formulario.php'; ?>    

    <input type="submit" class="boton" value="Actualizar">
</form>