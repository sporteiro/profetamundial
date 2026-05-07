<?php
if (!isset($_SESSION)) {
  session_start();
}?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro exitoso - Profeta Mundial</title>
    <link href="estilo.css" rel="stylesheet" type="text/css">
    <link href="css/mundial2026.css" rel="stylesheet" type="text/css">
</head>
<body class="register-body">
    <div class="register-card" style="max-width: 500px;">
        <img src="imagenes/profetamundial.png" alt="Profeta Mundial" class="logo">
        <h2>Gracias por registrarte</h2>
        <div style="text-align: center;">
            <p style="color: #e2e8f0; font-size: 1.1rem;">Para poder aceder a tu cuenta, es necesario que la actives desde tu correo electronico</p>
            <p style="color: #e2e8f0;">Si no encontras el correo, revisa tu bandeja de correo no deseado</p>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="index.php" class="btn-small">cerrar</a>
        </div>
    </div>
</body>
</html>