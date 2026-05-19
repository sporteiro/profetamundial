<?php
// =====================================================
// 1. MANEJAR PETICIONES AJAX (antes que cualquier otra cosa)
// =====================================================
require_once('Connections/conexion.php');
require_once('codlog.php');

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_GET['ajax_grupo'])) {
    $letra = strtoupper(trim($_GET['ajax_grupo']));
    if (preg_match('/^[A-L]$/', $letra)) {
        $archivoGrupo = 'G' . $letra . '_mundial2026.php';
        if (file_exists($archivoGrupo)) {
            include($archivoGrupo);
        } else {
            echo "Error: Archivo de grupo no encontrado.";
        }
    } else {
        echo "Error: Grupo inválido.";
    }
    exit;
}
// =====================================================
// 2. FUNCIONES Y CONSULTAS PARA PUNTUACIÓN (solo en carga normal)
// =====================================================
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  global $conexion;
  $theValue = mysqli_real_escape_string($conexion, $theValue);
  switch ($theType) {
    case "text": return ($theValue != "") ? "'" . $theValue . "'" : "NULL";
    case "long": case "int": return ($theValue != "") ? intval($theValue) : "NULL";
    case "double": return ($theValue != "") ? doubleval($theValue) : "NULL";
    case "date": return ($theValue != "") ? "'" . $theValue . "'" : "NULL";
    case "defined": return ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
  }
  return "NULL";
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_recordusuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_recordusuarios = $_SESSION['MM_Username'];
}
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$recordusuarios = mysqli_query($conexion, $query_recordusuarios) or die(mysqli_error($conexion));
$row_recordusuarios = mysqli_fetch_assoc($recordusuarios);

$uEsc = mysqli_real_escape_string($conexion, $_SESSION['MM_Username'] ?? '');
$codUsuPlantilla = 'ProfetaMundial';

// -----------------------------------------------------------------
// CÁLCULO DE PUNTOS (SOLO PARA CARGA NORMAL, NO PARA AJAX)
// -----------------------------------------------------------------
function equiposEnRango($conexion, $usuario, $inicio, $fin) {
  $u = mysqli_real_escape_string($conexion, $usuario);
  $q = "SELECT local as equipo FROM partidos_mundial2026 WHERE CodUsu='$u' AND CodPar BETWEEN $inicio AND $fin
        UNION
        SELECT visitante FROM partidos_mundial2026 WHERE CodUsu='$u' AND CodPar BETWEEN $inicio AND $fin";
  $r = mysqli_query($conexion, $q);
  $equipos = [];
  while ($row = mysqli_fetch_assoc($r)) {
    $nom = $row['equipo'];
    if (!empty($nom) && $nom != '3?' && strpos($nom, 'Ganador') === false && strpos($nom, 'Perdedor') === false) {
      $equipos[] = $nom;
    }
  }
  return array_unique($equipos);
}

function faseCompleta($conexion, $inicio, $fin) {
  $q = "SELECT COUNT(*) AS total FROM partidos_mundial2026 WHERE CodUsu='ProfetaMundial' AND CodPar BETWEEN $inicio AND $fin AND glocal=99";
  $r = mysqli_query($conexion, $q);
  if ($r) {
    $row = mysqli_fetch_assoc($r);
    return intval($row['total'] ?? 1) === 0;
  }
  return false;
}

// Partidos
$qResGrupos = "SELECT COUNT(*) AS puntos FROM partidos_mundial2026 pp JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$uEsc."' AND pp.CodUsu='".$codUsuPlantilla."' AND pp.resultado=ps.resultado AND pp.CodPar BETWEEN 1 AND 72 AND pp.glocal!=99";
$rResGrupos = mysqli_query($conexion, $qResGrupos) or die(mysqli_error($conexion));
$fResGrupos = mysqli_fetch_assoc($rResGrupos);

$qExactGrupos = "SELECT COUNT(*) AS puntos FROM partidos_mundial2026 pp JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$uEsc."' AND pp.CodUsu='".$codUsuPlantilla."' AND pp.resultado=ps.resultado AND pp.CodPar BETWEEN 1 AND 72 AND pp.glocal=ps.glocal AND pp.gvisitante=ps.gvisitante AND pp.glocal!=99";
$rExactGrupos = mysqli_query($conexion, $qExactGrupos) or die(mysqli_error($conexion));
$fExactGrupos = mysqli_fetch_assoc($rExactGrupos);

$qResKo = "SELECT COUNT(*) AS puntos FROM partidos_mundial2026 pp JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$uEsc."' AND pp.CodUsu='".$codUsuPlantilla."' AND pp.resultado=ps.resultado AND pp.CodPar BETWEEN 73 AND 104 AND pp.local=ps.local AND pp.visitante=ps.visitante AND pp.glocal!=99";
$rResKo = mysqli_query($conexion, $qResKo) or die(mysqli_error($conexion));
$fResKo = mysqli_fetch_assoc($rResKo);

$qExactKo = "SELECT COUNT(*) AS puntos FROM partidos_mundial2026 pp JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$uEsc."' AND pp.CodUsu='".$codUsuPlantilla."' AND pp.resultado=ps.resultado AND pp.CodPar BETWEEN 73 AND 104 AND pp.local=ps.local AND pp.visitante=ps.visitante AND pp.glocal=ps.glocal AND pp.gvisitante=ps.gvisitante AND pp.glocal!=99";
$rExactKo = mysqli_query($conexion, $qExactKo) or die(mysqli_error($conexion));
$fExactKo = mysqli_fetch_assoc($rExactKo);

$exactos = intval($fExactGrupos['puntos'] ?? 0) + intval($fExactKo['puntos'] ?? 0);
$pexactos = $exactos * 5;
$partidos_grupos = intval($fResGrupos['puntos'] ?? 0) - intval($fExactGrupos['puntos'] ?? 0);
$partidos_ko = intval($fResKo['puntos'] ?? 0) - intval($fExactKo['puntos'] ?? 0);
$puntospartidos_ko = $partidos_ko * 2;
$puntosPartidos = $pexactos + $partidos_grupos + $puntospartidos_ko;

// Extras: fases (con condiciones de fase completa)
$usr16 = equiposEnRango($conexion, $_SESSION['MM_Username'], 73, 88);
$real16 = faseCompleta($conexion, 1, 72) ? equiposEnRango($conexion, 'ProfetaMundial', 73, 88) : [];
$pts16 = count(array_intersect($usr16, $real16));

$usrOct = equiposEnRango($conexion, $_SESSION['MM_Username'], 89, 96);
$realOct = faseCompleta($conexion, 73, 88) ? equiposEnRango($conexion, 'ProfetaMundial', 89, 96) : [];
$ptsOct = count(array_intersect($usrOct, $realOct));

$usrCuartos = equiposEnRango($conexion, $_SESSION['MM_Username'], 97, 100);
$realCuartos = faseCompleta($conexion, 89, 96) ? equiposEnRango($conexion, 'ProfetaMundial', 97, 100) : [];
$ptsCuartos = count(array_intersect($usrCuartos, $realCuartos));

$usrSemis = equiposEnRango($conexion, $_SESSION['MM_Username'], 101, 102);
$realSemis = faseCompleta($conexion, 97, 100) ? equiposEnRango($conexion, 'ProfetaMundial', 101, 102) : [];
$ptsSemis = count(array_intersect($usrSemis, $realSemis));

$usrFinal = equiposEnRango($conexion, $_SESSION['MM_Username'], 104, 104);
$realFinal = faseCompleta($conexion, 101, 102) ? equiposEnRango($conexion, 'ProfetaMundial', 104, 104) : [];
$ptsFinal = count(array_intersect($usrFinal, $realFinal));

$usrTercer = equiposEnRango($conexion, $_SESSION['MM_Username'], 103, 103);
$realTercer = faseCompleta($conexion, 101, 102) ? equiposEnRango($conexion, 'ProfetaMundial', 103, 103) : [];
$ptsTercer = count(array_intersect($usrTercer, $realTercer));

$puntosFases = $pts16 + $ptsOct + $ptsCuartos + $ptsSemis + $ptsFinal + $ptsTercer;

// Campeón, goleador, tercer puesto
$qCampeonReal = "SELECT local FROM partidos_mundial2026 WHERE CodUsu='ProfetaMundial' AND CodPar=105";
$rCampeonReal = mysqli_query($conexion, $qCampeonReal);
$campeonReal = mysqli_fetch_assoc($rCampeonReal)['local'] ?? '';

$qTerceroReal = "SELECT visitante FROM partidos_mundial2026 WHERE CodUsu='ProfetaMundial' AND CodPar=105";
$rTerceroReal = mysqli_query($conexion, $qTerceroReal);
$terceroReal = mysqli_fetch_assoc($rTerceroReal)['visitante'] ?? '';

$qGoleadorReal = "SELECT local FROM partidos_mundial2026 WHERE CodUsu='ProfetaMundial' AND CodPar=106";
$rGoleadorReal = mysqli_query($conexion, $qGoleadorReal);
$goleadorReal = mysqli_fetch_assoc($rGoleadorReal)['local'] ?? '';

$qCampeonUsr = "SELECT local FROM partidos_mundial2026 WHERE CodUsu='$uEsc' AND CodPar=105";
$rCampeonUsr = mysqli_query($conexion, $qCampeonUsr);
$campeonUsr = mysqli_fetch_assoc($rCampeonUsr)['local'] ?? '';

$qTerceroUsr = "SELECT visitante FROM partidos_mundial2026 WHERE CodUsu='$uEsc' AND CodPar=105";
$rTerceroUsr = mysqli_query($conexion, $qTerceroUsr);
$terceroUsr = mysqli_fetch_assoc($rTerceroUsr)['visitante'] ?? '';

$qGoleadorUsr = "SELECT local FROM partidos_mundial2026 WHERE CodUsu='$uEsc' AND CodPar=106";
$rGoleadorUsr = mysqli_query($conexion, $qGoleadorUsr);
$goleadorUsr = mysqli_fetch_assoc($rGoleadorUsr)['local'] ?? '';

$puntosCampeon = ($campeonUsr == $campeonReal && !empty($campeonReal)) ? 15 : 0;
$puntosTercero = ($terceroUsr == $terceroReal && !empty($terceroReal)) ? 5 : 0;
$puntosGoleador = ($goleadorUsr == $goleadorReal && !empty($goleadorReal)) ? 10 : 0;

$total = $puntosPartidos + $puntosFases + $puntosCampeon + $puntosTercero + $puntosGoleador;

$today = date("YmdH");
$limite = '2026060923';
$fueraTiempo = ($limite <= $today) ? 1 : 0;

// Añadir CSS moderno específico
$extra_css = '<link href="css/mundial2026.css" rel="stylesheet" type="text/css">';
require_once('header.php');
?>

<!-- Contenido específico -->
<div class="contenido-mundial" style="margin-top: 100px;">

  <!-- Checkbox de autoguardado -->
  <?php
  $autosaveDisabled = ($fueraTiempo == 1 && strcasecmp($_SESSION['MM_Username'] ?? '', 'ProfetaMundial') !== 0);
  ?>
  <div class="autosave-toggle" style="margin-bottom: 15px;">
    <label <?php if ($autosaveDisabled) echo 'class="disabled" title="Autoguardado deshabilitado porque el torneo ya comenzó"'; ?>>
      <input type="checkbox" id="autosaveToggle" <?php if ($autosaveDisabled) echo 'disabled'; ?> checked> 
      Autoguardar pronósticos
    </label>
  </div>

  <!-- Navegación desktop (sticky) -->
  <div class="nav-wrapper">
    <div class="nav-toggle" id="navToggle">☰ Grupos</div>
    <div class="anchor-grupos-container" id="anchorGruposContainer">
      <div id="anchor_grupos">
        <a href="#grupoa">Grupo A</a> <a href="#grupob">Grupo B</a> <a href="#grupoc">Grupo C</a> <a href="#grupod">Grupo D</a>
        <a href="#grupoe">Grupo E</a> <a href="#grupof">Grupo F</a> <a href="#grupog">Grupo G</a> <a href="#grupoh">Grupo H</a>
        <a href="#grupoi">Grupo I</a> <a href="#grupoj">Grupo J</a> <a href="#grupok">Grupo K</a> <a href="#grupol">Grupo L</a>
        <a href="#anchor_fase2">Fase 2</a>
      </div>
    </div>
  </div>

  <!-- Modal para móvil (se abre al hacer clic en el botón hamburguesa) -->
  <div id="modalGrupos" class="modal-grupos">
    <div class="contenido-modal">
      <h3>Navegación</h3>
      <div class="lista-modal">
        <a href="#grupoa">Grupo A</a> <a href="#grupob">Grupo B</a> <a href="#grupoc">Grupo C</a> <a href="#grupod">Grupo D</a>
        <a href="#grupoe">Grupo E</a> <a href="#grupof">Grupo F</a> <a href="#grupog">Grupo G</a> <a href="#grupoh">Grupo H</a>
        <a href="#grupoi">Grupo I</a> <a href="#grupoj">Grupo J</a> <a href="#grupok">Grupo K</a> <a href="#grupol">Grupo L</a>
        <a href="#anchor_fase2">Fase 2</a>
      </div>
      <button id="cerrarModal">Cerrar</button>
    </div>
  </div>

  <div class="tablaclasificacion">
    <div class="comentarios" style="background: #1e293b; color: #e2e8f0;">
      <p>Pronostico de <b><?php echo $_SESSION['MM_Username']?></b></p>
      <p>Resultado del partido (Grupos): <?=$partidos_grupos?> (<?=$partidos_grupos?> puntos)</p>
      <p>Resultado del partido (Eliminatorias): <?=$partidos_ko?> (<?=$puntospartidos_ko?> puntos)</p>
      <p>Resultados exactos Totales: <?=$exactos?> (<?=$pexactos?> puntos)</p>
      <p><b>Extras:</b></p>
      <p>Equipos en dieciseisavos: <?=$pts16?> (<?=$pts16?> puntos)</p>
      <p>Equipos en octavos: <?=$ptsOct?> (<?=$ptsOct?> puntos)</p>
      <p>Equipos en cuartos: <?=$ptsCuartos?> (<?=$ptsCuartos?> puntos)</p>
      <p>Equipos en semifinales: <?=$ptsSemis?> (<?=$ptsSemis?> puntos)</p>
      <p>Equipos en tercer puesto: <?=$ptsTercer?> (<?=$ptsTercer?> puntos)</p>
      <p>Equipos en final: <?=$ptsFinal?> (<?=$ptsFinal?> puntos)</p>
      <p>Tercero: <?=$puntosTercero?> (<?=$puntosTercero?> puntos)</p>
      <p>Goleador: <?=$puntosGoleador?> (<?=$puntosGoleador?> puntos)</p>
      <p>Campeón: <?=$puntosCampeon?> (<?=$puntosCampeon?> puntos)</p>
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
    <div class="titulo_grupos">Fase 2 (Eliminatorias)</div>
    <div id="fase2_mundial2026">
      <?php require_once('fase2_mundial2026.php');?>
    </div>
  </div>

  <div style="clear: both;"></div>

  <div style="text-align: center; margin: 20px 0;">
    <a href="imprimirmundial2026.php" class="btn-small" target="_blank">Imprimir</a>
  </div>
</div>

<script>
$(document).ready(function() {
  // Persistencia del checkbox
  var autosaveKey = 'autosaveMundial2026';
  var $toggle = $('#autosaveToggle');
  var saved = localStorage.getItem(autosaveKey);
  if (saved !== null) {
    $toggle.prop('checked', saved === 'true');
  }
  $toggle.change(function() {
    localStorage.setItem(autosaveKey, $(this).is(':checked'));
  });

  // Modal para móvil (hamburguesa)
  var $modal = $('#modalGrupos');
  var $navToggle = $('#navToggle');
  var $cerrarModal = $('#cerrarModal');
  var $modalLinks = $('#modalGrupos a');

  // Abrir modal
  $navToggle.click(function() {
    $modal.fadeIn(300);
  });
  // Cerrar modal con botón
  $cerrarModal.click(function() {
    $modal.fadeOut(300);
  });
  // Cerrar modal al hacer clic en un enlace y desplazar
  $modalLinks.click(function(e) {
    e.preventDefault();
    var target = $(this).attr('href');
    $modal.fadeOut(300);
    setTimeout(function() {
      if (target && target !== '#') {
        $('html, body').animate({
          scrollTop: $(target).offset().top - 90  // Compensa el header fijo
        }, 500);
      }
    }, 150);
  });
  // Cerrar modal al hacer clic fuera del contenido
  $(document).mouseup(function(e) {
    if ($modal.is(':visible') && !$(e.target).closest('.contenido-modal').length) {
      $modal.fadeOut(300);
    }
  });

  // Versión escritorio: el sticky funciona solo para pantallas grandes
  // No hacemos nada más.
});

// Función global para recargar la fase final por AJAX
window.actualizarFase2 = function() {
  $('#fase2_mundial2026').load('fase2_mundial2026.php', function() {
    if (typeof fase2InitAutosave === 'function') {
      fase2InitAutosave();
    }
  });
};

// Seleccionar automáticamente el contenido de los inputs number
$(document).on('click', 'input[type="number"]', function(e) {
  $(this).select();
});
</script>

<?php require_once('footer.php'); ?>