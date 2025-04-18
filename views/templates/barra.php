<div id="app">
    <div class="menu-usuario">
        <p>Hola, <?php echo $_SESSION['nombre'] ?></p>
        <a href="/logout">Cerrar Sesion</a>
    </div>
</div>

<?php
if (isset($_SESSION['admin'])) {?>
<div class="barra-admin">
    <a href="/admin" class="boton">Ver Citas</a>
    <a href="/servicios" class="boton">Ver Servicios</a>
    <a href="/servicios/crear" class="boton">Nuevo Servicio</a>
</div>

<?php } ?>