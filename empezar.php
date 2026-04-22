<?php require_once('Connections/conexion.php'); ?>
<?php require_once __DIR__ . '/includes/mundial2026_seed.php'; ?>
<?php
$colname_Recordtodoslosusuarios=0;
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  mysqli_query($conexion, "UPDATE usuarios SET enlinea='no' WHERE usuario='".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."'") or die(mysqli_error($conexion));
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
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
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formmundial2022")) {
$insertSQLmundial2022 = "INSERT INTO partidos_mundial2022(`CodUsu`, `CodPar`, `local`, `visitante`, `glocal`, `gvisitante`, `resultado`) VALUES 

('".$_SESSION['MM_Username']."', 1, 'Senegal', 'Países Bajos', 0, 0, 0),
('".$_SESSION['MM_Username']."', 2, 'Qatar', 'Ecuador', 0, 0, 0),
('".$_SESSION['MM_Username']."', 3, 'Qatar', 'Senegal', 0, 0, 0),
('".$_SESSION['MM_Username']."', 4, 'Países Bajos', 'Ecuador', 0, 0, 0),
('".$_SESSION['MM_Username']."', 5, 'Ecuador', 'Senegal', 0, 0, 0),
('".$_SESSION['MM_Username']."', 6, 'Países Bajos', 'Qatar', 0, 0, 0),


('".$_SESSION['MM_Username']."', 7, 'Inglaterra', 'Irán', 0, 0, 0),
('".$_SESSION['MM_Username']."', 8, 'USA', 'Gales', 0, 0, 0),
('".$_SESSION['MM_Username']."', 9, 'Gales','Irán', 0, 0, 0),
('".$_SESSION['MM_Username']."', 10,'Inglaterra','USA', 0, 0, 0),
('".$_SESSION['MM_Username']."', 11,'Irán','USA', 0, 0, 0),
('".$_SESSION['MM_Username']."', 12,'Gales','Inglaterra', 0, 0, 0),	


('".$_SESSION['MM_Username']."', 13,'Argentina','Arabia Saudita', 0, 0, 0),
('".$_SESSION['MM_Username']."', 14,'México','Polonia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 15,'Polonia','Arabia Saudita', 0, 0, 0),
('".$_SESSION['MM_Username']."', 16,'Argentina','México', 0, 0, 0),
('".$_SESSION['MM_Username']."', 17,'Polonia','Argentina', 0, 0, 0),
('".$_SESSION['MM_Username']."', 18,'Arabia Saudita','México', 0, 0, 0),

('".$_SESSION['MM_Username']."', 19,'Dinamarca','Túnez', 0, 0, 0),
('".$_SESSION['MM_Username']."', 20,'Francia','Australia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 21,'Túnez','Australia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 22,'Francia','Dinamarca', 0, 0, 0),
('".$_SESSION['MM_Username']."', 23,'Australia','Dinamarca', 0, 0, 0),
('".$_SESSION['MM_Username']."', 24,'Túnez','Francia', 0, 0, 0),

('".$_SESSION['MM_Username']."', 25,'Alemania','Japón', 0, 0, 0),
('".$_SESSION['MM_Username']."', 26,'España','Costa Rica', 0, 0, 0),
('".$_SESSION['MM_Username']."', 27,'Japón','Costa Rica', 0, 0, 0),
('".$_SESSION['MM_Username']."', 28,'España','Alemania', 0, 0, 0),
('".$_SESSION['MM_Username']."', 29,'Japón','España', 0, 0, 0),
('".$_SESSION['MM_Username']."', 30,'Costa Rica','Alemania', 0, 0, 0),

('".$_SESSION['MM_Username']."', 31,'Marruecos','Croacia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 32,'Bélgica','Canada', 0, 0, 0),
('".$_SESSION['MM_Username']."', 33,'Bélgica','Marruecos', 0, 0, 0),
('".$_SESSION['MM_Username']."', 34,'Croacia','Canada', 0, 0, 0),
('".$_SESSION['MM_Username']."', 35,'Croacia','Bélgica', 0, 0, 0),
('".$_SESSION['MM_Username']."', 36,'Canada','Marruecos', 0, 0, 0),


('".$_SESSION['MM_Username']."', 37,'Suiza','Camerún', 0, 0, 0),
('".$_SESSION['MM_Username']."', 38,'Brasil','Serbia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 39,'Camerún','Serbia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 40,'Brasil','Suiza', 0, 0, 0),
('".$_SESSION['MM_Username']."', 41,'Serbia','Suiza', 0, 0, 0),
('".$_SESSION['MM_Username']."', 42,'Camerún','Brasil', 0, 0, 0),

('".$_SESSION['MM_Username']."', 43,'Uruguay','Corea del Sur', 0, 0, 0),
('".$_SESSION['MM_Username']."', 44,'Portugal','Ghana', 0, 0, 0),
('".$_SESSION['MM_Username']."', 45,'Corea del Sur','Ghana', 0, 0, 0),
('".$_SESSION['MM_Username']."', 46,'Portugal','Uruguay', 0, 0, 0),
('".$_SESSION['MM_Username']."', 47,'Ghana','Uruguay', 0, 0, 0),
('".$_SESSION['MM_Username']."', 48,'Corea del Sur','Portugal', 0, 0, 0),

('".$_SESSION['MM_Username']."', 49,'Primero Grupo A','Segundo Grupo B', 0, 0, 0),
('".$_SESSION['MM_Username']."', 50,'Primero Grupo C','Segundo Grupo D', 0, 0, 0),
('".$_SESSION['MM_Username']."', 51,'Primero Grupo B','Segundo Grupo A', 0, 0, 0),
('".$_SESSION['MM_Username']."', 52,'Primero Grupo D','Segundo Grupo C', 0, 0, 0),
('".$_SESSION['MM_Username']."', 53,'Primero Grupo E','Segundo Grupo F', 0, 0, 0),
('".$_SESSION['MM_Username']."', 54,'Primero Grupo G','Segundo Grupo H', 0, 0, 0),
('".$_SESSION['MM_Username']."', 55,'Primero Grupo F','Segundo Grupo E', 0, 0, 0),
('".$_SESSION['MM_Username']."', 56,'Primero Grupo H','Segundo Grupo G', 0, 0, 0),

('".$_SESSION['MM_Username']."', 57,'Ganador 49','Ganador 50', 0, 0, 0),
('".$_SESSION['MM_Username']."', 58,'Ganador 53','Ganador 54', 0, 0, 0),
('".$_SESSION['MM_Username']."', 59,'Ganador 51','Ganador 52', 0, 0, 0),
('".$_SESSION['MM_Username']."', 60,'Ganador 55','Ganador 56', 0, 0, 0),

('".$_SESSION['MM_Username']."', 61,'Semifinalista 1','Semifinalista 2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 62,'Semifinalista 3','Semifinalista 4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 63,'Finalista 1','Finalista 2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 64,'Tercer puesto 1','Tercer puesto 2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 65,'Campeon','Tercero', 0, 0, 0),
('".$_SESSION['MM_Username']."', 66,'Goleador','Pais', 0, 0, 0);";

  $Resultmundial2022 = mysqli_query($conexion, $insertSQLmundial2022) or die(mysqli_error($conexion));
  
$insertSQLmundial2022partidos = "INSERT INTO `equipos_mundial2022` (`CodUsu`, `CodEqu`, `nombre`, `grupo`, `puntos`, `golfav`, `golcon`, `difgol`) VALUES
('".$_SESSION['MM_Username']."', 1, 'Qatar', 'A', 3, 199, 198, 1),
('".$_SESSION['MM_Username']."', 2, 'Ecuador', 'A', 2, 198, 199, -1),
('".$_SESSION['MM_Username']."', 3, 'Senegal', 'A', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 4, 'Países Bajos', 'A', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 5, 'Inglaterra', 'B', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 6, 'Irán', 'B', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 7, 'USA', 'B', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 8, 'Gales', 'B', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 9, 'Argentina', 'C', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 10, 'Arabia Saudita', 'C', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 11, 'México', 'C', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 12, 'Polonia', 'C', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 13, 'Francia', 'D', 3, 199, 198, 1),
('".$_SESSION['MM_Username']."', 14, 'Australia', 'D', 2, 198, 199, -1),
('".$_SESSION['MM_Username']."', 15, 'Dinamarca', 'D', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 16, 'Túnez', 'D', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 17, 'Alemania', 'E', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 18, 'Japón', 'E', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 19, 'España', 'E', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 20, 'Costa Rica', 'E', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 21, 'Bélgica', 'F', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 22, 'Canada', 'F', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 23, 'Marruecos', 'F', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 24, 'Croacia', 'F', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 25, 'Brasil', 'G', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 26, 'Serbia', 'G', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 27, 'Suiza', 'G', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 28, 'Camerún', 'G', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 29, 'Uruguay', 'H', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 30, 'Corea del Sur', 'H', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 31, 'Portugal', 'H', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 32, 'Ghana', 'H', 3, 297, 297, 0);";

  $Resultmundial2022 = mysqli_query($conexion, $insertSQLmundial2022partidos) or die(mysqli_error($conexion));
  
  $insertSQLmundial2022torneos = "INSERT INTO Torneos (CodTor,nombreT,inscriptos,descripcion) VALUES
(19,'mundial2022','".$_SESSION['MM_Username']."', 'Mundial 2022')";
  $Resultmundial2022 = mysqli_query($conexion, $insertSQLmundial2022torneos) or die(mysqli_error($conexion));


  $insertGoTo = "mundial2022.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formmundial2026")) {
  // Mundial 2026: 48 equipos, 12 grupos (A-L), sorteo FIFA 2025 + fechas fase de grupos (includes/mundial2026_seed.php).
  $uEsc = mysqli_real_escape_string($conexion, $_SESSION['MM_Username']);
  $fechaCols = mundial2026_partidos_fecha_columns($conexion);
  $useFechaLegacy = $fechaCols['fecha'];
  $useFechaPartido = $fechaCols['fecha_partido'];
  $fechasPorCodpar = mundial2026_fecha_por_codpar();
  $fechaKoLegacyEsc = mysqli_real_escape_string($conexion, mundial2026_fecha_legacy_ko_placeholder());

  $colsFecha = '';
  if ($useFechaLegacy) {
    $colsFecha .= ', `fecha`';
  }
  if ($useFechaPartido) {
    $colsFecha .= ', `fecha_partido`';
  }

  $valsPartidos = [];
  $codPar = 1;
  $grupos = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
  foreach ($grupos as $g) {
    foreach (mundial2026_partidos_grupo($g) as $par) {
      $loc = mysqli_real_escape_string($conexion, $par[0]);
      $vis = mysqli_real_escape_string($conexion, $par[1]);
      $fd = mysqli_real_escape_string($conexion, $fechasPorCodpar[$codPar]);
      $valFecha = '';
      if ($useFechaLegacy) {
        $valFecha .= ", '".$fd."'";
      }
      if ($useFechaPartido) {
        $valFecha .= ", '".$fd."'";
      }
      $valsPartidos[] = "('".$uEsc."', ".$codPar.", '".$loc."', '".$vis."', 0, 0, 0".$valFecha.")";
      $codPar++;
    }
  }

  $koRows = [
    [73, '2A', '2B'], [74, '1E', '3?'], [75, '1F', '2C'], [76, '1C', '2F'], [77, '1I', '3?'], [78, '2E', '2I'],
    [79, '1A', '3?'], [80, '1L', '3?'], [81, '1D', '3?'], [82, '1G', '3?'], [83, '2K', '2L'], [84, '1H', '2J'],
    [85, '1B', '3?'], [86, '1J', '2H'], [87, '1K', '3?'], [88, '2D', '2G'],
    [89, 'Ganador 74', 'Ganador 77'], [90, 'Ganador 73', 'Ganador 75'], [91, 'Ganador 76', 'Ganador 78'], [92, 'Ganador 79', 'Ganador 80'],
    [93, 'Ganador 83', 'Ganador 84'], [94, 'Ganador 81', 'Ganador 82'], [95, 'Ganador 86', 'Ganador 88'], [96, 'Ganador 85', 'Ganador 87'],
    [97, 'Ganador 89', 'Ganador 90'], [98, 'Ganador 93', 'Ganador 94'], [99, 'Ganador 91', 'Ganador 92'], [100, 'Ganador 95', 'Ganador 96'],
    [101, 'Ganador 97', 'Ganador 98'], [102, 'Ganador 99', 'Ganador 100'], [103, 'Perdedor 101', 'Perdedor 102'], [104, 'Ganador 101', 'Ganador 102'],
    [105, 'Campeon', 'Tercero'], [106, 'Goleador', 'Pais'],
  ];
  foreach ($koRows as $kr) {
    $cp = intval($kr[0]);
    $loc = mysqli_real_escape_string($conexion, $kr[1]);
    $vis = mysqli_real_escape_string($conexion, $kr[2]);
    $valFecha = '';
    if ($useFechaLegacy) {
      $valFecha .= ", '".$fechaKoLegacyEsc."'";
    }
    if ($useFechaPartido) {
      $valFecha .= ", NULL";
    }
    $valsPartidos[] = "('".$uEsc."', ".$cp.", '".$loc."', '".$vis."', 0, 0, 0".$valFecha.")";
  }

  $insertSQLmundial2026 = "INSERT INTO partidos_mundial2026(`CodUsu`, `CodPar`, `local`, `visitante`, `glocal`, `gvisitante`, `resultado`".$colsFecha.") VALUES\n"
    . implode(",\n", $valsPartidos) . ";";

  $valsEquipos = [];
  $codEqu = 1;
  $eqPorGrupo = mundial2026_equipos_por_grupo();
  foreach ($grupos as $g) {
    foreach ($eqPorGrupo[$g] as $nombre) {
      $nomEsc = mysqli_real_escape_string($conexion, $nombre);
      $valsEquipos[] = "('".$uEsc."', ".$codEqu.", '".$nomEsc."', '".$g."', 0, 0, 0, 0)";
      $codEqu++;
    }
  }
  $insertSQLequipos2026 = "INSERT INTO `equipos_mundial2026` (`CodUsu`, `CodEqu`, `nombre`, `grupo`, `puntos`, `golfav`, `golcon`, `difgol`) VALUES\n"
    . implode(",\n", $valsEquipos) . ";";

  $insertSQLmundial2026torneos = "INSERT INTO Torneos (CodTor,nombreT,inscriptos,descripcion) VALUES
(20,'mundial2026','".$uEsc."', 'Mundial 2026')";

  // Sin transacción, si falla el 2.º o 3.º INSERT quedan partidos sin equipos / sin Torneos (mysqli puede lanzar excepción antes del or die).
  mysqli_begin_transaction($conexion);
  try {
    if (!mysqli_query($conexion, $insertSQLmundial2026)) {
      throw new RuntimeException(mysqli_error($conexion));
    }
    if (!mysqli_query($conexion, $insertSQLequipos2026)) {
      throw new RuntimeException(mysqli_error($conexion));
    }
    if (!mysqli_query($conexion, $insertSQLmundial2026torneos)) {
      throw new RuntimeException(mysqli_error($conexion));
    }
    mysqli_commit($conexion);
  } catch (Throwable $e) {
    mysqli_rollback($conexion);
    die('Error al inscribir el Mundial 2026: ' . $e->getMessage());
  }

  $insertGoTo = "mundial2026.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formcomentar")) {
  $insertSQL = sprintf("INSERT INTO comentarios (comentario, usuario) VALUES (%s, %s)",
                       GetSQLValueString($_POST['comentario'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"));

  $Result1 = mysqli_query($conexion, $insertSQL) or die(mysqli_error($conexion));

  $insertGoTo = "empezar.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_recordusuarios = 25;
$pageNum_recordusuarios = 0;
if (isset($_GET['pageNum_recordusuarios'])) {
  $pageNum_recordusuarios = $_GET['pageNum_recordusuarios'];
}
$startRow_recordusuarios = $pageNum_recordusuarios * $maxRows_recordusuarios;

$colname_recordusuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_recordusuarios = $_SESSION['MM_Username'];
}
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$query_limit_recordusuarios = sprintf("%s LIMIT %d, %d", $query_recordusuarios, $startRow_recordusuarios, $maxRows_recordusuarios);
$recordusuarios = mysqli_query($conexion, $query_limit_recordusuarios) or die(mysqli_error($conexion));
$row_recordusuarios = mysqli_fetch_assoc($recordusuarios);

if (isset($_GET['totalRows_recordusuarios'])) {
  $totalRows_recordusuarios = $_GET['totalRows_recordusuarios'];
} else {
  $all_recordusuarios = mysqli_query($conexion, $query_recordusuarios);
  $totalRows_recordusuarios = mysqli_num_rows($all_recordusuarios);
}
$totalPages_recordusuarios = ceil($totalRows_recordusuarios/$maxRows_recordusuarios)-1;


$query_Recordtodoslosusuarios = "SELECT * FROM usuarios ORDER BY puntos DESC";
$Recordtodoslosusuarios = mysqli_query($conexion, $query_Recordtodoslosusuarios) or die(mysqli_error($conexion));
$row_Recordtodoslosusuarios = mysqli_fetch_assoc($Recordtodoslosusuarios);
$totalRows_Recordtodoslosusuarios = mysqli_num_rows($Recordtodoslosusuarios);

$maxRows_recormentarios = 64;
$pageNum_recormentarios = 0;
if (isset($_GET['pageNum_recormentarios'])) {
  $pageNum_recormentarios = $_GET['pageNum_recormentarios'];
}
$startRow_recormentarios = $pageNum_recormentarios * $maxRows_recormentarios;

$query_recormentarios = "SELECT * FROM comentarios join usuarios on comentarios.usuario=usuarios.usuario ORDER BY id DESC";
$query_limit_recormentarios = sprintf("%s LIMIT %d, %d", $query_recormentarios, $startRow_recormentarios, $maxRows_recormentarios);
$recormentarios = mysqli_query($conexion, $query_limit_recormentarios) or die(mysqli_error($conexion));
$row_recormentarios = mysqli_fetch_assoc($recormentarios);

if (isset($_GET['totalRows_recormentarios'])) {
  $totalRows_recormentarios = $_GET['totalRows_recormentarios'];
} else {
  $all_recormentarios = mysqli_query($conexion, $query_recormentarios);
  $totalRows_recormentarios = mysqli_num_rows($all_recormentarios);
}
$totalPages_recormentarios = ceil($totalRows_recormentarios/$maxRows_recormentarios)-1;


$query_usutor= "SELECT * FROM Torneos WHERE inscriptos LIKE '".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."' AND CodTor='9';";
$usutor= mysqli_query($conexion, $query_usutor) or die(mysqli_error($conexion));
$row_usutor= mysqli_fetch_assoc($usutor);
$totalRows_usutor= mysqli_num_rows($usutor);

$query_usutor4= "SELECT * FROM Torneos WHERE inscriptos LIKE '".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."' AND CodTor='9';";
$usutor4= mysqli_query($conexion, $query_usutor4) or die(mysqli_error($conexion));
$row_usutor4= mysqli_fetch_assoc($usutor4);
$totalRows_usutor4= mysqli_num_rows($usutor4);

$query_usutor15= "SELECT * FROM Torneos WHERE inscriptos LIKE '".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."' AND CodTor='15';";
$usutor15= mysqli_query($conexion, $query_usutor15) or die(mysqli_error($conexion));
$row_usutor15= mysqli_fetch_assoc($usutor15);
$totalRows_usutor15= mysqli_num_rows($usutor15);

$query_usutor17= "SELECT * FROM Torneos WHERE inscriptos LIKE '".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."' AND CodTor='17';";
$usutor17= mysqli_query($conexion, $query_usutor17) or die(mysqli_error($conexion));
$row_usutor17= mysqli_fetch_assoc($usutor17);
$totalRows_usutor17= mysqli_num_rows($usutor17);

$query_usutor18= "SELECT * FROM Torneos WHERE inscriptos LIKE '".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."' AND CodTor='18';";
$usutor18= mysqli_query($conexion, $query_usutor18) or die(mysqli_error($conexion));
$row_usutor18= mysqli_fetch_assoc($usutor18);
$totalRows_usutor18= mysqli_num_rows($usutor18);

$query_usutor20= "SELECT * FROM Torneos WHERE inscriptos LIKE '".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."' AND CodTor='20';";
$usutor20= mysqli_query($conexion, $query_usutor20) or die(mysqli_error($conexion));
$row_usutor20= mysqli_fetch_assoc($usutor20);
$totalRows_usutor20= mysqli_num_rows($usutor20);

$query_otrousuario_mundial2026 = "SELECT T.*, U.* FROM Torneos as T JOIN usuarios as U ON T.inscriptos=U.usuario WHERE CodTor='20' AND inscriptos !='ProfetaMundial' ORDER BY U.puntos DESC";
$otrousuario_mundial2026 = mysqli_query($conexion, $query_otrousuario_mundial2026) or die(mysqli_error($conexion));
$row_otrousuario_mundial2026 = mysqli_fetch_assoc($otrousuario_mundial2026);
$totalRows_otrousuario_mundial2026 = mysqli_num_rows($otrousuario_mundial2026);



$query_otrousuario_oscar = "SELECT T.*, U.* FROM Torneos as T JOIN usuarios as U ON T.inscriptos=U.usuario WHERE CodTor='18' AND inscriptos NOT LIKE '".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."' AND usuario !='ProfetaMundial' ORDER BY U.puntos DESC";
$otrousuario_oscar = mysqli_query($conexion, $query_otrousuario_oscar) or die(mysqli_error($conexion));
$row_otrousuario_oscar = mysqli_fetch_assoc($otrousuario_oscar);
$totalRows_otrousuario_oscar= mysqli_num_rows($otrousuario_oscar);


$query_enlinea= "SELECT * FROM usuarios WHERE enlinea='si' AND usuario !='".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."' AND usuario !='ProfetaMundial';";
$enlinea= mysqli_query($conexion, $query_enlinea) or die(mysqli_error($conexion));
$totalRows_enlinea= mysqli_num_rows($enlinea);


if (mundial2026_partidos_tiene_columna_fecha($conexion)) {
  $query_hoy_usu = "SELECT * FROM partidos_mundial2026 WHERE CodPar IN (SELECT CodPar FROM partidos_mundial2026 WHERE fecha_partido = CURDATE()) AND CodUsu != 'ProfetaMundial' AND local IN (SELECT local FROM partidos_mundial2026 WHERE fecha_partido = CURDATE() AND CodUsu = 'ProfetaMundial') AND visitante IN (SELECT visitante FROM partidos_mundial2026 WHERE fecha_partido = CURDATE() AND CodUsu = 'ProfetaMundial') ORDER BY CodPar, resultado, glocal, gvisitante, CodUsu";
} else {
  $query_hoy_usu = "SELECT * FROM partidos_mundial2026 WHERE 1 = 0";
}
$hoy_usu = mysqli_query($conexion, $query_hoy_usu) or die(mysqli_error($conexion));
$totalRows_hoy_usu= mysqli_num_rows($hoy_usu);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Bienvenido <?php echo $row_recordusuarios['usuario']; ?></title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
<!--
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>

<script type="text/javascript">
window.onload = setupRefresh;
function setupRefresh()	{
	recargar();
	setInterval("recargar();",30000);
	}
function recargar()	{
	$('#divajax').load("chat.php");
	$('#divajax').fadeIn(300);

    }
</script>


</head>
<body>
<?php
$today = date("YmdH");
// Cierre de inscripción pronóstico Mundial 2026 (ajustar si cambia el reglamento).
$limiteMundial2026 = '2026061123';
$fueraTiempo2026 = ($limiteMundial2026 <= $today) ? 1 : 0;
if ($_SESSION['MM_Username'] == 'ProfetaMundial') {
  echo "La hora del servidor es: " . $today;
}
?>
<!-- inicio de la cabecera -->
<div class="cabecera">
	<div style="float:left;" class="nada"><a href="empezar.php"><img src="imagenes/profetamundial.png" class="nada" width="171" height="57" alt="Profeta Mundial" /></a>
    </div>
   	<div class="loginiz">
		<p>USUARIO: <?php echo $row_recordusuarios['usuario']; ?> Credito: <?php echo $row_recordusuarios['credito']; ?>&phi;<br />
  <a href="modificar.php">Mi cuenta</a>
  		</p>   
		<a href="<?php echo $logoutAction ?>" class="botoneschicos">Desconectarse</a>
    </div><br />
    <div style="clear:both;"></div>
</div>
<!-- Fin de la cabecera-->

<br />
<div id="contenedora" class="contenedora">
<!-- inicio de area Izquierda -->
<br />
	<div class="tablaIzquierda">
    	<b>Mis pronosticos:</b>
    	<div class="comentarios" style="text-align:center;">
         	<p><strong>¿Quién ganará la Copa Mundial 2026?</strong></p>
  			<?php if (!$totalRows_usutor20 || empty($row_usutor20['nombreT'])) { ?>
		        <?php if (($fueraTiempo2026 == 0) || ($_SESSION['MM_Username'] == 'ProfetaMundial')) { ?>
                	<form id="formmundial2026" name="formmundial2026" method="post" action="<?php echo $editFormAction; ?>">
                    	<input type="submit" class="botoneschicosrojos" value="Participar en el Mundial 2026" />
                        <input type="hidden" name="MM_insert" value="formmundial2026" />
                    </form>
		        <?php } ?>
			<?php }
			else { ?>
			    <a href="mundial2026.php" class="botoneschicos"> Ver o modificar mi pronostico</a>
			<?php } ?>
			<br />
   		 	<hr />

			<div class="comentarios" style="text-align:center;">
                    	<?php echo is_array($row_otrousuario_mundial2026) ? htmlspecialchars($row_otrousuario_mundial2026['descripcion'], ENT_QUOTES, 'UTF-8') : 'Mundial 2026'; ?>&nbsp;(participantes: &nbsp;<?php echo (int)$totalRows_otrousuario_mundial2026; ?>)
     		   <?php if ($totalRows_otrousuario_mundial2026 > 0) { do { ?>
                	<p>
    			   		<a class="botoneschicos" href="vermundial2026.php?verlode=<?php echo $row_otrousuario_mundial2026['inscriptos'];?>"> <?php echo $row_otrousuario_mundial2026['inscriptos'];?>  <b><?php echo $row_otrousuario_mundial2026['puntos'];?></b> puntos)</a>
					</p>
      		  <?php } while ($row_otrousuario_mundial2026 = mysqli_fetch_assoc($otrousuario_mundial2026)); } ?>
            </div>
			<br />
   		 	<hr />
<!--
		<div class="comentarios" style="text-align:center;">
			<p>
				<strong>Oscar 2022</strong>
			</p>
  			<?php if (!$row_usutor18['nombreT']) { ?>
			<a href="oscar2022.php" class="botoneschicosrojos"> Pronosticar</a>
			<? } 
			else { ?>
			<a href="verelegidos2022.php" class="botoneschicos"> Ver mi pronostico</a>
			<?php } ?>
    		           <hr /> 
		

			<div class="comentarios" style="text-align:center;">
                    	<?php echo $row_otrousuario_oscar['descripcion'];?>&nbsp;(participantes: &nbsp;<?php echo $totalRows_otrousuario_oscar?>)
     		   <?php do { ?>
                	<p>
    			   		<a class="botoneschicos" href="verelegidosde2022.php?usuario=<?php echo $row_otrousuario_oscar['inscriptos'];?>"> <?php echo $row_otrousuario_oscar['inscriptos'];?>  <b><?php echo $row_otrousuario_oscar['puntos'];?></b> puntos)</a>
					</p>
      		  <?php } while ($row_otrousuario_oscar = mysqli_fetch_assoc($otrousuario_oscar)); ?>
     			    	      -->
    	      
		<div class="comentarios">
			<div id="divajax" style="display:none;"></div>
		</div>
		<br /><br />
			
		<?php 
		$con='a';	
		$d=0;
		if ($totalRows_hoy_usu>0) {?>
		<div class="comentarios" style="text-align:center;">	
		<p><strong>Pronosticos para los partidos de hoy:</strong></p>
		<?php while ($row_usu = mysqli_fetch_assoc($hoy_usu)) {
			if ($con!=$row_usu['CodPar'])	{
				if ($d>0) echo "</div>";
				echo "<div style='float:left; padding-left:2%; padding-top:1%;text-align:left;'>";
				echo "<img src='imagenes/banamerica/".$row_usu['local'].".gif'/> ".$row_usu['local'].'-'.$row_usu['visitante']." <img src='imagenes/banamerica/".$row_usu['visitante'].".gif'/><hr />";		
				echo "<b>".$row_usu['CodUsu']."</b>: ".$row_usu['glocal']."-".$row_usu['gvisitante']."<br />";
				$con=$row_usu['CodPar'];
				$d=$d+1;
			}
			else	{
				echo "<b>".$row_usu['CodUsu']."</b>: ".$row_usu['glocal']."-".$row_usu['gvisitante']."<br />";				
			}
		 }	
		echo "</div>";	
		echo "<div style='clear:both;'></div></div>";
		}
		?>
		
		</div>
		
    </div>
<!-- Fin de area Izquierda-->

<!-- Inicio de la derecha-->
 <div class="tablaDerecha">
	<div style="padding-bottom:1%x; padding-top:1%; padding-left: 1%; padding-right: 1%;">
   	<p>
    <strong>Tabla de comentarios:</strong>
    </p>
		<div class="desplazamiento" id="desplazamiento">
    
	
	<?php do { ?>
			<div class="comentarios">
        		<p class="letraschicas">
        		<strong> <img src="imagenes/avatares/<?php echo $row_recormentarios['avatar'];?>" height="32" width="32" alt=""/> <? echo $row_recormentarios['usuario']; ?>  dijo:</strong> <?php echo $row_recormentarios['comentario']; ?></p>
			</div>
            <br />
      <?php } while ($row_recormentarios = mysqli_fetch_assoc($recormentarios)); ?>
    
    
		</div>
  		<form id="formcomentar" name="formcomentar" method="POST" action="<?php echo $editFormAction; ?>">
 		<input name="usuario" type="hidden" id="usuario" value="<?php echo $row_recordusuarios['usuario']; ?>" />
 		<p>
        <a href="comentarios.php" target="_blank"> <span class="botoneschicos">Ver todos los comentarios</span></a>
        </p>    
		<span id="sprytextarea1">
			<label>
			<textarea name="comentario" cols="4" rows="4" class="letraschicascomentarios" id="comentario"></textarea><br />
    		<span id="countsprytextarea1">&nbsp;</span><span class="letraschicas"> Letras por escribir
            </span>
    		</label>
   			 <span class="textareaRequiredMsg"> &iexcl;Escrib&iacute; algo!</span>
             <span class="textareaMinCharsMsg">&iexcl;Escrib&iacute; algo mas!</span>
             <span class="textareaMaxCharsMsg">Demasiados caracteres</span>
		</span>
		<p>
      	<label>
        <input name="comentar" type="submit" class="botoneschicos" id="comentar" value="Comentar" />
      	</label>
  		</p>
    	<input type="hidden" name="MM_insert" value="formcomentar" />
  	</form>
	<br />
	<div><hr />
    			<b>Trofeos Obtenidos por todos los usuarios:</b>
			<div class="comentarios">
			<?php include_once('trofeos.php') ?>		
			</div>
		</div>
	</div>
	<br /><br />
	<br />
</div>

<!-- fin de la Derecha -->
<div style="clear: both;"></div>

<!-- Inicio de banners -->
<!-- Fin de banners -->  
  
</div>
<!-- Final -->    
<br />
<div style="clear:both;"></div>  
<div id="final" class="final">
	<p>
  	<a href="reglas.php" class="botoneschicos">Reglas del juego</a>  |
  	<a href="contacto.php" class="botoneschicos">Soluci&oacute;n de Problemas</a>  |
  	<a href="terminos.php" class="botoneschicos">T&eacute;rminos y condiciones de uso</a>
    </p>
	Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com/favicon.ico" /><br />
</div>
<!-- Final --> 
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {minChars:2, maxChars:200, counterId:"countsprytextarea1", counterType:"chars_remaining"});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($recordusuarios);
mysqli_free_result($Recordtodoslosusuarios);
mysqli_free_result($recormentarios);
?>
