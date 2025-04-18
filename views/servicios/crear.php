<h1 class="nombre-app">Nuevo Servicio</h1>
<p class="descripcion-app">Llena los siguientes campos</p>

<?php include __DIR__ . '/../templates/barra.php' ?>

<?php require_once __DIR__ . '/../templates/alertas.php' ?>
<div class="formulario">
    <form action="/servicios/crear" method="POST">
        <?php include 'formulario.php' ?>
        <input type="submit" class="boton" value="Guardar Servicio">
    </form>
</div>
