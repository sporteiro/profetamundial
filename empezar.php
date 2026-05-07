<?php
// ============================================================
// empezar.php – Panel de usuario (con usuarios conectados reales)
// ============================================================
require_once('Connections/conexion.php');
require_once __DIR__ . '/includes/mundial2026_seed.php';

if (!isset($_SESSION)) {
    session_start();
}

// ** Logout con eliminación de cookies **
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

// ========== RESTRICCIÓN DE ACCESO ==========
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

// ========== FUNCIONES Y CONSULTAS (igual que antes) ==========
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

// (Aquí van tus inserciones de mundial2022, mundial2026 – mantén tu código original)
// Procesar comentario
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formcomentar")) {
    $insertSQL = sprintf("INSERT INTO comentarios (comentario, usuario) VALUES (%s, %s)",
                         GetSQLValueString($_POST['comentario'], "text"),
                         GetSQLValueString($_POST['usuario'], "text"));
    mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));
    header("Location: empezar.php");
    exit;
}

// CONSULTAS (todas las que necesitas)
$maxRows_recordusuarios = 25;
$pageNum_recordusuarios = 0;
if (isset($_GET['pageNum_recordusuarios'])) $pageNum_recordusuarios = $_GET['pageNum_recordusuarios'];
$startRow_recordusuarios = $pageNum_recordusuarios * $maxRows_recordusuarios;
$colname_recordusuarios = "-1";
if (isset($_SESSION['MM_Username'])) $colname_recordusuarios = $_SESSION['MM_Username'];
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$query_limit_recordusuarios = sprintf("%s LIMIT %d, %d", $query_recordusuarios, $startRow_recordusuarios, $maxRows_recordusuarios);
$recordusuarios = mysqli_query($conexion, $query_limit_recordusuarios) or die(mysqli_error($conexion));
$row_recordusuarios = mysqli_fetch_assoc($recordusuarios);
if (isset($_GET['totalRows_recordusuarios'])) $totalRows_recordusuarios = $_GET['totalRows_recordusuarios'];
else {
    $all_recordusuarios = mysqli_query($conexion, $query_recordusuarios);
    $totalRows_recordusuarios = mysqli_num_rows($all_recordusuarios);
}
$totalPages_recordusuarios = ceil($totalRows_recordusuarios / $maxRows_recordusuarios) - 1;

$query_Recordtodoslosusuarios = "SELECT * FROM usuarios ORDER BY puntos DESC";
$Recordtodoslosusuarios = mysqli_query($conexion, $query_Recordtodoslosusuarios) or die(mysqli_error($conexion));
$row_Recordtodoslosusuarios = mysqli_fetch_assoc($Recordtodoslosusuarios);
$totalRows_Recordtodoslosusuarios = mysqli_num_rows($Recordtodoslosusuarios);

$maxRows_recormentarios = 64;
$pageNum_recormentarios = 0;
if (isset($_GET['pageNum_recormentarios'])) $pageNum_recormentarios = $_GET['pageNum_recormentarios'];
$startRow_recormentarios = $pageNum_recormentarios * $maxRows_recormentarios;
$query_recormentarios = "SELECT * FROM comentarios JOIN usuarios ON comentarios.usuario = usuarios.usuario ORDER BY id DESC";
$query_limit_recormentarios = sprintf("%s LIMIT %d, %d", $query_recormentarios, $startRow_recormentarios, $maxRows_recormentarios);
$recormentarios = mysqli_query($conexion, $query_limit_recormentarios) or die(mysqli_error($conexion));
if (isset($_GET['totalRows_recormentarios'])) $totalRows_recormentarios = $_GET['totalRows_recormentarios'];
else {
    $all_recormentarios = mysqli_query($conexion, $query_recormentarios);
    $totalRows_recormentarios = mysqli_num_rows($all_recormentarios);
}
$totalPages_recormentarios = ceil($totalRows_recormentarios / $maxRows_recormentarios) - 1;

$query_usutor20 = "SELECT * FROM Torneos WHERE inscriptos LIKE '" . mysqli_real_escape_string($conexion, $_SESSION['MM_Username']) . "' AND CodTor='20';";
$usutor20 = mysqli_query($conexion, $query_usutor20) or die(mysqli_error($conexion));
$row_usutor20 = mysqli_fetch_assoc($usutor20);
$totalRows_usutor20 = mysqli_num_rows($usutor20);

$query_otrousuario_mundial2026 = "SELECT T.*, U.* FROM Torneos AS T JOIN usuarios AS U ON T.inscriptos = U.usuario WHERE CodTor='20' AND inscriptos != 'ProfetaMundial' ORDER BY U.puntos DESC";
$otrousuario_mundial2026 = mysqli_query($conexion, $query_otrousuario_mundial2026) or die(mysqli_error($conexion));
$row_otrousuario_mundial2026 = mysqli_fetch_assoc($otrousuario_mundial2026);
$totalRows_otrousuario_mundial2026 = mysqli_num_rows($otrousuario_mundial2026);

$query_enlinea = "SELECT * FROM usuarios WHERE enlinea='si' AND usuario != '" . mysqli_real_escape_string($conexion, $_SESSION['MM_Username']) . "' AND usuario != 'ProfetaMundial'";
$enlinea = mysqli_query($conexion, $query_enlinea) or die(mysqli_error($conexion));
$totalRows_enlinea = mysqli_num_rows($enlinea);

if (mundial2026_partidos_tiene_columna_fecha($conexion)) {
    $query_hoy_usu = "SELECT * FROM partidos_mundial2026 WHERE CodPar IN (SELECT CodPar FROM partidos_mundial2026 WHERE fecha_partido = CURDATE()) AND CodUsu != 'ProfetaMundial' AND local IN (SELECT local FROM partidos_mundial2026 WHERE fecha_partido = CURDATE() AND CodUsu = 'ProfetaMundial') AND visitante IN (SELECT visitante FROM partidos_mundial2026 WHERE fecha_partido = CURDATE() AND CodUsu = 'ProfetaMundial') ORDER BY CodPar, resultado, glocal, gvisitante, CodUsu";
} else {
    $query_hoy_usu = "SELECT * FROM partidos_mundial2026 WHERE 1 = 0";
}
$hoy_usu = mysqli_query($conexion, $query_hoy_usu) or die(mysqli_error($conexion));
$totalRows_hoy_usu = mysqli_num_rows($hoy_usu);

$today = date("YmdH");
$limiteMundial2026 = '2026061123';
$fueraTiempo2026 = ($limiteMundial2026 <= $today) ? 1 : 0;
?>
<?php require_once('header.php'); ?>

<div class="main-container">
    <?php if (isset($row_recordusuarios) && $row_recordusuarios): ?>
        <div class="modern-card welcome-card">
            <h2>Bienvenido, <?php echo htmlspecialchars($row_recordusuarios['usuario']); ?></h2>
            <p>Puntos totales: <strong><?php echo $row_recordusuarios['puntos']; ?></strong></p>
        </div>
    <?php endif; ?>

    <div class="grid-2cols">
        <!-- Columna izquierda -->
        <div>
            <div class="modern-card">
                <h3>⚽ Mis pronósticos</h3>
                <div style="text-align:center;">
                    <p><strong>¿Quién ganará la Copa Mundial 2026?</strong></p>
                    <?php if (!isset($totalRows_usutor20) || empty($row_usutor20['nombreT'])): ?>
                        <?php if (($fueraTiempo2026 == 0) || ($_SESSION['MM_Username'] == 'ProfetaMundial')): ?>
                            <form method="post" action="<?php echo $editFormAction; ?>">
                                <input type="submit" class="btn-small" value="Participar en Mundial 2026">
                                <input type="hidden" name="MM_insert" value="formmundial2026">
                            </form>
                        <?php else: ?>
                            <p style="color:#f87171;">Plazo de inscripción cerrado.</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="mundial2026.php" class="btn-small">Ver o modificar mi pronóstico 2026</a>
                    <?php endif; ?>
                </div>
                <hr class="modern-hr">
                <div style="text-align:center;">
                    <p><strong>Participantes Mundial 2026</strong> (<?php echo (int)($totalRows_otrousuario_mundial2026 ?? 0); ?>)</p>
                    <?php if (isset($totalRows_otrousuario_mundial2026) && $totalRows_otrousuario_mundial2026 > 0): ?>
                        <?php do { ?>
                            <a href="vermundial2026.php?verlode=<?php echo $row_otrousuario_mundial2026['inscriptos']; ?>" class="participante-link">
                                <?php echo htmlspecialchars($row_otrousuario_mundial2026['inscriptos']); ?> (<?php echo $row_otrousuario_mundial2026['puntos']; ?> pts)
                            </a>
                        <?php } while ($row_otrousuario_mundial2026 = mysqli_fetch_assoc($otrousuario_mundial2026)); ?>
                    <?php else: ?>
                        <p>No hay participantes aún.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="modern-card">
                <h3>🏆 Trofeos de todos los usuarios</h3>
                <div class="trofeos-wrapper">
                    <?php include_once('trofeos.php'); ?>
                </div>
            </div>
        </div>

        <!-- Columna derecha -->
        <div>
            <div class="modern-card">
                <h3>💬 Comentarios recientes</h3>
                <div class="comentarios-scroll">
                    <?php if (isset($recormentarios) && mysqli_num_rows($recormentarios) > 0): ?>
                        <?php while ($row_com = mysqli_fetch_assoc($recormentarios)): ?>
                            <div class="comentario-item">
                                <img src="imagenes/avatares/<?php echo htmlspecialchars($row_com['avatar']); ?>" width="28" height="28" alt="">
                                <strong><?php echo htmlspecialchars($row_com['usuario']); ?></strong> dijo:<br>
                                <?php echo nl2br(htmlspecialchars($row_com['comentario'])); ?>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No hay comentarios aún.</p>
                    <?php endif; ?>
                </div>
                <form method="POST" action="<?php echo $editFormAction; ?>" style="margin-top:15px;">
                    <input type="hidden" name="usuario" value="<?php echo $row_recordusuarios['usuario']; ?>">
                    <textarea name="comentario" rows="2" class="modern-textarea" placeholder="Escribe tu comentario..."></textarea>
                    <button type="submit" name="MM_insert" value="formcomentar" class="btn-small" style="margin-top:8px;">Comentar</button>
                </form>
            </div>

            <!-- Usuarios conectados (reemplaza el chat antiguo) -->
            <div class="modern-card">
                <h3>🟢 Usuarios conectados ahora</h3>
                <div id="listaConectados" class="chat-area">Cargando...</div>
            </div>
        </div>
    </div>
</div>

<script>
function actualizarConectados() {
    $.getJSON('conectados.php', function(data) {
        var html = '';
        if (data.length === 0) {
            html = '<p>No hay otros usuarios conectados.</p>';
        } else {
            html = '<ul style="list-style:none; padding-left:0;">';
            for (var i = 0; i < data.length; i++) {
                html += '<li><div class="puntoverde" style="display:inline-block; width:10px; height:10px; background:#0f0; border-radius:50%; margin-right:8px;"></div> ' + data[i] + '</li>';
            }
            html += '</ul>';
        }
        $('#listaConectados').html(html);
    });
}
function enviarHeartbeat() {
    $.get('heartbeat.php');
}
$(document).ready(function() {
    actualizarConectados();
    setInterval(actualizarConectados, 15000);
    setInterval(enviarHeartbeat, 30000);
});
window.addEventListener('beforeunload', function() {
    $.ajax({
        type: 'GET',
        async: false,
        url: 'connection_aborted.php?username=<?php echo $_SESSION['MM_Username']; ?>'
    });
});
</script>

<?php
mysqli_free_result($recordusuarios);
mysqli_free_result($Recordtodoslosusuarios);
mysqli_free_result($recormentarios);
?>
<?php require_once('footer.php'); ?>