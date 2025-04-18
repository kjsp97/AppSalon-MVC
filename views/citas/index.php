<h1 class="nombre-app">Crea tu Cita</h1>

<?php include __DIR__ . '/../templates/barra.php' ?>

<nav class="tabs">
    <button type="button" data-paso="1">Servicios</button>
    <button type="button" data-paso="2">Información cita</button>
    <button type="button" data-paso="3">Resumen</button>
</nav>

<div id="paso-1" class="seccion">
    <h2>Servicios</h2>
    <p class="text-center">Elige tus servicios a continuación</p>
    <div id="servicios" class="listado-servicios"></div>
</div>

<div id ="alerta"></div>

<div id="paso-2" class="seccion">
    <h2>Tus Datos y Cita</h2>
    <p class="text-center">Coloca tus datos y fecha de tu cita</p>
    <form class="formulario">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" placeholder="nombre" value="<?php echo $_SESSION['nombre']?>" data-id="<?php echo $_SESSION['id']?>" disabled>

        </div>
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day'))?>">
        </div>
        <div class="campo">
            <label for="hora">Hora</label>
            <input type="time" id="hora">
        </div>
    </form>
</div>

<div id="paso-3" class="seccion contenido-resumen">
    <h2>Resumen</h2>
    <p class="text-center">Confirma la cita</p>
</div>

<div class="paginacion">
    <button id="anterior" class="button">&laquo; Anterior</button>
    <button id="siguiente" class="button">Siguiente &raquo;</button>
</div>

<?php $script = "
<script src='build/js/app.js'></script>
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
"; ?>