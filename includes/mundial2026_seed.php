<?php
/**
 * Detecta columnas de fecha en `partidos_mundial2026` (esquema mezclado: `fecha` legado NOT NULL y/o `fecha_partido`).
 *
 * @param mysqli $conexion
 * @return array{fecha:bool,fecha_partido:bool}
 */
function mundial2026_partidos_fecha_columns($conexion) {
  static $cache = null;
  if ($cache !== null) {
    return $cache;
  }
  $cache = ['fecha' => false, 'fecha_partido' => false];
  $rs = @mysqli_query($conexion, "SHOW COLUMNS FROM `partidos_mundial2026`");
  if ($rs) {
    while ($row = mysqli_fetch_assoc($rs)) {
      if ($row['Field'] === 'fecha') {
        $cache['fecha'] = true;
      }
      if ($row['Field'] === 'fecha_partido') {
        $cache['fecha_partido'] = true;
      }
    }
    mysqli_free_result($rs);
  }
  return $cache;
}

/**
 * @param mysqli $conexion
 */
function mundial2026_partidos_tiene_columna_fecha($conexion) {
  $c = mundial2026_partidos_fecha_columns($conexion);
  return $c['fecha_partido'];
}

/**
 * Valor para `fecha` en partidos KO cuando no hay día concreto.
 * MySQL en modo estricto rechaza '0000-00-00'; esta fecha no solapa el Mundial 2026 ni CURDATE() habitual.
 */
function mundial2026_fecha_legacy_ko_placeholder() {
  return '2099-12-31';
}

/** Sorteo final (dic. 2025); nombres alineados con el sitio / banamerica cuando aplica. */
function mundial2026_equipos_por_grupo() {
  return [
    'A' => ['México', 'Sudáfrica', 'Corea del Sur', 'Rep. Checa'],
    'B' => ['Canadá', 'Bosnia', 'Catar', 'Suiza'],
    'C' => ['Brasil', 'Marruecos', 'Haití', 'Escocia'],
    'D' => ['USA', 'Paraguay', 'Australia', 'Turquía'],
    'E' => ['Alemania', 'Curaçao', 'Costa de Marfil', 'Ecuador'],
    'F' => ['Países Bajos', 'Japón', 'Suecia', 'Túnez'],
    'G' => ['Bélgica', 'Egipto', 'Irán', 'Nueva Zelanda'],
    'H' => ['España', 'Cabo Verde', 'Arabia Saudita', 'Uruguay'],
    'I' => ['Francia', 'Senegal', 'Irak', 'Noruega'],
    'J' => ['Argentina', 'Argelia', 'Austria', 'Jordania'],
    'K' => ['Portugal', 'RD Congo', 'Uzbekistán', 'Colombia'],
    'L' => ['Inglaterra', 'Croacia', 'Ghana', 'Panamá'],
  ];
}

/**
 * Seis partidos del grupo en el mismo orden que empezar.php (CodPar base +0…+5).
 *
 * @return array<int, array{0:string,1:string}>
 */
function mundial2026_partidos_grupo($letra) {
  $eq = mundial2026_equipos_por_grupo();
  if (!isset($eq[$letra])) {
    return [];
  }
  $t = $eq[$letra];
  return [
    [$t[0], $t[1]],
    [$t[2], $t[3]],
    [$t[0], $t[2]],
    [$t[3], $t[1]],
    [$t[3], $t[0]],
    [$t[1], $t[2]],
  ];
}

/**
 * Fecha (YYYY-MM-DD) por CodPar 1–72; alineada con jornadas por grupo en Wikipedia.
 *
 * @return array<int,string> CodPar => fecha
 */
function mundial2026_fecha_por_codpar() {
  $porGrupo = [
    'A' => ['2026-06-11', '2026-06-11', '2026-06-18', '2026-06-18', '2026-06-24', '2026-06-24'],
    'B' => ['2026-06-12', '2026-06-13', '2026-06-18', '2026-06-18', '2026-06-24', '2026-06-24'],
    'C' => ['2026-06-13', '2026-06-13', '2026-06-19', '2026-06-19', '2026-06-24', '2026-06-24'],
    'D' => ['2026-06-12', '2026-06-13', '2026-06-19', '2026-06-19', '2026-06-25', '2026-06-25'],
    'E' => ['2026-06-14', '2026-06-14', '2026-06-20', '2026-06-20', '2026-06-25', '2026-06-25'],
    'F' => ['2026-06-14', '2026-06-14', '2026-06-20', '2026-06-20', '2026-06-25', '2026-06-25'],
    'G' => ['2026-06-15', '2026-06-15', '2026-06-21', '2026-06-21', '2026-06-26', '2026-06-26'],
    'H' => ['2026-06-15', '2026-06-15', '2026-06-21', '2026-06-21', '2026-06-26', '2026-06-26'],
    'I' => ['2026-06-16', '2026-06-16', '2026-06-22', '2026-06-22', '2026-06-26', '2026-06-26'],
    'J' => ['2026-06-16', '2026-06-16', '2026-06-22', '2026-06-22', '2026-06-27', '2026-06-27'],
    'K' => ['2026-06-17', '2026-06-17', '2026-06-23', '2026-06-23', '2026-06-27', '2026-06-27'],
    'L' => ['2026-06-17', '2026-06-17', '2026-06-23', '2026-06-23', '2026-06-27', '2026-06-27'],
  ];
  $out = [];
  $grupos = array_keys($porGrupo);
  foreach ($grupos as $gi => $g) {
    $base = $gi * 6 + 1;
    foreach ($porGrupo[$g] as $i => $fecha) {
      $out[$base + $i] = $fecha;
    }
  }
  return $out;
}
