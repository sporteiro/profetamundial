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

// Restricción de acceso (igual que antes)
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

// Función auxiliar
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

// Consulta de datos del usuario (para mostrar en cabecera, el header ya lo hace, pero lo dejamos por compatibilidad)
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

<!-- Contenido principal (dentro del .main-container que ya abre header.php) -->
<div class="modern-card welcome-card" style="text-align: center; margin-bottom: 20px;">
    <h2>Reglas del juego</h2>
</div>

<div id="lista-reglas">
    <a href="reglas-mundial2026.php" class="botoneschicos">Copa Mundial FIFA 2026</a>
    <a href="reglas-mundial2022.php" class="botoneschicos">Copa Mundial FIFA 2022</a>
    <a href="reglas-mundial2018.php" class="botoneschicos">Copa Mundial FIFA 2018</a>
    <a href="reglas-america2015.php" class="botoneschicos">Copa America 2015</a>
    <a href="reglas-oscar2015.php" class="botoneschicos">Oscar 2015</a>
    <a href="reglas-oscar2014.php" class="botoneschicos">Oscar 2014</a>
    <a href="reglas-mundial2014.php" class="botoneschicos">Copa Mundial FIFA 2014</a>
    <a href="reglas-confederaciones.php" class="botoneschicos">Copa Confederaciones 2013</a>
    <a href="reglas-oscar2013.php" class="botoneschicos">Oscar 2013</a>
    <a href="reglas-olimpiadas2012.php" class="botoneschicos">Olimpiadas 2012</a>
    <a href="reglas-eurocopa.php" class="botoneschicos">Eurocopa</a>
    <a href="reglas-america2011.php" class="botoneschicos">Copa America</a>
    <a href="reglas-mundial2010.php" class="botoneschicos">Mundial 2010</a>
    <a href="reglas-oscar2016.php" class="botoneschicos">Oscar 2016</a>
    <a href="reglas-oscar2017.php" class="botoneschicos">Oscar 2017</a>
    <a href="reglas-oscar2019.php" class="botoneschicos">Oscar 2019</a>
    <a href="reglas-oscar2020.php" class="botoneschicos">Oscar 2020</a>
    <a href="reglas-oscar2022.php" class="botoneschicos">Oscar 2022</a>
</div>

<?php
mysqli_free_result($recordusuarios);
require_once('footer.php'); // Pie moderno unificado
?>