<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlog.php'); ?>
<?php
$today = date("YmdH");
$limite = '2026060923';
$fueraTiempo = ($limite <= $today) ? 1 : 0;
$mundial2026_uEsc = mysqli_real_escape_string($conexion, $_SESSION['MM_Username'] ?? '');
$esAdmin = (isset($_SESSION['MM_Username']) && strcasecmp($_SESSION['MM_Username'], 'ProfetaMundial') === 0);
$inputsDisabled = ($fueraTiempo == 1 && !$esAdmin);

// -----------------------------------------------------------------
// FUNCIONES AUXILIARES (grupoPosicion, terceros, etc.)
// -----------------------------------------------------------------
function grupoPosicion($grupo, $pos) {
  global $conexion, $mundial2026_uEsc;
  $pos = intval($pos) - 1;
  if ($pos < 0) return null;
  $q = "SELECT nombre, puntos, difgol, golfav
        FROM equipos_mundial2026
        WHERE CodUsu='".$mundial2026_uEsc."'
          AND grupo='".mysqli_real_escape_string($conexion, $grupo)."'
        ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre
        LIMIT ".$pos.",1";
  $rs = mysqli_query($conexion, $q);
  if (!$rs) return null;
  return mysqli_fetch_assoc($rs) ?: null;
}

function tercerosClasificados() {
  global $conexion;
  $grupos = ['A','B','C','D','E','F','G','H','I','J','K','L'];
  $terceros = [];
  foreach ($grupos as $g) {
    $row = grupoPosicion($g, 3);
    if (!$row) continue;
    $terceros[] = [
      'grupo' => $g,
      'nombre' => $row['nombre'],
      'puntos' => intval($row['puntos']),
      'difgol' => intval($row['difgol']),
      'golfav' => intval($row['golfav']),
    ];
  }
  usort($terceros, function($a, $b) {
    if ($a['puntos'] !== $b['puntos']) return $b['puntos'] <=> $a['puntos'];
    if ($a['difgol'] !== $b['difgol']) return $b['difgol'] <=> $a['difgol'];
    if ($a['golfav'] !== $b['golfav']) return $b['golfav'] <=> $a['golfav'];
    return strcmp($a['grupo'], $b['grupo']);
  });
  return array_slice($terceros, 0, 8);
}

// ---------------------------------------------------------------
// TABLA OFICIAL DE LA FIFA (495 combinaciones) – desde archivo externo
// ---------------------------------------------------------------
function cargarTablaFIFA() {
  $archivo = __DIR__ . '/third_combinations.php';
  if (!file_exists($archivo)) {
    file_put_contents(__DIR__ . '/fase2_debug.log', date('Y-m-d H:i:s') . " - ERROR: Archivo no encontrado: $archivo\n", FILE_APPEND);
    return [];
  }
  $tabla = require $archivo;
  if (!is_array($tabla)) {
    file_put_contents(__DIR__ . '/fase2_debug.log', date('Y-m-d H:i:s') . " - ERROR: El archivo de combinaciones no devolvió un array.\n", FILE_APPEND);
    return [];
  }
  file_put_contents(__DIR__ . '/fase2_debug.log', date('Y-m-d H:i:s') . " - INFO: Tabla FIFA cargada correctamente con " . count($tabla) . " combinaciones.\n", FILE_APPEND);
  return $tabla;
}

function asignarTercerosAMatches($tercerosTop8) {
  $log = '';
  // Mapeo de slots FIFA a números de partido
  $slotToMatch = [
    '1E' => 74,
    '1I' => 77,
    '1A' => 79,
    '1L' => 80,
    '1D' => 81,
    '1G' => 82,
    '1B' => 85,
    '1K' => 87,
  ];

  // Ordenar terceros por grupo alfabéticamente para generar clave
  // La tabla FIFA usa claves alfabéticas (ej: BDEFIJKL, EFGHIJKL)
  $grupos = array_column($tercerosTop8, 'grupo');
  sort($grupos);
  $clave = implode('', $grupos);

  $log .= "Terceros clasificados: " . implode(', ', $grupos) . "\n";
  $log .= "Clave generada: $clave\n";

  // Buscar en la tabla FIFA
  $tabla = cargarTablaFIFA();
  $asignacion = $tabla[$clave] ?? null;

  if (!$asignacion) {
    $log .= "ERROR: Combinación no encontrada en tabla FIFA.\n";
    file_put_contents(__DIR__ . '/fase2_debug.log', date('Y-m-d H:i:s') . " - " . $log, FILE_APPEND);
    return []; // Devolver vacío, se usarán placeholders '3?'
  }

  $log .= "Asignación encontrada: " . json_encode($asignacion) . "\n";

  // Construir resultado final: partido => datos del tercero
  $resultado = [];
  foreach ($slotToMatch as $slot => $matchNo) {
    $grupoTercero = $asignacion[$slot] ?? null;
    if (!$grupoTercero) continue;

    // Extraer solo la letra del grupo (quitar el '3' de '3E', '3J', etc.)
    $grupoLetra = substr($grupoTercero, -1);

    // Buscar los datos completos del tercero
    foreach ($tercerosTop8 as $tercero) {
      if ($tercero['grupo'] === $grupoLetra) {
        $resultado[$matchNo] = $tercero;
        $log .= "Partido $matchNo ($slot): tercero del grupo {$tercero['grupo']} ({$tercero['nombre']})\n";
        break;
      }
    }
  }

  file_put_contents(__DIR__ . '/fase2_debug.log', date('Y-m-d H:i:s') . " - " . $log, FILE_APPEND);
  return $resultado;
}

function updateMatchTeams($matchNo, $local, $visitante) {
  global $conexion;
  $u = mysqli_real_escape_string($conexion, $_SESSION['MM_Username']);
  $localEsc = mysqli_real_escape_string($conexion, $local);
  $visEsc = mysqli_real_escape_string($conexion, $visitante);
  $q = "UPDATE partidos_mundial2026
        SET local='".$localEsc."', visitante='".$visEsc."'
        WHERE CodUsu='".$u."' AND CodPar='".intval($matchNo)."'";
  mysqli_query($conexion, $q) or die(mysqli_error($conexion));
}

function ganadorDesdeGoles($golesLocal, $golesVisit, $equipoLocal, $equipoVisit, $elegido = null) {
  if ($golesLocal > $golesVisit) return $equipoLocal;
  if ($golesLocal < $golesVisit) return $equipoVisit;
  return $elegido ?: $equipoLocal;
}

function perdedorDesdeGoles($golesLocal, $golesVisit, $equipoLocal, $equipoVisit, $elegido = null) {
  $ganador = ganadorDesdeGoles($golesLocal, $golesVisit, $equipoLocal, $equipoVisit, $elegido);
  if ($ganador === $equipoLocal) return $equipoVisit;
  return $equipoLocal;
}

// -----------------------------------------------------------------
// 1. POBLAR LOS 32AVOS (73-88) SEGÚN GRUPOS ACTUALES
// -----------------------------------------------------------------
function poblarRoundOf32() {
  global $conexion, $mundial2026_uEsc;
  $q = "SELECT CodPar, local, visitante FROM partidos_mundial2026
        WHERE CodUsu='".$mundial2026_uEsc."' AND CodPar BETWEEN 73 AND 88";
  $rs = mysqli_query($conexion, $q);
  $partidosActuales = [];
  while ($row = mysqli_fetch_assoc($rs)) {
    $partidosActuales[intval($row['CodPar'])] = $row;
  }

  $wA = grupoPosicion('A', 1); $rA = grupoPosicion('A', 2);
  $wB = grupoPosicion('B', 1); $rB = grupoPosicion('B', 2);
  $wC = grupoPosicion('C', 1); $rC = grupoPosicion('C', 2);
  $wD = grupoPosicion('D', 1); $rD = grupoPosicion('D', 2);
  $wE = grupoPosicion('E', 1); $rE = grupoPosicion('E', 2);
  $wF = grupoPosicion('F', 1); $rF = grupoPosicion('F', 2);
  $wG = grupoPosicion('G', 1); $rG = grupoPosicion('G', 2);
  $wH = grupoPosicion('H', 1); $rH = grupoPosicion('H', 2);
  $wI = grupoPosicion('I', 1); $rI = grupoPosicion('I', 2);
  $wJ = grupoPosicion('J', 1); $rJ = grupoPosicion('J', 2);
  $wK = grupoPosicion('K', 1); $rK = grupoPosicion('K', 2);
  $wL = grupoPosicion('L', 1); $rL = grupoPosicion('L', 2);

  $terceros = tercerosClasificados();
  $asig = asignarTercerosAMatches($terceros);

  $log = '';
  // SIEMPRE actualizar todos los cruces según el estado actual de los grupos
  if ($rA && $rB) { updateMatchTeams(73, $rA['nombre'], $rB['nombre']); $log .= "Actualizado partido 73: {$rA['nombre']} vs {$rB['nombre']}\n"; }
  if ($wE) { $tercero = $asig[74]['nombre'] ?? '3?'; updateMatchTeams(74, $wE['nombre'], $tercero); $log .= "Actualizado partido 74: {$wE['nombre']} vs $tercero\n"; }
  if ($wF && $rC) { updateMatchTeams(75, $wF['nombre'], $rC['nombre']); $log .= "Actualizado partido 75: {$wF['nombre']} vs {$rC['nombre']}\n"; }
  if ($wC && $rF) { updateMatchTeams(76, $wC['nombre'], $rF['nombre']); $log .= "Actualizado partido 76: {$wC['nombre']} vs {$rF['nombre']}\n"; }
  if ($wI) { $tercero = $asig[77]['nombre'] ?? '3?'; updateMatchTeams(77, $wI['nombre'], $tercero); $log .= "Actualizado partido 77: {$wI['nombre']} vs $tercero\n"; }
  if ($rE && $rI) { updateMatchTeams(78, $rE['nombre'], $rI['nombre']); $log .= "Actualizado partido 78: {$rE['nombre']} vs {$rI['nombre']}\n"; }
  if ($wA) { $tercero = $asig[79]['nombre'] ?? '3?'; updateMatchTeams(79, $wA['nombre'], $tercero); $log .= "Actualizado partido 79: {$wA['nombre']} vs $tercero\n"; }
  if ($wL) { $tercero = $asig[80]['nombre'] ?? '3?'; updateMatchTeams(80, $wL['nombre'], $tercero); $log .= "Actualizado partido 80: {$wL['nombre']} vs $tercero\n"; }
  if ($wD) { $tercero = $asig[81]['nombre'] ?? '3?'; updateMatchTeams(81, $wD['nombre'], $tercero); $log .= "Actualizado partido 81: {$wD['nombre']} vs $tercero\n"; }
  if ($wG) { $tercero = $asig[82]['nombre'] ?? '3?'; updateMatchTeams(82, $wG['nombre'], $tercero); $log .= "Actualizado partido 82: {$wG['nombre']} vs $tercero\n"; }
  if ($rK && $rL) { updateMatchTeams(83, $rK['nombre'], $rL['nombre']); $log .= "Actualizado partido 83: {$rK['nombre']} vs {$rL['nombre']}\n"; }
  if ($wH && $rJ) { updateMatchTeams(84, $wH['nombre'], $rJ['nombre']); $log .= "Actualizado partido 84: {$wH['nombre']} vs {$rJ['nombre']}\n"; }
  if ($wB) { $tercero = $asig[85]['nombre'] ?? '3?'; updateMatchTeams(85, $wB['nombre'], $tercero); $log .= "Actualizado partido 85: {$wB['nombre']} vs $tercero\n"; }
  if ($wJ && $rH) { updateMatchTeams(86, $wJ['nombre'], $rH['nombre']); $log .= "Actualizado partido 86: {$wJ['nombre']} vs {$rH['nombre']}\n"; }
  if ($wK) { $tercero = $asig[87]['nombre'] ?? '3?'; updateMatchTeams(87, $wK['nombre'], $tercero); $log .= "Actualizado partido 87: {$wK['nombre']} vs $tercero\n"; }
  if ($rD && $rG) { updateMatchTeams(88, $rD['nombre'], $rG['nombre']); $log .= "Actualizado partido 88: {$rD['nombre']} vs {$rG['nombre']}\n"; }

  file_put_contents(__DIR__ . '/fase2_debug.log', date('Y-m-d H:i:s') . " - INFO: Resultados de poblarRoundOf32:\n$log", FILE_APPEND);
}

// -----------------------------------------------------------------
// 2. RECALCULAR TODO EL BRACKET (octavos, cuartos, semis, final)
// -----------------------------------------------------------------
function recalcularBracketCompleto() {
  global $conexion, $mundial2026_uEsc;

  $q = "SELECT CodPar, local, visitante, glocal, gvisitante, desempate
        FROM partidos_mundial2026
        WHERE CodUsu='".$mundial2026_uEsc."'
          AND CodPar BETWEEN 73 AND 106
        ORDER BY CodPar";
  $rs = mysqli_query($conexion, $q);
  $partidos = [];
  while ($row = mysqli_fetch_assoc($rs)) {
    $partidos[intval($row['CodPar'])] = $row;
  }

  $ganador = [];
  $perdedor = [];
  for ($n = 73; $n <= 104; $n++) {
    $p = $partidos[$n] ?? null;
    if ($p) {
      $gl = intval($p['glocal']);
      $gv = intval($p['gvisitante']);
      $loc = $p['local'];
      $vis = $p['visitante'];
      $elegido = $p['desempate'] ?? null;
      if ($gl > $gv) {
        $ganador[$n] = $loc;
        $perdedor[$n] = $vis;
      } elseif ($gl < $gv) {
        $ganador[$n] = $vis;
        $perdedor[$n] = $loc;
      } else {
        $ganador[$n] = $elegido ?: $loc;
        $perdedor[$n] = ($ganador[$n] === $loc) ? $vis : $loc;
      }
    }
  }

  // Octavos
  if (isset($ganador[74]) && isset($ganador[77])) { updateMatchTeams(89, $ganador[74], $ganador[77]); $partidos[89]['local'] = $ganador[74]; $partidos[89]['visitante'] = $ganador[77]; }
  if (isset($ganador[73]) && isset($ganador[75])) { updateMatchTeams(90, $ganador[73], $ganador[75]); $partidos[90]['local'] = $ganador[73]; $partidos[90]['visitante'] = $ganador[75]; }
  if (isset($ganador[76]) && isset($ganador[78])) { updateMatchTeams(91, $ganador[76], $ganador[78]); $partidos[91]['local'] = $ganador[76]; $partidos[91]['visitante'] = $ganador[78]; }
  if (isset($ganador[79]) && isset($ganador[80])) { updateMatchTeams(92, $ganador[79], $ganador[80]); $partidos[92]['local'] = $ganador[79]; $partidos[92]['visitante'] = $ganador[80]; }
  if (isset($ganador[83]) && isset($ganador[84])) { updateMatchTeams(93, $ganador[83], $ganador[84]); $partidos[93]['local'] = $ganador[83]; $partidos[93]['visitante'] = $ganador[84]; }
  if (isset($ganador[81]) && isset($ganador[82])) { updateMatchTeams(94, $ganador[81], $ganador[82]); $partidos[94]['local'] = $ganador[81]; $partidos[94]['visitante'] = $ganador[82]; }
  if (isset($ganador[86]) && isset($ganador[88])) { updateMatchTeams(95, $ganador[86], $ganador[88]); $partidos[95]['local'] = $ganador[86]; $partidos[95]['visitante'] = $ganador[88]; }
  if (isset($ganador[85]) && isset($ganador[87])) { updateMatchTeams(96, $ganador[85], $ganador[87]); $partidos[96]['local'] = $ganador[85]; $partidos[96]['visitante'] = $ganador[87]; }

  for ($n = 89; $n <= 96; $n++) {
    $p = $partidos[$n] ?? null;
    if ($p) {
      $gl = intval($p['glocal']);
      $gv = intval($p['gvisitante']);
      $loc = $p['local'];
      $vis = $p['visitante'];
      $elegido = $p['desempate'] ?? null;
      if ($gl > $gv) { $ganador[$n] = $loc; $perdedor[$n] = $vis; }
      elseif ($gl < $gv) { $ganador[$n] = $vis; $perdedor[$n] = $loc; }
      else { $ganador[$n] = $elegido ?: $loc; $perdedor[$n] = ($ganador[$n] === $loc) ? $vis : $loc; }
    }
  }

  // Cuartos
  if (isset($ganador[89]) && isset($ganador[90])) { updateMatchTeams(97, $ganador[89], $ganador[90]); $partidos[97]['local'] = $ganador[89]; $partidos[97]['visitante'] = $ganador[90]; }
  if (isset($ganador[93]) && isset($ganador[94])) { updateMatchTeams(98, $ganador[93], $ganador[94]); $partidos[98]['local'] = $ganador[93]; $partidos[98]['visitante'] = $ganador[94]; }
  if (isset($ganador[91]) && isset($ganador[92])) { updateMatchTeams(99, $ganador[91], $ganador[92]); $partidos[99]['local'] = $ganador[91]; $partidos[99]['visitante'] = $ganador[92]; }
  if (isset($ganador[95]) && isset($ganador[96])) { updateMatchTeams(100, $ganador[95], $ganador[96]); $partidos[100]['local'] = $ganador[95]; $partidos[100]['visitante'] = $ganador[96]; }

  for ($n = 97; $n <= 100; $n++) {
    $p = $partidos[$n] ?? null;
    if ($p) {
      $gl = intval($p['glocal']);
      $gv = intval($p['gvisitante']);
      $loc = $p['local'];
      $vis = $p['visitante'];
      $elegido = $p['desempate'] ?? null;
      if ($gl > $gv) { $ganador[$n] = $loc; $perdedor[$n] = $vis; }
      elseif ($gl < $gv) { $ganador[$n] = $vis; $perdedor[$n] = $loc; }
      else { $ganador[$n] = $elegido ?: $loc; $perdedor[$n] = ($ganador[$n] === $loc) ? $vis : $loc; }
    }
  }

  // Semifinales
  if (isset($ganador[97]) && isset($ganador[98])) { updateMatchTeams(101, $ganador[97], $ganador[98]); $partidos[101]['local'] = $ganador[97]; $partidos[101]['visitante'] = $ganador[98]; }
  if (isset($ganador[99]) && isset($ganador[100])) { updateMatchTeams(102, $ganador[99], $ganador[100]); $partidos[102]['local'] = $ganador[99]; $partidos[102]['visitante'] = $ganador[100]; }

  for ($n = 101; $n <= 102; $n++) {
    $p = $partidos[$n] ?? null;
    if ($p) {
      $gl = intval($p['glocal']);
      $gv = intval($p['gvisitante']);
      $loc = $p['local'];
      $vis = $p['visitante'];
      $elegido = $p['desempate'] ?? null;
      if ($gl > $gv) { $ganador[$n] = $loc; $perdedor[$n] = $vis; }
      elseif ($gl < $gv) { $ganador[$n] = $vis; $perdedor[$n] = $loc; }
      else { $ganador[$n] = $elegido ?: $loc; $perdedor[$n] = ($ganador[$n] === $loc) ? $vis : $loc; }
    }
  }

  // Tercer puesto y final
  if (isset($perdedor[101]) && isset($perdedor[102])) updateMatchTeams(103, $perdedor[101], $perdedor[102]);
  if (isset($ganador[101]) && isset($ganador[102])) updateMatchTeams(104, $ganador[101], $ganador[102]);

  $g104 = $partidos[104] ?? null;
  $g103 = $partidos[103] ?? null;
  if ($g104 && $g103) {
    $campeon = ganadorDesdeGoles(intval($g104['glocal']), intval($g104['gvisitante']), $g104['local'], $g104['visitante'], $g104['desempate'] ?? null);
    $tercero = ganadorDesdeGoles(intval($g103['glocal']), intval($g103['gvisitante']), $g103['local'], $g103['visitante'], $g103['desempate'] ?? null);
    if ($campeon && $tercero) updateMatchTeams(105, $campeon, $tercero);
  }
}

// -----------------------------------------------------------------
// 3. PROCESAR POST (cuando se guarda la fase2)
// -----------------------------------------------------------------
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "fase2") && !$inputsDisabled) {
  for ($n = 73; $n <= 104; $n++) {
    $gl = isset($_POST['L'.$n]) ? intval($_POST['L'.$n]) : 0;
    $gv = isset($_POST['V'.$n]) ? intval($_POST['V'.$n]) : 0;
    if ($gl > $gv) $res = 1;
    else if ($gl < $gv) $res = 2;
    else $res = 0;
    $upd = "UPDATE partidos_mundial2026 SET glocal='".$gl."', gvisitante='".$gv."', resultado='".$res."' WHERE CodUsu='".$mundial2026_uEsc."' AND CodPar='".$n."'";
    mysqli_query($conexion, $upd) or die(mysqli_error($conexion));

    // Guardar desempate
    $elegido = isset($_POST['elegir'.$n]) ? $_POST['elegir'.$n] : '';
    $upd2 = "UPDATE partidos_mundial2026 SET desempate='".mysqli_real_escape_string($conexion, $elegido)."' WHERE CodUsu='".$mundial2026_uEsc."' AND CodPar='".$n."'";
    mysqli_query($conexion, $upd2) or die(mysqli_error($conexion));
  }

  if (isset($_POST['jugador']) && isset($_POST['pais'])) {
    $jug = mysqli_real_escape_string($conexion, $_POST['jugador']);
    $pais = mysqli_real_escape_string($conexion, $_POST['pais']);
    mysqli_query($conexion, "UPDATE partidos_mundial2026 SET local='".$jug."', visitante='".$pais."' WHERE CodUsu='".$mundial2026_uEsc."' AND CodPar=106") or die(mysqli_error($conexion));
  }

  recalcularBracketCompleto();
}

// -----------------------------------------------------------------
// 4. CARGA NORMAL
// -----------------------------------------------------------------
poblarRoundOf32();
recalcularBracketCompleto();

// -----------------------------------------------------------------
// 5. MOSTRAR EL HTML DE LA FASE2
// -----------------------------------------------------------------
$qAll = "SELECT CodPar, local, visitante, glocal, gvisitante, desempate
         FROM partidos_mundial2026
         WHERE CodUsu='".$mundial2026_uEsc."'
           AND CodPar BETWEEN 73 AND 106
         ORDER BY CodPar";
$rsAll = mysqli_query($conexion, $qAll) or die(mysqli_error($conexion));
$matches = [];
while ($m = mysqli_fetch_assoc($rsAll)) {
  $matches[intval($m['CodPar'])] = $m;
}

function mostrarEquipoConBandera($nombre) {
  if (empty($nombre)) return '';
  if (strpos($nombre, 'Ganador') !== false || strpos($nombre, 'Perdedor') !== false || strpos($nombre, 'Semifinalista') !== false || strpos($nombre, '3?') !== false || strpos($nombre, '3º') !== false) {
    return htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
  }
  $bandera = '<img src="imagenes/banamerica/'.rawurlencode($nombre).'.gif" width="20" height="10" alt="" style="margin-right:3px; vertical-align:middle;" />';
  return $bandera . ' ' . htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
}

function renderMatch($n, $title, $matches) {
  global $inputsDisabled;
  $m = $matches[$n] ?? ['local'=>'','visitante'=>'','glocal'=>0,'gvisitante'=>0,'desempate'=>''];
  $localHtml = mostrarEquipoConBandera($m['local']);
  $visHtml = mostrarEquipoConBandera($m['visitante']);
  $gl = intval($m['glocal'] ?? 0);
  $gv = intval($m['gvisitante'] ?? 0);
  $empate = ($gl == $gv);
  $desempate = $m['desempate'] ?? '';
  echo "<div class='partido-ko'>";
  echo "<b>".htmlspecialchars($title, ENT_QUOTES)."</b><br />";
  echo "<input type='hidden' name='local".$n."' value='".htmlspecialchars($m['local'], ENT_QUOTES)."' />";
  echo "<input type='hidden' name='visitante".$n."' value='".htmlspecialchars($m['visitante'], ENT_QUOTES)."' />";
  echo $localHtml." ";
  echo "<input type='number' min='0' max='99' name='L".$n."' value='".$gl."' class='botoneschicos' ".($inputsDisabled ? 'disabled' : '')." /> - ";
  echo "<input type='number' min='0' max='99' name='V".$n."' value='".$gv."' class='botoneschicos' ".($inputsDisabled ? 'disabled' : '')." /> ";
  echo $visHtml;
  if ($empate) {
    echo " &nbsp; <select name='elegir".$n."' class='botoneschicos' ".($inputsDisabled ? 'disabled' : '').">";
    echo "<option value=''>Si empatan, elegí</option>";
    echo "<option value='".htmlspecialchars($m['local'], ENT_QUOTES)."'".($desempate == $m['local'] ? " selected" : "").">".htmlspecialchars($m['local'], ENT_QUOTES)."</option>";
    echo "<option value='".htmlspecialchars($m['visitante'], ENT_QUOTES)."'".($desempate == $m['visitante'] ? " selected" : "").">".htmlspecialchars($m['visitante'], ENT_QUOTES)."</option>";
    echo "</select>";
  } else {
    echo "<input type='hidden' name='elegir".$n."' value='' />";
  }
  echo "</div>";
}
?>
<div id="tabla_fase2">
  <form id="fase2" name="fase2" method="post" action="#">
    <input type="hidden" name="MM_update" value="fase2" />

    <div class="titulo_grupos">Dieciseisavos de final</div>
    <div class="ronda">
      <?php
        renderMatch(73, "73: 2A vs 2B", $matches);
        renderMatch(74, "74: 1E vs 3º (A/B/C/D/F)", $matches);
        renderMatch(75, "75: 1F vs 2C", $matches);
        renderMatch(76, "76: 1C vs 2F", $matches);
        renderMatch(77, "77: 1I vs 3º (C/D/F/G/H)", $matches);
        renderMatch(78, "78: 2E vs 2I", $matches);
        renderMatch(79, "79: 1A vs 3º (C/E/F/H/I)", $matches);
        renderMatch(80, "80: 1L vs 3º (E/H/I/J/K)", $matches);
        renderMatch(81, "81: 1D vs 3º (B/E/F/I/J)", $matches);
        renderMatch(82, "82: 1G vs 3º (A/E/H/I/J)", $matches);
        renderMatch(83, "83: 2K vs 2L", $matches);
        renderMatch(84, "84: 1H vs 2J", $matches);
        renderMatch(85, "85: 1B vs 3º (E/F/G/I/J)", $matches);
        renderMatch(86, "86: 1J vs 2H", $matches);
        renderMatch(87, "87: 1K vs 3º (D/E/I/J/L)", $matches);
        renderMatch(88, "88: 2D vs 2G", $matches);
      ?>
    </div>

    <div class="titulo_grupos">Octavos de final</div>
    <div class="ronda">
      <?php
        renderMatch(89, "89: Ganador 74 vs Ganador 77", $matches);
        renderMatch(90, "90: Ganador 73 vs Ganador 75", $matches);
        renderMatch(91, "91: Ganador 76 vs Ganador 78", $matches);
        renderMatch(92, "92: Ganador 79 vs Ganador 80", $matches);
        renderMatch(93, "93: Ganador 83 vs Ganador 84", $matches);
        renderMatch(94, "94: Ganador 81 vs Ganador 82", $matches);
        renderMatch(95, "95: Ganador 86 vs Ganador 88", $matches);
        renderMatch(96, "96: Ganador 85 vs Ganador 87", $matches);
      ?>
    </div>

    <div class="titulo_grupos">Cuartos de final</div>
    <div class="ronda">
      <?php
        renderMatch(97, "97: Ganador 89 vs Ganador 90", $matches);
        renderMatch(98, "98: Ganador 93 vs Ganador 94", $matches);
        renderMatch(99, "99: Ganador 91 vs Ganador 92", $matches);
        renderMatch(100, "100: Ganador 95 vs Ganador 96", $matches);
      ?>
    </div>

    <div class="titulo_grupos">Semifinales</div>
    <div class="ronda">
      <?php
        renderMatch(101, "101: Ganador 97 vs Ganador 98", $matches);
        renderMatch(102, "102: Ganador 99 vs Ganador 100", $matches);
      ?>
    </div>

    <div class="titulo_grupos">Tercer y cuarto puesto</div>
    <div class="ronda">
      <?php
        renderMatch(103, "103: Perdedor 101 vs Perdedor 102 (3º puesto)", $matches);
      ?>
    </div>

    <div class="titulo_grupos">Final</div>
    <div class="ronda">
      <?php
        renderMatch(104, "104: Ganador 101 vs Ganador 102 (Final)", $matches);
      ?>
    </div>

    <!-- Extras unificado -->
    <div class="titulo_grupos">Extras</div>
    <div class="extras-box">
      <?php
      $final = $matches[104] ?? null;
      $tercer = $matches[103] ?? null;
      $especial = $matches[105] ?? null;
      $goleador = $matches[106] ?? null;

      $campeon = '';
      $subcampeon = '';
      $tercerPuesto = '';

      if ($final) {
        $gL = intval($final['glocal']);
        $gV = intval($final['gvisitante']);
        $elegido = $final['desempate'] ?? null;
        if ($gL > $gV) {
          $campeon = $final['local'];
          $subcampeon = $final['visitante'];
        } elseif ($gL < $gV) {
          $campeon = $final['visitante'];
          $subcampeon = $final['local'];
        } else {
          $campeon = $elegido ?: $final['local'];
          $subcampeon = ($campeon === $final['local']) ? $final['visitante'] : $final['local'];
        }
      }
      if ($tercer) {
        $gL = intval($tercer['glocal']);
        $gV = intval($tercer['gvisitante']);
        $elegido = $tercer['desempate'] ?? null;
        if ($gL > $gV) $tercerPuesto = $tercer['local'];
        elseif ($gL < $gV) $tercerPuesto = $tercer['visitante'];
        else $tercerPuesto = $elegido ?: $tercer['local'];
      }
      if (!$campeon && $especial) {
        $campeon = $especial['local'];
        $tercerPuesto = $especial['visitante'];
      }
      ?>
      <p><strong>🏆 CAMPEÓN:</strong> <?php echo mostrarEquipoConBandera($campeon ?: '—'); ?></p>
      <p><strong>🥈 SUBCAMPEÓN:</strong> <?php echo mostrarEquipoConBandera($subcampeon ?: '—'); ?></p>
      <p><strong>🥉 3º PUESTO:</strong> <?php echo mostrarEquipoConBandera($tercerPuesto ?: '—'); ?></p>

      <!-- NUEVO: inputs para goleador y país -->
      <p>
        <strong>⚽ GOLEADOR:</strong>
        <input type="text" name="jugador" value="<?php echo htmlspecialchars($goleador['local'] ?? '', ENT_QUOTES); ?>" placeholder="Apellido del jugador" class="botoneschicos" style="width:200px;" <?php echo $inputsDisabled ? 'disabled' : ''; ?> />
        <select name="pais" class="botoneschicos" <?php echo $inputsDisabled ? 'disabled' : ''; ?>>
          <option value="">Seleccionar país</option>
          <?php
          $equipos = mysqli_query($conexion, "SELECT nombre FROM equipos_mundial2026 WHERE CodUsu='".$mundial2026_uEsc."' ORDER BY nombre");
          while ($eq = mysqli_fetch_assoc($equipos)) {
            $selected = (($goleador['visitante'] ?? '') === $eq['nombre']) ? ' selected' : '';
            echo '<option value="'.htmlspecialchars($eq['nombre'], ENT_QUOTES).'"'.$selected.'>'.htmlspecialchars($eq['nombre'], ENT_QUOTES).'</option>';
          }
          ?>
        </select>
      </p>
    </div>

    <!-- Botón de guardar manual -->
    <?php if (!$inputsDisabled) { ?>
      <div style="text-align:center; margin:20px 0;">
        <button type="submit" class="btn-small" >Guardar todos los cambios</button>
      </div>
    <?php } ?>
  </form>
</div>

<script>
function fase2InitAutosave() {
  $('#fase2 input[type="number"], #fase2 select').off('change.autosave').on('change.autosave', function() {
    var $toggle = $('#autosaveToggle');
    if ($toggle.length && $toggle.is(':checked')) {
      var $form = $('#fase2');
      $.ajax({
        type: 'POST',
        url: window.location.href,
        data: $form.serialize(),
        success: function() {
          if (typeof window.actualizarFase2 === 'function') {
            window.actualizarFase2();
          } else {
            $('#fase2_mundial2026').load('fase2_mundial2026.php');
          }
        },
        error: function() {
          alert('Error al guardar la fase final.');
        }
      });
    }
  });
}

$(document).ready(function() {
  fase2InitAutosave();
});
</script>