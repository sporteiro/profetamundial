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

// No necesitamos GetSQLValueString ni consulta de usuario para esta página, pero la dejamos por compatibilidad
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
?>
<?php require_once('header.php'); ?>

<div class="main-container reglas-mundial-container">
    <div class="modern-card welcome-card" style="text-align: center; margin-bottom: 20px;">
        <h2>Reglas del Juego – Copa Mundial de la FIFA 2026</h2>
    </div>
    <div class="modern-card reglas-contenido">
        <p><strong>GANADOR DEL JUEGO</strong></p>
        <p>El/la ganador/a o los ganadores/as serán aquellos usuarios que consigan más puntos al término de la Copa Mundial de la FIFA 2026 (<strong>formato 48 selecciones, 12 grupos de 4 equipos, dieciseisavos, octavos, cuartos, semifinales, tercer puesto y final</strong>). Los puntos se asignan según los criterios del <strong>Sistema de Puntuación</strong>.</p>
        
        <p><strong>SISTEMA DE PUNTUACIÓN</strong></p>
        <p><strong>Resultado exacto:</strong> número de goles de local y visitante (asociados a los equipos). Ejemplo: "Argentina 3 México 0".<br />
        <strong>Resultado del partido:</strong> victoria local, victoria visitante o empate (solo en la primera ronda; en eliminatorias directas, si el partido termina empatado tras 90' + prórroga, se considera empate y se aplica el selector "Si empatan, elegí").<br />
        <strong>¡IMPORTANTE!</strong> En los partidos eliminatorios, la tanda de penales NO se tiene en cuenta para el resultado del partido ni para el resultado exacto. Solo cuenta el marcador final después de la prórroga.</p>
        
        <p><strong>FASE DE GRUPOS</strong></p>
        <p>Se compone de 12 grupos (A a L) de 4 selecciones cada uno. Se juegan 6 partidos por grupo.</p>
        <table class="tabla-grupo-ver" style="width: 100%; margin: 10px 0;">
            <tr><th>Tipo de acierto</th><th>Puntos</th></tr>
            <tr><td>Resultado exacto (goles de cada equipo)</td><td>5</td></tr>
            <tr><td>Resultado del partido (local, visitante, empate)</td><td>1</td></tr>
        </table>
        <p>Ejemplo: Real: Argentina 3 México 0. Usuario pronostica Argentina 1 México 0 → 1 punto (acertó victoria local). Si pronostica Argentina 3 México 0 → 5 puntos. No se suman puntos extra por resultado del partido ya que está incluido.</p>
        
        <p><strong>FASE ELIMINATORIA (desde dieciseisavos hasta la final)</strong></p>
        <p>La fase final comienza con los 32avos de final (partidos 73 a 88), luego octavos (89-96), cuartos (97-100), semifinales (101-102), partido por el tercer puesto (103) y final (104). El sistema actualiza automáticamente los enfrentamientos cuando se modifican los grupos, respetando los goles que hayas ingresado.</p>
        <table class="tabla-grupo-ver" style="width: 100%; margin: 10px 0;">
            <tr><th>Tipo de acierto</th><th>Puntos</th></tr>
            <tr><td>Resultado exacto (goles de cada equipo)</td><td>5</td></tr>
            <tr><td>Resultado del partido (local, visitante, empate)</td><td>2</td></tr>
        </table>
        <p>Ejemplo: Real: Uruguay 3 Nigeria 0. Usuario pronostica Uruguay 1 Nigeria 0 → 2 puntos (acertó victoria local). Si además eligió como clasificado a Uruguay (en caso de empate), suma los puntos correspondientes.</p>
        
        <p><strong>DETERMINACIÓN DE POSICIONES EN GRUPOS (para el juego)</strong></p>
        <p>Para calcular los puestos de cada grupo, el sistema aplica el siguiente orden de criterios (similar al oficial, pero sin fair play ni sorteo real):</p>
        <ol>
            <li>Mayor número de puntos</li>
            <li>Diferencia de goles (goles a favor – goles en contra)</li>
            <li>Mayor número de goles a favor</li>
            <li><strong>Resultado del partido directo entre los equipos empatados</strong> (si solo hay dos)</li>
            <li><strong>Orden alfabético (de menor a mayor según nombre del país)</strong> – en caso de persistir el empate (esto sustituye al sorteo o fair play real)</li>
        </ol>
        <p>En empates de tres o más equipos, se comparan los puntos obtenidos en los partidos entre ellos; si aún persiste, se aplica diferencia de goles y goles a favor en esos partidos; finalmente, orden alfabético.</p>
        
        <p><strong>EXTRAS</strong></p>
        <p>Puntos adicionales que se suman al total independientemente de los aciertos por partido.</p>
        <table class="tabla-grupo-ver" style="width: 100%; margin: 10px 0;">
            <tr><th>Tipo de acierto</th><th>Puntos</th></tr>
            <tr><td>Equipo campeón</td><td>15</td></tr>
            <tr><td>Goleador (apellido del jugador, o uno de ellos en caso de empate)</td><td>10</td></tr>
            <tr><td>Por cada equipo que clasifica a una fase (dieciseisavos, octavos, cuartos, semifinales, tercer puesto, final) COINCIDIENDO con tu pronóstico</td><td>1</td></tr>
            <tr><td>Acertar el tercer puesto (ganador del partido 103)</td><td>5</td></tr>
        </table>
        <p>Los puntos por equipos en fases se otorgan automáticamente según los equipos que hayas pronosticado en cada cruce (no es necesario seleccionarlos manualmente más allá de los partidos).</p>
        
        <p><strong>IMPORTANTE: PUNTUACIÓN POR FASES</strong></p>
        <p>Los puntos por equipos que avanzan a cada fase se calculan únicamente cuando <strong>todos los partidos de la fase anterior han sido jugados</strong>. Esto evita que se otorguen puntos por equipos que aún no han confirmado su clasificación en la realidad.</p>
        <ul>
            <li><strong>Dieciseisavos:</strong> se puntúan solo cuando <strong>todos</strong> los partidos de la fase de grupos (1-72) están completos.</li>
            <li><strong>Octavos:</strong> se puntúan cuando <strong>todos</strong> los dieciseisavos (73-88) están completos.</li>
            <li><strong>Cuartos:</strong> cuando todos los octavos (89-96) están completos.</li>
            <li><strong>Semifinales:</strong> cuando todos los cuartos (97-100) están completos.</li>
            <li><strong>Final y tercer puesto:</strong> cuando las semifinales (101-102) están completas.</li>
        </ul>
        <p><strong>ACTUALIZACIÓN EN CASCADA</strong></p>
        <p>Cada vez que modifiques un resultado de fase de grupos, el sistema actualizará automáticamente los enfrentamientos de la fase final para reflejar los nuevos clasificados, manteniendo tus pronósticos de goles donde sea posible. Si el cambio afecta a qué equipo avanza, se recalcularán los cruces posteriores.</p>
        
        <p><strong>FECHA LÍMITE DE PARTICIPACIÓN</strong></p>
        <p>El 9 de junio de 2026 a las 23:00 horas (CET) finalizará el plazo para registrarse y/o modificar pronósticos. Después de esa fecha solo se podrá consultar la cuenta, sin editar resultados.</p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="empezar.php" class="btn-small">VOLVER</a>
        </div>
    </div>
</div>

<?php
mysqli_free_result($recordusuarios);
require_once('footer.php');
?>