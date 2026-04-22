<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlog.php'); ?>
<?php
$today = date("YmdH");
// Ajustar límite cuando se defina oficialmente
$limite = '2026061123';
$fueraTiempo = ($limite <= $today) ? 1 : 0;
$mundial2026_uEsc = mysqli_real_escape_string($conexion, $_SESSION['MM_Username'] ?? '');

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

function asignarTercerosAMatches($tercerosTop8) {
  // Asignación determinística (no es la tabla oficial de las 495 combinaciones de FIFA).
  // Respeta conjuntos permitidos por el fixture: cada partido toma el mejor tercero disponible del conjunto permitido.
  $needs = [
    74 => ['A','B','C','D','F'],      // 1E vs 3 A/B/C/D/F
    77 => ['C','D','F','G','H'],      // 1I vs 3 C/D/F/G/H
    79 => ['C','E','F','H','I'],      // 1A vs 3 C/E/F/H/I
    80 => ['E','H','I','J','K'],      // 1L vs 3 E/H/I/J/K
    81 => ['B','E','F','I','J'],      // 1D vs 3 B/E/F/I/J
    82 => ['A','E','H','I','J'],      // 1G vs 3 A/E/H/I/J
    85 => ['E','F','G','I','J'],      // 1B vs 3 E/F/G/I/J
    87 => ['D','E','I','J','L'],      // 1K vs 3 D/E/I/J/L
  ];

  $pool = $tercerosTop8; // ya ordenado por ranking
  $used = [];
  $asignados = []; // match => terceroRow

  foreach ($needs as $match => $allowed) {
    $pickIdx = null;
    for ($i = 0; $i < count($pool); $i++) {
      if (isset($used[$pool[$i]['grupo']])) continue;
      if (in_array($pool[$i]['grupo'], $allowed, true)) {
        $pickIdx = $i;
        break;
      }
    }
    if ($pickIdx !== null) {
      $asignados[$match] = $pool[$pickIdx];
      $used[$pool[$pickIdx]['grupo']] = true;
    }
  }

  return $asignados;
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

function poblarRoundOf32() {
  // Usa equipos_mundial2026 para armar los 32avos (73-88)
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

  if ($rA && $rB) updateMatchTeams(73, $rA['nombre'], $rB['nombre']);
  if ($wE) updateMatchTeams(74, $wE['nombre'], $asig[74]['nombre'] ?? '3?');
  if ($wF && $rC) updateMatchTeams(75, $wF['nombre'], $rC['nombre']);
  if ($wC && $rF) updateMatchTeams(76, $wC['nombre'], $rF['nombre']);
  if ($wI) updateMatchTeams(77, $wI['nombre'], $asig[77]['nombre'] ?? '3?');
  if ($rE && $rI) updateMatchTeams(78, $rE['nombre'], $rI['nombre']);
  if ($wA) updateMatchTeams(79, $wA['nombre'], $asig[79]['nombre'] ?? '3?');
  if ($wL) updateMatchTeams(80, $wL['nombre'], $asig[80]['nombre'] ?? '3?');
  if ($wD) updateMatchTeams(81, $wD['nombre'], $asig[81]['nombre'] ?? '3?');
  if ($wG) updateMatchTeams(82, $wG['nombre'], $asig[82]['nombre'] ?? '3?');
  if ($rK && $rL) updateMatchTeams(83, $rK['nombre'], $rL['nombre']);
  if ($wH && $rJ) updateMatchTeams(84, $wH['nombre'], $rJ['nombre']);
  if ($wB) updateMatchTeams(85, $wB['nombre'], $asig[85]['nombre'] ?? '3?');
  if ($wJ && $rH) updateMatchTeams(86, $wJ['nombre'], $rH['nombre']);
  if ($wK) updateMatchTeams(87, $wK['nombre'], $asig[87]['nombre'] ?? '3?');
  if ($rD && $rG) updateMatchTeams(88, $rD['nombre'], $rG['nombre']);
}

function ganadorDesdePost($n) {
  if (!isset($_POST['L'.$n]) || !isset($_POST['V'.$n])) return null;
  $gl = intval($_POST['L'.$n]);
  $gv = intval($_POST['V'.$n]);
  $loc = $_POST['local'.$n] ?? null;
  $vis = $_POST['visitante'.$n] ?? null;
  if ($loc === null || $vis === null) return null;
  if ($gl > $gv) return $loc;
  if ($gl < $gv) return $vis;
  $e = $_POST['elegir'.$n] ?? null;
  return $e ?: $loc;
}

function perdedorDesdePost($n) {
  if (!isset($_POST['L'.$n]) || !isset($_POST['V'.$n])) return null;
  $gl = intval($_POST['L'.$n]);
  $gv = intval($_POST['V'.$n]);
  $loc = $_POST['local'.$n] ?? null;
  $vis = $_POST['visitante'.$n] ?? null;
  if ($loc === null || $vis === null) return null;
  if ($gl > $gv) return $vis;
  if ($gl < $gv) return $loc;
  $g = ganadorDesdePost($n);
  if ($g === $loc) return $vis;
  return $loc;
}

// Siempre intentamos poblar 32avos al cargar (si el usuario ya tiene tabla de grupos)
poblarRoundOf32();

// Guardar eliminatorias y propagar bracket
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "fase2")) {
  for ($n = 73; $n <= 104; $n++) {
    $gl = isset($_POST['L'.$n]) ? intval($_POST['L'.$n]) : 0;
    $gv = isset($_POST['V'.$n]) ? intval($_POST['V'.$n]) : 0;
    if ($gl > $gv) { $res = 1; }
    else if ($gl < $gv) { $res = 2; }
    else { $res = 0; }
    $upd = "UPDATE partidos_mundial2026
            SET glocal='".$gl."', gvisitante='".$gv."', resultado='".$res."'
            WHERE CodUsu='".$mundial2026_uEsc."' AND CodPar='".$n."'";
    mysqli_query($conexion, $upd) or die(mysqli_error($conexion));
  }

  // Extras
  if (isset($_POST['jugador']) && isset($_POST['pais'])) {
    $jug = mysqli_real_escape_string($conexion, $_POST['jugador']);
    $pais = mysqli_real_escape_string($conexion, $_POST['pais']);
    mysqli_query($conexion, "UPDATE partidos_mundial2026 SET local='".$jug."', visitante='".$pais."' WHERE CodUsu='".$mundial2026_uEsc."' AND CodPar=106") or die(mysqli_error($conexion));
  }

  // Propagar ganadores: 89-96 (octavos), 97-100 (cuartos), 101-102 (semis), 103 (3°), 104 (final)
  $w = [];
  for ($n = 73; $n <= 104; $n++) {
    $w[$n] = ganadorDesdePost($n);
  }

  // Round of 16 (89-96) según fixture FIFA (ver wikipedia)
  if ($w[74] && $w[77]) updateMatchTeams(89, $w[74], $w[77]);
  if ($w[73] && $w[75]) updateMatchTeams(90, $w[73], $w[75]);
  if ($w[76] && $w[78]) updateMatchTeams(91, $w[76], $w[78]);
  if ($w[79] && $w[80]) updateMatchTeams(92, $w[79], $w[80]);
  if ($w[83] && $w[84]) updateMatchTeams(93, $w[83], $w[84]);
  if ($w[81] && $w[82]) updateMatchTeams(94, $w[81], $w[82]);
  if ($w[86] && $w[88]) updateMatchTeams(95, $w[86], $w[88]);
  if ($w[85] && $w[87]) updateMatchTeams(96, $w[85], $w[87]);

  // Cuartos (97-100)
  if (($w89 = $w[89] ?? null) && ($w90 = $w[90] ?? null)) updateMatchTeams(97, $w89, $w90);
  if (($w93 = $w[93] ?? null) && ($w94 = $w[94] ?? null)) updateMatchTeams(98, $w93, $w94);
  if (($w91 = $w[91] ?? null) && ($w92 = $w[92] ?? null)) updateMatchTeams(99, $w91, $w92);
  if (($w95 = $w[95] ?? null) && ($w96 = $w[96] ?? null)) updateMatchTeams(100, $w95, $w96);

  // Semis (101-102)
  if (($w97 = $w[97] ?? null) && ($w98 = $w[98] ?? null)) updateMatchTeams(101, $w97, $w98);
  if (($w99 = $w[99] ?? null) && ($w100 = $w[100] ?? null)) updateMatchTeams(102, $w99, $w100);

  // Partido 3° (103): perdedores de semis 101 y 102
  $l101 = perdedorDesdePost(101);
  $l102 = perdedorDesdePost(102);
  if ($l101 && $l102) updateMatchTeams(103, $l101, $l102);

  // Final (104): ganadores de semis 101 y 102
  if (($w101 = $w[101] ?? null) && ($w102 = $w[102] ?? null)) updateMatchTeams(104, $w101, $w102);

  // Auto-completar Campeón/Tercero en CodPar 105 si ya están resueltos
  $campeon = ganadorDesdePost(104);
  $tercero = ganadorDesdePost(103);
  if ($campeon && $tercero) {
    mysqli_query($conexion, "UPDATE partidos_mundial2026 SET local='".mysqli_real_escape_string($conexion, $campeon)."', visitante='".mysqli_real_escape_string($conexion, $tercero)."' WHERE CodUsu='".$mundial2026_uEsc."' AND CodPar=105") or die(mysqli_error($conexion));
  }
}

// Cargar todos los matches 73-106 para pintar el fixture
$qAll = "SELECT CodPar, local, visitante, glocal, gvisitante
         FROM partidos_mundial2026
         WHERE CodUsu='".$mundial2026_uEsc."'
           AND CodPar BETWEEN 73 AND 106
         ORDER BY CodPar";
$rsAll = mysqli_query($conexion, $qAll) or die(mysqli_error($conexion));
$matches = [];
while ($m = mysqli_fetch_assoc($rsAll)) {
  $matches[intval($m['CodPar'])] = $m;
}

function renderMatch($n, $title) {
  global $matches;
  $m = $matches[$n] ?? ['local'=>'','visitante'=>'','glocal'=>0,'gvisitante'=>0];
  $local = htmlspecialchars($m['local'] ?? '', ENT_QUOTES);
  $vis = htmlspecialchars($m['visitante'] ?? '', ENT_QUOTES);
  $gl = intval($m['glocal'] ?? 0);
  $gv = intval($m['gvisitante'] ?? 0);
  echo "<div class='comentarios' style='margin-bottom:6px;'>";
  echo "<b>".$title."</b><br />";
  echo "<input type='hidden' name='local".$n."' value='".$local."' />";
  echo "<input type='hidden' name='visitante".$n."' value='".$vis."' />";
  echo $local." ";
  echo "<input type='number' min='0' max='99' name='L".$n."' value='".$gl."' class='botoneschicos' /> - ";
  echo "<input type='number' min='0' max='99' name='V".$n."' value='".$gv."' class='botoneschicos' /> ";
  echo $vis;
  echo " &nbsp; <select name='elegir".$n."' class='botoneschicos'>";
  echo "<option value=''>Si empatan, elige</option>";
  echo "<option value='".$local."'>".$local."</option>";
  echo "<option value='".$vis."'>".$vis."</option>";
  echo "</select>";
  echo "</div>";
}
?>
<div id="tabla_fase2">
  <form id="fase2" name="fase2" method="post" action="#">
    <input type="hidden" name="MM_update" value="fase2" />

    <div class="titulo_grupos">Round of 32</div>
    <?php
      renderMatch(73, "73: 2A vs 2B");
      renderMatch(74, "74: 1E vs 3º (A/B/C/D/F)");
      renderMatch(75, "75: 1F vs 2C");
      renderMatch(76, "76: 1C vs 2F");
      renderMatch(77, "77: 1I vs 3º (C/D/F/G/H)");
      renderMatch(78, "78: 2E vs 2I");
      renderMatch(79, "79: 1A vs 3º (C/E/F/H/I)");
      renderMatch(80, "80: 1L vs 3º (E/H/I/J/K)");
      renderMatch(81, "81: 1D vs 3º (B/E/F/I/J)");
      renderMatch(82, "82: 1G vs 3º (A/E/H/I/J)");
      renderMatch(83, "83: 2K vs 2L");
      renderMatch(84, "84: 1H vs 2J");
      renderMatch(85, "85: 1B vs 3º (E/F/G/I/J)");
      renderMatch(86, "86: 1J vs 2H");
      renderMatch(87, "87: 1K vs 3º (D/E/I/J/L)");
      renderMatch(88, "88: 2D vs 2G");
    ?>

    <div class="titulo_grupos">Round of 16</div>
    <?php
      renderMatch(89, "89: Ganador 74 vs Ganador 77");
      renderMatch(90, "90: Ganador 73 vs Ganador 75");
      renderMatch(91, "91: Ganador 76 vs Ganador 78");
      renderMatch(92, "92: Ganador 79 vs Ganador 80");
      renderMatch(93, "93: Ganador 83 vs Ganador 84");
      renderMatch(94, "94: Ganador 81 vs Ganador 82");
      renderMatch(95, "95: Ganador 86 vs Ganador 88");
      renderMatch(96, "96: Ganador 85 vs Ganador 87");
    ?>

    <div class="titulo_grupos">Quarterfinals</div>
    <?php
      renderMatch(97, "97: Ganador 89 vs Ganador 90");
      renderMatch(98, "98: Ganador 93 vs Ganador 94");
      renderMatch(99, "99: Ganador 91 vs Ganador 92");
      renderMatch(100, "100: Ganador 95 vs Ganador 96");
    ?>

    <div class="titulo_grupos">Semifinals</div>
    <?php
      renderMatch(101, "101: Ganador 97 vs Ganador 98");
      renderMatch(102, "102: Ganador 99 vs Ganador 100");
    ?>

    <div class="titulo_grupos">3rd place & Final</div>
    <?php
      renderMatch(103, "103: Perdedor 101 vs Perdedor 102 (3º puesto)");
      renderMatch(104, "104: Ganador 101 vs Ganador 102 (Final)");
    ?>

    <div class="titulo_grupos">Extras</div>
    <div class="comentarios">
      <b>Goleador</b><br />
      <input type="text" name="jugador" class="letrasgrandes" value="<?php echo htmlspecialchars($matches[106]['local'] ?? '', ENT_QUOTES); ?>" />
      <br />
      <b>Pais</b><br />
      <input type="text" name="pais" class="letrasgrandes" value="<?php echo htmlspecialchars($matches[106]['visitante'] ?? '', ENT_QUOTES); ?>" />
    </div>

    <?php if (($fueraTiempo==0) || ($_SESSION['MM_Username']=='ProfetaMundial')) { ?>
      <input type="submit" class="botones" value="Guardar fixture" />
    <?php } ?>
  </form>
</div>

