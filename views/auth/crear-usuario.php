
<h1 class="nombre-app">Crear Usuario</h1>
<p class="descripcion-app">Registrate con tus datos completos</p>
<?php require_once __DIR__ . '/../templates/alertas.php' ?>
<div class="formulario">
    <form method="POST" action="/crear">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="nombre" id="nombre" name="nombre" placeholder="Nombre completo *" value="<?php echo s($usuario->nombre);?>">
        </div>
        <div class="campo">
            <label for="apellido">Apellido</label>
            <input type="apellido" id="apellido" name="apellido" placeholder="Apellidos completos *" value="<?php echo s($usuario->apellido);?>">
        </div>
        <div class="campo">
            <label for="movil">Movil</label>
            <input type="movil" id="movil" name="movil" placeholder="Numero movil *" value="<?php echo s($usuario->movil);?>">
        </div>
        <div class="campo">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Tu email personal *" value="<?php echo s($usuario->email);?>">
        </div>
        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Contraseña *">
        </div>
        <div>
            <input class="boton" type="submit" value="Crear usuario">
        </div>
    </form>
    <div class="acciones">
        <a href="/">Volver a Inicio</a>
        <a href="/olvidado">Olvide mi contraseña</a>
    </div>
</div>