<h1 class="nombre-app">Servicios</h1>
<p class="descripcion-app">Listado de Servicios</p>
<?php require_once __DIR__ . '/../templates/alertas.php' ?>
<?php include __DIR__ . '/../templates/barra.php' ?>

<div class="servicios-listado">
    <?php 
    foreach ($servicios as $servicio) {?>
        <h2>Servicio nº <?php echo $servicio->id ?></h2>
        <p>Nombre: <span><?php echo $servicio->nombre ?></span></p>
        <p>Precio: <span><?php echo $servicio->precio ?></span></p>
        <div class="servicios-config">    
            <a href="servicios/actualizar?id=<?php echo $servicio->id ?>" class="boton">Actualizar</a>
                
            <form method="POST" action="servicios/eliminar">
                <input type="hidden" name="id" value="<?php echo $servicio->id ?>">
                <input type="submit" class="boton-eliminar" value="Eliminar Cita">
            </form>

        </div>
    <?php
    }
    ?>
</div>