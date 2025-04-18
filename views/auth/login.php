<h1 class="nombre-app">APP Salon</h1>
<p class="descripcion-app">Iniciar Sesión con tus datos</p>
<?php require_once __DIR__ . '/../templates/alertas.php' ?>
<div class="formulario">
    <form class="formulario" method="POST" action="/">
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Tu email">
        </div>
        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Tu contraseña">
        </div>
        <div>
            <input class="boton" type="submit" value="Iniciar Sesion">
        </div>
    </form>
    <div class="acciones">
        <a href="/crear">¿Aún no tienes cuenta? Registrate</a>
        <a href="/olvidado">Olvide mi contraseña</a>
    </div>
</div>