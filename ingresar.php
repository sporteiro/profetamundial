<?php
// ============================================
// ingresar.php con auto-login por cookies
// ============================================
require_once('Connections/conexion.php');

if (!function_exists('GetSQLValueString')) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = '', $theNotDefinedValue = '')
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }
        global $conexion;
        $theValue = mysqli_real_escape_string($conexion, $theValue);
        switch ($theType) {
            case 'text':
                $theValue = ($theValue != '') ? "'" . $theValue . "'" : 'NULL';
                break;
            case 'long':
            case 'int':
                $theValue = ($theValue != '') ? intval($theValue) : 'NULL';
                break;
            case 'double':
                $theValue = ($theValue != '') ? doubleval($theValue) : 'NULL';
                break;
            case 'date':
                $theValue = ($theValue != '') ? "'" . $theValue . "'" : 'NULL';
                break;
            case 'defined':
                $theValue = ($theValue != '') ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
}

session_start();

// ** AUTO-LOGIN mediante cookies **
if (!isset($_SESSION['MM_Username']) && isset($_COOKIE['pid']) && isset($_COOKIE['pis'])) {
    $cookie_user = $_COOKIE['pid'];
    $cookie_pass = $_COOKIE['pis'];  // ya viene hasheado con sha1
    mysql_select_db($database_conexion, $conexion);
    $query = sprintf("SELECT usuario, contrasena, activo FROM usuarios WHERE BINARY usuario=%s AND contrasena=%s",
                     GetSQLValueString($cookie_user, 'text'),
                     GetSQLValueString($cookie_pass, 'text'));
    $rs = mysql_query($query, $conexion) or die(mysql_error());
    if (mysql_num_rows($rs) == 1) {
        $row = mysql_fetch_assoc($rs);
        if ($row['activo'] != 'no') {
            $_SESSION['MM_Username'] = $row['usuario'];
            $_SESSION['MM_UserGroup'] = '';
            // Actualizar estado en línea
            mysql_query("UPDATE usuarios SET enlinea='si' WHERE usuario='" . mysqli_real_escape_string($conexion, $row['usuario']) . "'");
            header("Location: empezar.php");
            exit;
        }
    }
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

$error_msg = '';
if (isset($_GET['error']) && $_GET['error'] == '1') {
    $error_msg = '<p class="error-message">El usuario o la contraseña introducidos son incorrectos.</p>';
}

if (isset($_POST['usuario'])) {
    $loginUsername = $_POST['usuario'];
    $password = ($_POST['enc'] == 0) ? sha1($_POST['contrasena']) : $_POST['contrasena'];
    $MM_redirectLoginSuccess = 'empezar.php';
    $MM_redirectLoginFailed = 'no.php';

    mysql_select_db($database_conexion, $conexion);
    $LoginRS__query = sprintf('SELECT usuario, contrasena, activo FROM usuarios WHERE BINARY usuario=%s AND contrasena=%s',
        GetSQLValueString($loginUsername, 'text'),
        GetSQLValueString($password, 'text'));
    $LoginRS = mysql_query($LoginRS__query, $conexion) or die(mysql_error());
    $loginFoundUser = mysql_num_rows($LoginRS);

    if ($loginFoundUser) {
        $filas = mysql_fetch_assoc($LoginRS);
        $activo = $filas['activo'];
    } else {
        $activo = 'no';
    }

    if ($activo == 'no') {
        include_once('desactivada.php');
        exit;
    } elseif ($loginFoundUser) {
        $_SESSION['MM_Username'] = $loginUsername;
        $_SESSION['MM_UserGroup'] = '';

        // Guardar cookie si marcó "recordar"
        if (isset($_POST['recordar'])) {
            setcookie('pis', sha1($_POST['contrasena']), time() + 3600 * 24 * 365, '/');
            setcookie('pid', $_POST['usuario'], time() + 3600 * 24 * 365, '/');
        } else {
            // Si no marcó, eliminar cookies existentes
            setcookie('pis', '', time() - 3600, '/');
            setcookie('pid', '', time() - 3600, '/');
        }

        mysql_query("UPDATE usuarios SET enlinea='si' WHERE usuario='" . mysqli_real_escape_string($conexion, $loginUsername) . "'");
        header('Location: ' . $MM_redirectLoginSuccess);
        exit;
    } else {
        header('Location: ' . $MM_redirectLoginFailed);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar - Profeta Mundial</title>
    <link href="estilo.css" rel="stylesheet" type="text/css">
    <link href="css/mundial2026.css" rel="stylesheet" type="text/css">
</head>
<body class="login-body">
    <div class="login-card">
        <img src="imagenes/profetamundial.png" alt="Profeta Mundial" class="logo">
        <h2>Iniciar Sesión</h2>
        <?php echo $error_msg; ?>
        <form method="POST" action="<?php echo htmlspecialchars($loginFormAction); ?>">
            <div class="form-group">
                <label for="usuario">Nombre de usuario</label>
                <input type="text" name="usuario" id="usuario" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" required>
            </div>
            <div class="checkbox-row">
                <input type="checkbox" name="recordar" value="1" id="recordar">
                <label for="recordar">Recordar mi sesión</label>
            </div>
            <input type="hidden" name="enc" value="0">
            <button type="submit" class="btn">ENTRAR</button>
        </form>
        <div class="link-footer">
            <p><a href="registrarse.php">¿No tenés cuenta? Registrate</a> | <a href="contrasena.php">Olvidé mi contraseña</a></p>
        </div>
    </div>
</body>
</html>