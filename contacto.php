<?php
require_once('Connections/conexion.php');

if (!isset($_SESSION)) {
    session_start();
}

// ** Logout (misma lógica que en empezar.php) **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != "") {
    $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_GET['doLogout']) && $_GET['doLogout'] == "true") {
    $u = mysqli_real_escape_string($conexion, $_SESSION['MM_Username']);
    mysqli_query($conexion, "UPDATE usuarios SET enlinea='no' WHERE usuario='$u'");
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

$colname_recordusuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
    $colname_recordusuarios = $_SESSION['MM_Username'];
}
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$recordusuarios = mysqli_query($conexion, $query_recordusuarios) or die(mysqli_error($conexion));
$row_recordusuarios = mysqli_fetch_assoc($recordusuarios);
$totalRows_recordusuarios = mysqli_num_rows($recordusuarios);
?>
<?php require_once('header.php'); // Cabecera moderna unificada ?>

<div class="modern-card welcome-card" style="text-align: center; margin-bottom: 20px;">
    <h2>Solución de Problemas</h2>
</div>

<div class="modern-card" style="max-width: 600px; margin: 0 auto;">
    <form method="post" action="enviarmensaje.php">
        <input name="usuario" type="hidden" value="<?php echo htmlspecialchars($row_recordusuarios['usuario']); ?>">
        <input name="motivo" type="hidden" value="solucion de problemas">
        <input name="nombre" type="hidden" value="<?php echo htmlspecialchars($row_recordusuarios['nombre']); ?>">
        <input name="email" type="hidden" value="<?php echo htmlspecialchars($row_recordusuarios['email']); ?>">
        <input name="origen" type="hidden" value="ProfetaMundial">

        <div class="form-group">
            <label>Nombre de usuario</label>
            <p><strong><?php echo htmlspecialchars($row_recordusuarios['usuario']); ?></strong></p>
        </div>
        <div class="form-group">
            <label>Nombre real</label>
            <p><strong><?php echo htmlspecialchars($row_recordusuarios['nombre']); ?></strong></p>
        </div>
        <div class="form-group">
            <label>Correo electrónico</label>
            <p><strong><?php echo htmlspecialchars($row_recordusuarios['email']); ?></strong></p>
        </div>
        <div class="form-group">
            <label>Descripción del problema</label>
            <textarea name="mensaje" rows="5" class="modern-textarea" required></textarea>
        </div>
        <div style="text-align: center;">
            <button type="submit" class="btn-small">Enviar mensaje</button>
            <a href="empezar.php" class="btn-small" style="background:#334155;">Volver</a>
        </div>
    </form>
</div>

<?php
mysqli_free_result($recordusuarios);
require_once('footer.php'); // Pie moderno unificado
?>