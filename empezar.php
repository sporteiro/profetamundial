<?php require_once('Connections/conexion.php'); ?>
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
  // Mundial 2026: 48 equipos, 12 grupos (A-L), Round of 32 (73-88) -> Final (104)
  // Nota: los nombres de equipos se dejan como placeholders (A1..L4) para actualizar luego.
  $insertSQLmundial2026 = "INSERT INTO partidos_mundial2026(`CodUsu`, `CodPar`, `local`, `visitante`, `glocal`, `gvisitante`, `resultado`) VALUES

('".$_SESSION['MM_Username']."', 1, 'A1', 'A2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 2, 'A3', 'A4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 3, 'A1', 'A3', 0, 0, 0),
('".$_SESSION['MM_Username']."', 4, 'A4', 'A2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 5, 'A4', 'A1', 0, 0, 0),
('".$_SESSION['MM_Username']."', 6, 'A2', 'A3', 0, 0, 0),

('".$_SESSION['MM_Username']."', 7, 'B1', 'B2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 8, 'B3', 'B4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 9, 'B1', 'B3', 0, 0, 0),
('".$_SESSION['MM_Username']."', 10, 'B4', 'B2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 11, 'B4', 'B1', 0, 0, 0),
('".$_SESSION['MM_Username']."', 12, 'B2', 'B3', 0, 0, 0),

('".$_SESSION['MM_Username']."', 13, 'C1', 'C2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 14, 'C3', 'C4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 15, 'C1', 'C3', 0, 0, 0),
('".$_SESSION['MM_Username']."', 16, 'C4', 'C2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 17, 'C4', 'C1', 0, 0, 0),
('".$_SESSION['MM_Username']."', 18, 'C2', 'C3', 0, 0, 0),

('".$_SESSION['MM_Username']."', 19, 'D1', 'D2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 20, 'D3', 'D4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 21, 'D1', 'D3', 0, 0, 0),
('".$_SESSION['MM_Username']."', 22, 'D4', 'D2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 23, 'D4', 'D1', 0, 0, 0),
('".$_SESSION['MM_Username']."', 24, 'D2', 'D3', 0, 0, 0),

('".$_SESSION['MM_Username']."', 25, 'E1', 'E2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 26, 'E3', 'E4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 27, 'E1', 'E3', 0, 0, 0),
('".$_SESSION['MM_Username']."', 28, 'E4', 'E2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 29, 'E4', 'E1', 0, 0, 0),
('".$_SESSION['MM_Username']."', 30, 'E2', 'E3', 0, 0, 0),

('".$_SESSION['MM_Username']."', 31, 'F1', 'F2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 32, 'F3', 'F4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 33, 'F1', 'F3', 0, 0, 0),
('".$_SESSION['MM_Username']."', 34, 'F4', 'F2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 35, 'F4', 'F1', 0, 0, 0),
('".$_SESSION['MM_Username']."', 36, 'F2', 'F3', 0, 0, 0),

('".$_SESSION['MM_Username']."', 37, 'G1', 'G2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 38, 'G3', 'G4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 39, 'G1', 'G3', 0, 0, 0),
('".$_SESSION['MM_Username']."', 40, 'G4', 'G2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 41, 'G4', 'G1', 0, 0, 0),
('".$_SESSION['MM_Username']."', 42, 'G2', 'G3', 0, 0, 0),

('".$_SESSION['MM_Username']."', 43, 'H1', 'H2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 44, 'H3', 'H4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 45, 'H1', 'H3', 0, 0, 0),
('".$_SESSION['MM_Username']."', 46, 'H4', 'H2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 47, 'H4', 'H1', 0, 0, 0),
('".$_SESSION['MM_Username']."', 48, 'H2', 'H3', 0, 0, 0),

('".$_SESSION['MM_Username']."', 49, 'I1', 'I2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 50, 'I3', 'I4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 51, 'I1', 'I3', 0, 0, 0),
('".$_SESSION['MM_Username']."', 52, 'I4', 'I2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 53, 'I4', 'I1', 0, 0, 0),
('".$_SESSION['MM_Username']."', 54, 'I2', 'I3', 0, 0, 0),

('".$_SESSION['MM_Username']."', 55, 'J1', 'J2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 56, 'J3', 'J4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 57, 'J1', 'J3', 0, 0, 0),
('".$_SESSION['MM_Username']."', 58, 'J4', 'J2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 59, 'J4', 'J1', 0, 0, 0),
('".$_SESSION['MM_Username']."', 60, 'J2', 'J3', 0, 0, 0),

('".$_SESSION['MM_Username']."', 61, 'K1', 'K2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 62, 'K3', 'K4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 63, 'K1', 'K3', 0, 0, 0),
('".$_SESSION['MM_Username']."', 64, 'K4', 'K2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 65, 'K4', 'K1', 0, 0, 0),
('".$_SESSION['MM_Username']."', 66, 'K2', 'K3', 0, 0, 0),

('".$_SESSION['MM_Username']."', 67, 'L1', 'L2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 68, 'L3', 'L4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 69, 'L1', 'L3', 0, 0, 0),
('".$_SESSION['MM_Username']."', 70, 'L4', 'L2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 71, 'L4', 'L1', 0, 0, 0),
('".$_SESSION['MM_Username']."', 72, 'L2', 'L3', 0, 0, 0),

('".$_SESSION['MM_Username']."', 73, '2A', '2B', 0, 0, 0),
('".$_SESSION['MM_Username']."', 74, '1E', '3?', 0, 0, 0),
('".$_SESSION['MM_Username']."', 75, '1F', '2C', 0, 0, 0),
('".$_SESSION['MM_Username']."', 76, '1C', '2F', 0, 0, 0),
('".$_SESSION['MM_Username']."', 77, '1I', '3?', 0, 0, 0),
('".$_SESSION['MM_Username']."', 78, '2E', '2I', 0, 0, 0),
('".$_SESSION['MM_Username']."', 79, '1A', '3?', 0, 0, 0),
('".$_SESSION['MM_Username']."', 80, '1L', '3?', 0, 0, 0),
('".$_SESSION['MM_Username']."', 81, '1D', '3?', 0, 0, 0),
('".$_SESSION['MM_Username']."', 82, '1G', '3?', 0, 0, 0),
('".$_SESSION['MM_Username']."', 83, '2K', '2L', 0, 0, 0),
('".$_SESSION['MM_Username']."', 84, '1H', '2J', 0, 0, 0),
('".$_SESSION['MM_Username']."', 85, '1B', '3?', 0, 0, 0),
('".$_SESSION['MM_Username']."', 86, '1J', '2H', 0, 0, 0),
('".$_SESSION['MM_Username']."', 87, '1K', '3?', 0, 0, 0),
('".$_SESSION['MM_Username']."', 88, '2D', '2G', 0, 0, 0),

('".$_SESSION['MM_Username']."', 89, 'Ganador 74', 'Ganador 77', 0, 0, 0),
('".$_SESSION['MM_Username']."', 90, 'Ganador 73', 'Ganador 75', 0, 0, 0),
('".$_SESSION['MM_Username']."', 91, 'Ganador 76', 'Ganador 78', 0, 0, 0),
('".$_SESSION['MM_Username']."', 92, 'Ganador 79', 'Ganador 80', 0, 0, 0),
('".$_SESSION['MM_Username']."', 93, 'Ganador 83', 'Ganador 84', 0, 0, 0),
('".$_SESSION['MM_Username']."', 94, 'Ganador 81', 'Ganador 82', 0, 0, 0),
('".$_SESSION['MM_Username']."', 95, 'Ganador 86', 'Ganador 88', 0, 0, 0),
('".$_SESSION['MM_Username']."', 96, 'Ganador 85', 'Ganador 87', 0, 0, 0),

('".$_SESSION['MM_Username']."', 97, 'Ganador 89', 'Ganador 90', 0, 0, 0),
('".$_SESSION['MM_Username']."', 98, 'Ganador 93', 'Ganador 94', 0, 0, 0),
('".$_SESSION['MM_Username']."', 99, 'Ganador 91', 'Ganador 92', 0, 0, 0),
('".$_SESSION['MM_Username']."', 100, 'Ganador 95', 'Ganador 96', 0, 0, 0),

('".$_SESSION['MM_Username']."', 101, 'Ganador 97', 'Ganador 98', 0, 0, 0),
('".$_SESSION['MM_Username']."', 102, 'Ganador 99', 'Ganador 100', 0, 0, 0),
('".$_SESSION['MM_Username']."', 103, 'Perdedor 101', 'Perdedor 102', 0, 0, 0),
('".$_SESSION['MM_Username']."', 104, 'Ganador 101', 'Ganador 102', 0, 0, 0),

('".$_SESSION['MM_Username']."', 105, 'Campeon', 'Tercero', 0, 0, 0),
('".$_SESSION['MM_Username']."', 106, 'Goleador', 'Pais', 0, 0, 0);";

  $Resultmundial2026 = mysqli_query($conexion, $insertSQLmundial2026) or die(mysqli_error($conexion));

  $insertSQLequipos2026 = "INSERT INTO `equipos_mundial2026` (`CodUsu`, `CodEqu`, `nombre`, `grupo`, `puntos`, `golfav`, `golcon`, `difgol`) VALUES
('".$_SESSION['MM_Username']."', 1, 'A1', 'A', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 2, 'A2', 'A', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 3, 'A3', 'A', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 4, 'A4', 'A', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 5, 'B1', 'B', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 6, 'B2', 'B', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 7, 'B3', 'B', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 8, 'B4', 'B', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 9, 'C1', 'C', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 10, 'C2', 'C', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 11, 'C3', 'C', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 12, 'C4', 'C', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 13, 'D1', 'D', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 14, 'D2', 'D', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 15, 'D3', 'D', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 16, 'D4', 'D', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 17, 'E1', 'E', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 18, 'E2', 'E', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 19, 'E3', 'E', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 20, 'E4', 'E', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 21, 'F1', 'F', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 22, 'F2', 'F', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 23, 'F3', 'F', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 24, 'F4', 'F', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 25, 'G1', 'G', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 26, 'G2', 'G', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 27, 'G3', 'G', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 28, 'G4', 'G', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 29, 'H1', 'H', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 30, 'H2', 'H', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 31, 'H3', 'H', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 32, 'H4', 'H', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 33, 'I1', 'I', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 34, 'I2', 'I', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 35, 'I3', 'I', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 36, 'I4', 'I', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 37, 'J1', 'J', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 38, 'J2', 'J', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 39, 'J3', 'J', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 40, 'J4', 'J', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 41, 'K1', 'K', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 42, 'K2', 'K', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 43, 'K3', 'K', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 44, 'K4', 'K', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 45, 'L1', 'L', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 46, 'L2', 'L', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 47, 'L3', 'L', 0, 0, 0, 0),
('".$_SESSION['MM_Username']."', 48, 'L4', 'L', 0, 0, 0, 0);";

  $Resultmundial2026 = mysqli_query($conexion, $insertSQLequipos2026) or die(mysqli_error($conexion));

  $insertSQLmundial2026torneos = "INSERT INTO Torneos (CodTor,nombreT,inscriptos,descripcion) VALUES
(20,'mundial2026','".$_SESSION['MM_Username']."', 'Mundial 2026')";
  $Resultmundial2026 = mysqli_query($conexion, $insertSQLmundial2026torneos) or die(mysqli_error($conexion));

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

$query_usutor19= "SELECT * FROM Torneos WHERE inscriptos LIKE '".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."' AND CodTor='19';";
$usutor19= mysqli_query($conexion, $query_usutor19) or die(mysqli_error($conexion));
$row_usutor19= mysqli_fetch_assoc($usutor19);
$totalRows_usutor19= mysqli_num_rows($usutor19);

$query_usutor20= "SELECT * FROM Torneos WHERE inscriptos LIKE '".mysqli_real_escape_string($conexion, $_SESSION['MM_Username'])."' AND CodTor='20';";
$usutor20= mysqli_query($conexion, $query_usutor20) or die(mysqli_error($conexion));
$row_usutor20= mysqli_fetch_assoc($usutor20);
$totalRows_usutor20= mysqli_num_rows($usutor20);

$query_otrousuario_mundial = "SELECT T.*, U.* FROM Torneos as T JOIN usuarios as U ON T.inscriptos=U.usuario WHERE CodTor='19' AND inscriptos !='ProfetaMundial' ORDER BY U.puntos DESC";
$otrousuario_mundial = mysqli_query($conexion, $query_otrousuario_mundial) or die(mysqli_error($conexion));
$row_otrousuario_mundial = mysqli_fetch_assoc($otrousuario_mundial);
$totalRows_otrousuario_mundial = mysqli_num_rows($otrousuario_mundial);

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


$query_hoy_usu= "SELECT * FROM partidos_mundial2022 WHERE CodPar in(select CodPar from partidos_mundial2022 where fecha=curdate()) and CodUsu !='ProfetaMundial' AND  local in (select local from partidos_mundial2022 where fecha=curdate() and CodUsu='ProfetaMundial') AND  visitante in (select visitante from partidos_mundial2022 where fecha=curdate() and CodUsu='ProfetaMundial') ORDER BY CodPar, resultado,Glocal,Gvisitante,CodUsu;";
$hoy_usu= mysqli_query($conexion, $query_hoy_usu) or die(mysqli_error($conexion));
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
//el servidor tiene 5 horas menos que GMT 
$limite='2022111823';
if ($limite<=$today) {
	$fueraTiempo=1;
	}
else $fueraTiempo=0;
if ($_SESSION['MM_Username']=='ProfetaMundial')	{
	echo "La hora del servidor es: ".$today;
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
         	<p<strong>¿Quién ganará la Copa Mundial 2026?</strong>	</p>
  			<?php if (!$row_usutor20['nombreT']) { ?>
		        <?php if ( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial') ) { ?>
                	<form id="formmundial2026" name="formmundial2026" method="post" action="<?php echo $editFormAction; ?>">
                    	<input type="submit" class="botoneschicosrojos" value="¡Pronosticar ahora!" />
                        <input type="hidden" name="MM_insert" value="formmundial2026" />
                    </form>
		        <?php } ?>
			<? } 
			else { ?>
			    <a href="mundial2026.php" class="botoneschicos"> Ver o modificar mi pronostico</a>
			<?php } ?>
			<br />
   		 	<hr />

			<div class="comentarios" style="text-align:center;">
                    	<?php echo $row_otrousuario_mundial2026['descripcion'];?>&nbsp;(participantes: &nbsp;<?php echo $totalRows_otrousuario_mundial2026?>)
     		   <?php if ($totalRows_otrousuario_mundial2026 > 0) { do { ?>
                	<p>
    			   		<a class="botoneschicos" href="vermundial2026.php?verlode=<?php echo $row_otrousuario_mundial2026['inscriptos'];?>"> <?php echo $row_otrousuario_mundial2026['inscriptos'];?>  <b><?php echo $row_otrousuario_mundial2026['puntos'];?></b> puntos)</a>
					</p>
      		  <?php } while ($row_otrousuario_mundial2026 = mysqli_fetch_assoc($otrousuario_mundial2026)); } ?>
            </div>
			<br />
   		 	<hr />

         	<p<strong>¿Quién ganará la Copa Mundial 2022?</strong>	</p>
  			<?php if (!$row_usutor19['nombreT']) { ?>
		        <?php if ( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial') ) { ?>
                	<form id="formmundial2022" name="formmundial2022" method="post" action="<?php echo $editFormAction; ?>">
                    	<input type="submit" class="botoneschicosrojos" value="¡Pronosticar ahora!" />
                        <input type="hidden" name="MM_insert" value="formmundial2022" />
                    </form>
		        <?php } ?>
			<? } 
			else { ?>
			    <a href="mundial2022.php" class="botoneschicos"> Ver o modificar mi pronostico</a>
			<?php } ?>
			<br />
   		 	<hr /> 
		

			<div class="comentarios" style="text-align:center;">
                    	<?php echo $row_otrousuario_mundial['descripcion'];?>&nbsp;(participantes: &nbsp;<?php echo $totalRows_otrousuario_mundial?>)
     		   <?php do { ?>
                	<p>
    			   		<a class="botoneschicos" href="vermundial2022.php?verlode=<?php echo $row_otrousuario_mundial['inscriptos'];?>"> <?php echo $row_otrousuario_mundial['inscriptos'];?>  <b><?php echo $row_otrousuario_mundial['puntos'];?></b> puntos)</a>
					</p>
      		  <?php } while ($row_otrousuario_mundial = mysqli_fetch_assoc($otrousuario_mundial)); ?>
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
