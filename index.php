<?php
require_once('Connections/conexion.php');
session_start();

// Función auxiliar (necesaria para la consulta de cookies)
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }
        global $conexion;
        $theValue = mysqli_real_escape_string($conexion, $theValue);
        switch ($theType) {
            case "text":
                return ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            case "long":
            case "int":
                return ($theValue != "") ? intval($theValue) : "NULL";
            case "double":
                return ($theValue != "") ? doubleval($theValue) : "NULL";
            case "date":
                return ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            case "defined":
                return ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        }
        return "NULL";
    }
}

// 1. Si ya hay sesión iniciada, redirigir directamente a empezar.php
if (isset($_SESSION['MM_Username'])) {
    header("Location: empezar.php");
    exit;
}

// 2. Verificar cookies de recordar (pid y pis)
if (isset($_COOKIE['pid']) && isset($_COOKIE['pis'])) {
    $cookie_user = $_COOKIE['pid'];
    $cookie_pass = $_COOKIE['pis']; // ya viene en sha1

    $query = sprintf("SELECT usuario, contrasena, activo FROM usuarios WHERE BINARY usuario = %s AND contrasena = %s",
                     GetSQLValueString($cookie_user, "text"),
                     GetSQLValueString($cookie_pass, "text"));
    $rs = mysqli_query($conexion, $query);
    if ($rs && mysqli_num_rows($rs) == 1) {
        $row = mysqli_fetch_assoc($rs);
        if ($row['activo'] != 'no') {
            $_SESSION['MM_Username'] = $row['usuario'];
            $_SESSION['MM_UserGroup'] = '';
            // Actualizar estado en línea
            mysqli_query($conexion, "UPDATE usuarios SET enlinea='si' WHERE usuario='" . mysqli_real_escape_string($conexion, $row['usuario']) . "'");
            header("Location: empezar.php");
            exit;
        }
    }
}
// Si llega aquí, mostrar la página normal
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profeta Mundial</title>
    <link href="estilo.css?v=2.0" rel="stylesheet" type="text/css">
    <link href="css/mundial2026.css?v=2.0" rel="stylesheet" type="text/css">
</head>
<body class="home-page">
    <div class="home-card">
        <img src="imagenes/profetamundial.png" alt="Profeta Mundial" class="home-logo">
        <div class="home-title">¡Participá ya en el pronóstico del Mundial 2026!</div>
        
        <div class="home-buttons">
            <a href="ingresar.php" class="btn-home">ENTRAR</a>
            <a href="registrarse.php" class="btn-home">REGISTRARSE</a>
        </div>
        
        <div>
            <a href="contacto_anonimo.php" class="btn-contact-home">Contacto</a>
        </div>

        <!-- Descarga de APK (discreto, al fondo) -->
        <div class="apk-section" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #334155;">
            <p style="color: #64748b; font-size: 0.8rem; margin-bottom: 8px;">
                📱 ¿Querés más comodidad? Instalá nuestra app
            </p>
            <a href="profetamundial.apk" class="btn-contact-home" download style="font-size: 0.8rem;">
                📥 Descargar App para Android
            </a>
            <p style="color: #475569; font-size: 0.65rem; margin-top: 6px;">
                Archivo APK · Instalación manual requerida
            </p>
        </div>
        
        <div class="home-footer">
            Done by <a href="https://sebastianporteiro.com" target="_blank">Sebastian Porteiro</a>
        </div>
    </div>
</body>
</html>