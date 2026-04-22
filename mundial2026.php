<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlog.php'); ?>
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

// Usuario logueado
$colname_recordusuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_recordusuarios = $_SESSION['MM_Username'];
}
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$recordusuarios = mysqli_query($conexion, $query_recordusuarios) or die(mysqli_error($conexion));
$row_recordusuarios = mysqli_fetch_assoc($recordusuarios);

$uEsc = mysqli_real_escape_string($conexion, $_SESSION['MM_Username'] ?? '');
// Misma clave que empezar.php / Torneos (latin1_ci suele tolerar mezcla de mayúsculas; unificamos a ProfetaMundial).
$codUsuPlantilla = 'ProfetaMundial';

// Puntuaciones vs ProfetaMundial (placeholder: mantiene el esquema de 2022)
$consulta_puntos_resultados_grupos =
  "SELECT count(*) as puntos
   FROM partidos_mundial2026 pp
   JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar
   WHERE ps.CodUsu='".$uEsc."'
     AND pp.CodUsu='".$codUsuPlantilla."'
     AND pp.resultado=ps.resultado
     AND pp.CodPar BETWEEN 1 AND 72
     AND pp.glocal!=99;";
$resultado_puntos_resultados_grupos = mysqli_query($conexion, $consulta_puntos_resultados_grupos) or die(mysqli_error($conexion));
$filas_puntos_resultados_grupos = mysqli_fetch_assoc($resultado_puntos_resultados_grupos);

$consulta_puntos_exactos_grupos =
  "SELECT count(*) as puntos
   FROM partidos_mundial2026 pp
   JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar
   WHERE ps.CodUsu='".$uEsc."'
     AND pp.CodUsu='".$codUsuPlantilla."'
     AND pp.resultado=ps.resultado
     AND pp.CodPar BETWEEN 1 AND 72
     AND pp.glocal=ps.glocal
     AND pp.gvisitante=ps.gvisitante
     AND pp.glocal!=99;";
$resultado_puntos_exactos_grupos = mysqli_query($conexion, $consulta_puntos_exactos_grupos) or die(mysqli_error($conexion));
$filas_puntos_exactos_grupos = mysqli_fetch_assoc($resultado_puntos_exactos_grupos);

// Segunda fase: resultado correcto (sin exactos), requiere que el fixture coincida (local/visitante)
$consulta_puntos_resultados_ko =
  "SELECT count(*) as puntos
   FROM partidos_mundial2026 pp
   JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar
   WHERE ps.CodUsu='".$uEsc."'
     AND pp.CodUsu='".$codUsuPlantilla."'
     AND pp.resultado=ps.resultado
     AND pp.CodPar BETWEEN 73 AND 104
     AND pp.local=ps.local
     AND pp.visitante=ps.visitante
     AND pp.glocal!=99;";
$resultado_puntos_resultados_ko = mysqli_query($conexion, $consulta_puntos_resultados_ko) or die(mysqli_error($conexion));
$filas_puntos_resultados_ko = mysqli_fetch_assoc($resultado_puntos_resultados_ko);

$consulta_puntos_exactos_ko =
  "SELECT count(*) as puntos
   FROM partidos_mundial2026 pp
   JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar
   WHERE ps.CodUsu='".$uEsc."'
     AND pp.CodUsu='".$codUsuPlantilla."'
     AND pp.resultado=ps.resultado
     AND pp.CodPar BETWEEN 73 AND 104
     AND pp.local=ps.local
     AND pp.visitante=ps.visitante
     AND pp.glocal=ps.glocal
     AND pp.gvisitante=ps.gvisitante
     AND pp.glocal!=99;";
$resultado_puntos_exactos_ko = mysqli_query($conexion, $consulta_puntos_exactos_ko) or die(mysqli_error($conexion));
$filas_puntos_exactos_ko = mysqli_fetch_assoc($resultado_puntos_exactos_ko);

$exactos = intval($filas_puntos_exactos_grupos['puntos'] ?? 0) + intval($filas_puntos_exactos_ko['puntos'] ?? 0);
$pexactos = $exactos * 5;
$partidos_grupos = intval($filas_puntos_resultados_grupos['puntos'] ?? 0) - intval($filas_puntos_exactos_grupos['puntos'] ?? 0);
$partidos_ko = intval($filas_puntos_resultados_ko['puntos'] ?? 0) - intval($filas_puntos_exactos_ko['puntos'] ?? 0);
$puntospartidos_ko = $partidos_ko * 2;

$total = $pexactos + $partidos_grupos + $puntospartidos_ko;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Mundial de Futbol 2026</title>
  <link href="estilo.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="favicon.ico"/>
  <script src="jquery.js" type="text/javascript"></script>
  <style type="text/css">
    [id^="tablaypartidos_mundial2026_"] {
      padding-top: 5px;
      background-color: #10598c;
      padding: 1%;
    }
    [id^="partidos_grupo_mundial2026_"] .comentarios {
      text-align: center;
    }
    .tabla_grupo_mundial2026 table {
      width: 100%;
    }
    .tabla_grupo_mundial2026 td {
      padding: 5px;
    }
    .tabla_grupo_mundial2026 .equipo-nombre {
      text-align: left;
      white-space: nowrap;
    }
    .tabla_grupo_mundial2026 tr:nth-child(4),
    .tabla_grupo_mundial2026 tr:nth-child(5) {
      color: #aaa;
    }
    .tabla_grupo_mundial2026 tr:nth-child(1) {
      font-size: 1em;
      font-weight: bold;
    }
    .tabla_grupo_mundial2026 .comentarios {
      font-size: 1em;
    }
    @media (max-width: 800px) {
      [id^="partidos_grupo_mundial2026_"] {
        width: 100%;
      }
      .tabla_grupo_mundial2026 {
        width: 100%;
      }
    }
    @media (min-width: 801px) {
      [id^="partidos_grupo_mundial2026_"] {
        width: 100%;
        float: none;
      }
      .tabla_grupo_mundial2026 {
        float: none;
        width: 100%;
        text-align: right;
        font-size: 1.1em;
      }
      .tabla_grupo_mundial2026 .comentarios {
        font-size: 1em;
      }
    }
  </style>
</head>

<body>
<div id="info_mundial"></div>

<!-- Cabecera -->
<div class="cabecera">
  <div style="width: 300px; float:left;" class="nada">
    <a href="empezar.php"><img src="imagenes/profetamundial.png" class="nada" width="171" height="57" alt="Profeta Mundial" /></a>
  </div>
  <div class="loginiz">
    <p>USUARIO: <?php echo $row_recordusuarios['usuario']; ?><br />
      <a href="modificar.php">Mi cuenta</a>
    </p>
    <a href="<?php echo $logoutAction ?>" class="botoneschicos">Desconectarse</a>
  </div>
  <div style="clear:both;"></div>
  <div id="anchor_grupos">
    <a href="#grupoa">Grupo A</a> <a href="#grupob">Grupo B</a> <a href="#grupoc">Grupo C</a> <a href="#grupod">Grupo D</a>
    <a href="#grupoe">Grupo E</a> <a href="#grupof">Grupo F</a> <a href="#grupog">Grupo G</a> <a href="#grupoh">Grupo H</a>
    <a href="#grupoi">Grupo I</a> <a href="#grupoj">Grupo J</a> <a href="#grupok">Grupo K</a> <a href="#grupol">Grupo L</a>
    <a href="#anchor_fase2">Fixture</a>
  </div>
</div>

<br />
<div id="contenedora" class="contenedora">
  <p class="letrasmasgrandes">Mundial de Futbol 2026</p>

  <div class="tablaclasificacion">
    <div class="comentarios">
      <p>Pronostico de <b><?php echo $_SESSION['MM_Username']?></b></p>
      <p>Resultado del partido (Grupos): <?=$partidos_grupos?> (<?=$partidos_grupos?> puntos)</p>
      <p>Resultado del partido (Eliminatorias): <?=$partidos_ko?> (<?=$puntospartidos_ko?> puntos)</p>
      <p>Resultados exactos Totales: <?=$exactos?> (<?=$pexactos?> puntos)</p>
      <hr />
      <p style="font-size:24px;">Total: <b><?=$total?></b> puntos</p>
      <?php if (strcasecmp($_SESSION['MM_Username'] ?? '', 'ProfetaMundial') === 0) { ?>
        <p><a href="puntuar_mundial2026.php" class="botoneschicos">Puntuar a todos (admin)</a></p>
      <?php } ?>
    </div>
  </div>

  <br />
  <!-- Grupos -->
  <div id="grupoa" class="titulo_grupos">GRUPO A</div>
  <?php require_once('GA_mundial2026.php');?>
  <div id="grupob" class="titulo_grupos">GRUPO B</div>
  <?php require_once('GB_mundial2026.php');?>
  <div id="grupoc" class="titulo_grupos">GRUPO C</div>
  <?php require_once('GC_mundial2026.php');?>
  <div id="grupod" class="titulo_grupos">GRUPO D</div>
  <?php require_once('GD_mundial2026.php');?>
  <div id="grupoe" class="titulo_grupos">GRUPO E</div>
  <?php require_once('GE_mundial2026.php');?>
  <div id="grupof" class="titulo_grupos">GRUPO F</div>
  <?php require_once('GF_mundial2026.php');?>
  <div id="grupog" class="titulo_grupos">GRUPO G</div>
  <?php require_once('GG_mundial2026.php');?>
  <div id="grupoh" class="titulo_grupos">GRUPO H</div>
  <?php require_once('GH_mundial2026.php');?>
  <div id="grupoi" class="titulo_grupos">GRUPO I</div>
  <?php require_once('GI_mundial2026.php');?>
  <div id="grupoj" class="titulo_grupos">GRUPO J</div>
  <?php require_once('GJ_mundial2026.php');?>
  <div id="grupok" class="titulo_grupos">GRUPO K</div>
  <?php require_once('GK_mundial2026.php');?>
  <div id="grupol" class="titulo_grupos">GRUPO L</div>
  <?php require_once('GL_mundial2026.php');?>

  <!-- Fixture -->
  <div id="anchor_fase2">
    <div class="titulo_grupos">Fixture (Eliminatorias)</div>
    <div id="fase2_mundial2026">
      <?php require_once('fase2_mundial2026.php');?>
    </div>
  </div>

  <div style="clear: both;"></div>
</div>

<br />
<div>
  <a href="imprimirmundial2026.php" class="botoneschicos" target="_blank">Imprimir</a>
</div>

<div style="clear:both;"></div>
<div id="final" class="final">
  <p>
    <a href="reglas.php" class="botoneschicos">Reglas del juego</a>  |
    <a href="contacto.php" class="botoneschicos">Soluci&oacute;n de Problemas</a>  |
    <a href="terminos.php" class="botoneschicos">T&eacute;rminos y condiciones de uso</a>
  </p>
  Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com/">Sebastian Porteiro</a>
  <img src="http://www.sebastianporteiro.com/favicon.ico" /><br />
</div>
</body>
</html>

