<h1 class="nombre-app">Actualizar Servicio</h1>
<p class="descripcion-app">Modifica los siguientes campos</p>

<?php include __DIR__ . '/../templates/barra.php' ?>

<!-- <?php require_once __DIR__ . '/../templates/alertas.php' ?> -->
<div class="formulario">
    <form method="POST">
        <?php include 'formulario.php' ?>
        <div class="servicios-config">
            <a href="/servicios" class="boton">Volver</a>
            <input type="hidden" name="id" value="<?php echo $servicio->id ?>">
            <input type="submit" class="boton" value="Guardar Servicio">
        </div>
    </form>
</div>