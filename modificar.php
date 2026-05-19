<?php
require_once('Connections/conexion.php');

if (!isset($_SESSION)) {
    session_start();
}

$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != "") {
    $logoutAction .= "&". htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_GET['doLogout']) && $_GET['doLogout'] == "true") {
    mysqli_query($conexion, "UPDATE usuarios SET enlinea='no' WHERE usuario='".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."'") or die(mysqli_error($conexion));
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
    setcookie('pid', '', time() - 3600, '/');
    setcookie('pis', '', time() - 3600, '/');
    header("Location: index.php");
    exit;
}

$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
    $isValid = false;
    if (!empty($UserName)) {
        $arrUsers = explode(",", $strUsers);
        $arrGroups = explode(",", $strGroups);
        if (in_array($UserName, $arrUsers)) $isValid = true;
        if (in_array($UserGroup, $arrGroups)) $isValid = true;
        if (($strUsers == "") && true) $isValid = true;
    }
    return $isValid;
}

$MM_restrictGoTo = "index.php";
if (!(isset($_SESSION['MM_Username']) && isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup']))) {
    $MM_qsChar = "?";
    $MM_referrer = $_SERVER['PHP_SELF'];
    if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
    if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) $MM_referrer .= "?" . $QUERY_STRING;
    $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
    header("Location: " . $MM_restrictGoTo);
    exit;
}

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        if (PHP_VERSION < 6) $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        global $conexion;
        $theValue = mysqli_real_escape_string($conexion, $theValue);
        switch ($theType) {
            case "text":   return ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            case "long": case "int": return ($theValue != "") ? intval($theValue) : "NULL";
            case "double": return ($theValue != "") ? doubleval($theValue) : "NULL";
            case "date":   return ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            case "defined":return ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        }
        return "NULL";
    }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $updateSQL = sprintf("UPDATE usuarios SET contrasena=%s, nombre=%s, email=%s, ip=%s WHERE usuario=%s",
                         GetSQLValueString(sha1($_POST['contrasena']), "text"),
                         GetSQLValueString($_POST['nombre'], "text"),
                         GetSQLValueString($_POST['email'], "text"),
                         GetSQLValueString($_POST['ocultoip'], "text"),
                         GetSQLValueString($_POST['ocultusuario'], "text"));
    $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));

    if ($_FILES['imagen']['name'] != '') {
        $rutaimagenes = 'imagenes/avatares/';
        $tipo_imagen = $_FILES["imagen"]["type"];
        if ((($tipo_imagen == "image/jpeg") || ($tipo_imagen == "image/png") || ($tipo_imagen == "image/gif")) && ($_FILES["imagen"]["size"] < 250000)) {
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaimagenes . $_FILES["imagen"]["name"]);
            $updateSQL = sprintf("UPDATE usuarios SET avatar=%s WHERE usuario=%s",
                                 GetSQLValueString($_FILES['imagen']['name'], "text"),
                                 GetSQLValueString($_POST['ocultusuario'], "text"));
            $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));
        } else {
            header('Location: modificar.php?error=1');
            exit;
        }
    }
    header("Location: empezar.php");
    exit;
}

$colname_recordusuarios = "-1";
if (isset($_SESSION['MM_Username'])) $colname_recordusuarios = $_SESSION['MM_Username'];
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$recordusuarios = mysqli_query($conexion, $query_recordusuarios) or die(mysqli_error($conexion));
$row_recordusuarios = mysqli_fetch_assoc($recordusuarios);
$totalRows_recordusuarios = mysqli_num_rows($recordusuarios);

$query_usutorneo = "SELECT * FROM Torneos WHERE inscriptos = '".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."'";
$usutorneo = mysqli_query($conexion, $query_usutorneo) or die(mysqli_error($conexion));
$row_usutorneo = mysqli_fetch_assoc($usutorneo);
$totalRows_usutorneo = mysqli_num_rows($usutorneo);

function getIP() {
    if (isset($_SERVER)) {
        return isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    } else {
        return isset($GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDER_FOR']) ? $GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDED_FOR'] : $GLOBALS['HTTP_SERVER_VARS']['REMOTE_ADDR'];
    }
}

// Incluir la cabecera moderna
require_once('header.php');
?>

<div class="grid-2cols" style="margin-top: 20px;">
    <!-- Formulario de modificación de datos -->
    <div class="modern-card">
        <h3>✏️ Modificar mis datos</h3>
        <div style="display: flex; align-items: flex-start; gap: 20px; flex-wrap: wrap;">
            <div style="text-align: center;">
                <img src="imagenes/avatares/<?php echo htmlspecialchars($row_recordusuarios['avatar']); ?>" width="80" height="80" style="border-radius: 50%;">
                <p><strong><?php echo htmlspecialchars($row_recordusuarios['usuario']); ?></strong></p>
            </div>
            <div style="flex: 1;">
                <form method="post" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
                    <input name="ocultusuario" type="hidden" value="<?php echo $row_recordusuarios['usuario']; ?>">
                    <div class="form-group">
                        <label>Nombre real</label>
                        <input type="text" name="nombre" class="modern-textarea" value="<?php echo htmlspecialchars($row_recordusuarios['nombre']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Contraseña antigua</label>
                        <input type="password" name="contrasenantigua" id="contrasenantigua" class="modern-textarea" required>
                        <input type="hidden" name="antigua" value="<?php echo $row_recordusuarios['contrasena']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Contraseña nueva (dejar en blanco si no cambia)</label>
                        <input type="password" name="contrasena" id="contrasena" class="modern-textarea">
                    </div>
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" name="email" class="modern-textarea" value="<?php echo htmlspecialchars($row_recordusuarios['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Avatar (jpg, png, gif, máximo 250KB)</label>
                        <input type="file" name="imagen" accept="image/jpeg,image/png,image/gif" class="btn-small" style="background:#334155; width: auto;">
                        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                            <p style="color:#f87171;">Error al subir la imagen. Asegúrate de que sea jpg, png o gif y pese menos de 250KB.</p>
                        <?php endif; ?>
                    </div>
                    <input name="ocultoip" type="hidden" value="primera ip <?php echo $row_recordusuarios['ip']; ?>, segunda ip <?php echo getIP(); ?>">
                    <button type="submit" name="modificar" class="btn-small">Guardar cambios</button>
                    <input type="hidden" name="MM_update" value="form1">
                </form>
            </div>
        </div>
    </div>

    <!-- Columna derecha: pronósticos y trofeos -->
    <div>
        <div class="modern-card">
            <h3>🏆 Mis pronósticos</h3>
            <?php if ($totalRows_usutorneo > 0): ?>
                <?php do { ?>
                    <p><a href="<?php echo $row_usutorneo['nombreT']; ?>.php" class="participante-link"><?php echo htmlspecialchars($row_usutorneo['descripcion']); ?></a></p>
                <?php } while ($row_usutorneo = mysqli_fetch_assoc($usutorneo)); ?>
            <?php else: ?>
                <p>No tienes pronósticos activos.</p>
            <?php endif; ?>
            <hr class="modern-hr">
            <p><strong>Crédito disponible:</strong> <?php echo $row_recordusuarios['credito']; ?> &phi;</p>
            <p>¡Gracias por participar!</p>
        </div>
        <div class="modern-card">
            <h3>🏅 Mis trofeos</h3>
            <div class="trofeo-lista" style="background:#0f172a; padding: 12px; border-radius: 16px;">
                <?php echo $row_recordusuarios['trofeos'] ?: 'Todavía no has ganado trofeos.'; ?>
            </div>
        </div>
        <?php if (isset($_SESSION['MM_Username']) && $_SESSION['MM_Username'] === 'ProfetaMundial'): ?>
        <div class="modern-card">
            <h3>🛠️ Administración</h3>
            <p><a href="contacto_administrador.php" class="btn-small">Enviar emails</a></p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
// Incluir el pie de página moderno
require_once('footer.php');
// Liberar recursos
mysqli_free_result($recordusuarios);
?>