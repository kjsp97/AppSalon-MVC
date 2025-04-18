
<h1 class="nombre-app">Restablecer Contraseña</h1>
<p class="descripcion-app">Llena los siguientes campos</p>
<?php require_once __DIR__ . '/../templates/alertas.php' ?>
<?php if ($error){return;}?>
<div class="formulario">
    <form method="POST">
        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Nueva contraseña *">
        </div>
        <div class="campo">
            <label for="password2">Confirmar</label>
            <input type="password" id="password2" name="password2" placeholder="Confimar contraseña *">
        </div>
        <div>
            <input class="boton" type="submit" value="Guardar">
        </div>
    </form>
    <div class="acciones">
        <a href="/"> Volver a Inicio</a>
    </div>
</div>