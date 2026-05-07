<?php
require_once('Connections/conexion.php');

if (!isset($_SESSION)) {
    session_start();
}

// Logout (igual que en empezar.php)
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
<?php require_once('header.php'); ?>

<div class="main-container">
    <div class="modern-card welcome-card" style="text-align: center; margin-bottom: 20px;">
        <h2>Términos generales de uso</h2>
    </div>
    <div class="modern-card" style="text-align: left; line-height: 1.6;">
        <p>Al usar y/o ingresar a este sitio de Internet, usted acepta y sujeta expresamente a los presentes términos y condiciones. Si usted no esta de acuerdo con cualquiera de los Términos de Servicio, por favor no utilice el Sitio de Internet Profeta Mundial.</p>
        <p>Profetamundial.com, ProfetaMundial.com, (en adelante Profeta Mundial) podrá, a su sola discreción, modificar o enmendar estos Términos de Servicio y políticas en cualquier momento, y usted acepta expresamente que quedará sujeto a dichas modificaciones o enmiendas. Nada de lo establecido en el presente Contrato deberá ser considerado como un otorgamiento de derechos o beneficios a terceros.</p>
        <p>El Sitio de Internet Profeta Mundial puede contener enlaces a sitios de Internet de terceras personas que no son propiedad de ni son controlados por Profeta Mundial. Profeta Mundial no tiene control alguno sobre, y no asume responsabilidad alguna por el contenido, políticas de privacidad o prácticas de ningún sitio de Internet propiedad de o bajo el control de terceros. En adición, Profeta Mundial no censurará y no podrá censurar o editar el contenido de ningún sitio propiedad de o controlado por un tercero. Al utilizar y/o visitar el Sitio de Internet, usted libera expresamente a Profeta Mundial de toda y cualquier responsabilidad que derivada del uso que usted haga de un sitio de Internet de un tercero.</p>
        <p>El contenido del sitio de Internet Profeta Mundial, son propiedad de Profeta Mundial. El Contenido del Sitio de Internet es proveído para su información y uso personal solamente y el mismo no podrá ser descargado, copiado, reproducido, distribuido, transferido, transmitido, expuesto, vendido, licenciado o explotado de cualquier otra forma para cualquier propósito sin el consentimiento previo y por escrito de los correspondientes dueños. Profeta Mundial se reserva todos los derechos que no se encuentran expresamente otorgados en y para el Sitio de Internet y el Contenido.</p>
        <p>Las cuentas de usuario y toda la información contenida en ellas, son propiedad exclusiva de Profeta Mundial, que a su sola discreción, y sin previo aviso, es libre de modificar, cancelar, bloquear o eliminar completa o parcialmente la información introducida en estas, sin por ello tener que dar ningún tipo de explicación o información adicional a la/las personas que introdujeron dichos datos. Profeta Mundial se reserva también el derecho de admisión, readmisión, expulsión, bloqueo de usuarios y cualquier derecho relacionado con el uso del sitio profetamundial.com</p>
        <p>Usted entiende que al utilizar el Sitio de Internet Profeta Mundial, usted estará expuesto a Contribuciones de Usuarios de una gran variedad de fuentes y que Profeta Mundial no es responsable por la exactitud, utilidad, seguridad o derechos de propiedad intelectual relacionados con dichas Contribuciones de Usuarios. Usted adicionalmente entiende y acepta que puede ser expuesto a Contribuciones de Usuarios que pueden ser imprecisas, ofensivas, indecentes u objetables y usted se obliga a renunciar y por medio del presente renuncia a cualquier derecho o defensa legal, ya sea en dinero o de cualquier otra forma que tenga o pueda tener en contra de Profeta Mundial al respecto y se obliga a indemnizar y mantener a Profeta Mundial, sus Propietarios/ Operadores, afiliados y/o licenciantes, libres de cualquier daño o reclamación de conformidad con las leyes correspondientes en todos los asuntos relacionados con el uso del Sitio de Internet.</p>
        <p>Usted declara la plena aceptación por su parte a entregar datos personales a Profeta Mundial de manera completamente voluntaria. Profeta Mundial no se hace responsable del uso de estos datos por causas ajenas a su control ni de ningún otro tipo.</p>
        <p>Usted declara y reconoce que es una persona física mayor de 18 años o un menor emancipado o que posee autorización por parte de sus padres o tutores y que es totalmente capaz y competente para obligarse bajo los presentes términos, condiciones, obligaciones, afirmaciones, declaraciones y garantías de conformidad con lo establecido en los presentes Términos del Servicio y para sujetarse y cumplir con los mismos.</p>
        <div style="text-align: center; margin-top: 30px;">
            <a href="empezar.php" class="btn-small">VOLVER</a>
        </div>
    </div>
</div>

<?php
mysqli_free_result($recordusuarios);
require_once('footer.php');
?>