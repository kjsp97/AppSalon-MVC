<h1 class="nombre-app">Restablecer Contraseña</h1>
<p class="descripcion-app">Enviar al correo electronico</p>
<?php require_once __DIR__ . '/../templates/alertas.php' ?>
<div class="formulario">
    <form class="formulario" method="POST" action="/olvidado">

        <div class="campo">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Tu email registrado">
        </div>
        <div>
            <input class="boton" type="submit" value="Enviar">
        </div>
    </form>
    <div class="acciones">
        <a href="/"> Volver a Inicio</a>
    </div>
</div>