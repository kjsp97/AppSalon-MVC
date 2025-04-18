<h1 class="nombre-app">Panel de Administracion</h1>

<?php include __DIR__ . '/../templates/barra.php' ?>

<h2>Buscador de Citas</h2>
<div>
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>
<?php if (count($citas) === 0) {?>
    <h3>No hay citas programadas para hoy</h3>
<?php } ?>
<div id="citas-admin">
    <ul class="cita">
        <?php 
            $idCita = 0;
        foreach ($citas as $key => $cita) {     
            if ($idCita !== $cita->id) {
                $total = 0;?>
        <li>
            <p>ID: <span><?php echo $cita->id ?></span></p>
            <p>Hora: <span><?php echo $cita->hora ?></span></p>
            <p>Cliente: <span><?php echo $cita->cliente ?></span></p>
            <p>Email: <span><?php echo $cita->email ?></span></p>
            <p>Movil: <span><?php echo $cita->movil ?></span></p>   
            <H3>Servicios</H3>
            <?php 
            $idCita = $cita->id;
            } ?>
        <p class="servicio"><?php echo $cita->servicio . ' ' . $cita->precio;?></p>
        <?php
        $total += $cita->precio;
        $actual = $cita->id;
        $proximo = $citas[$key + 1]->id ?? 0;

        if (lastOne($actual, $proximo)) {?>
        <p class="total">Total: <span><?php echo $total; ?></span></p>
        <form method="POST" action="/api/elimiar">
            <input type="hidden" name="id" value="<?php echo $cita->id ?>">
            <input type="submit" class="boton-eliminar" value="Eliminar Cita">
        </form>
        <?php }
        } ?>
        </li>
    </ul>
</div>
<?php $script = "<script src='build/js/buscador.js'></script>" ?>