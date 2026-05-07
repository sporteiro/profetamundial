<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profeta Mundial - Ingresar</title>
    <link href="estilo.css" rel="stylesheet" type="text/css">
    <link href="css/mundial2026.css" rel="stylesheet" type="text/css">
</head>
<body class="login-body">
    <div class="login-card">
        <img src="imagenes/profetamundial.png" alt="Profeta Mundial" class="logo">
        <h2>Iniciar Sesión</h2>
        <p class="mensaje-error">El usuario o la contraseña introducidos son incorrectos</p>
        <form method="POST" action="<?php echo $loginFormAction; ?>">
            <div class="form-group">
                <label for="usuario">Nombre de usuario</label>
                <input type="text" name="usuario" id="usuario" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" required>
            </div>
            <button type="submit" class="btn">Ingresá</button>
        </form>
        <div class="link-footer">
            <p><a href="contrasena.php">Olvidé mi contraseña</a></p>
        </div>
    </div>
</body>
</html>