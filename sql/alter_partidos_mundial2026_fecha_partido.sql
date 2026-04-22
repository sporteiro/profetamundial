-- Opcional: fechas de fase de grupos (CodPar 1–72). Los partidos KO 73–106 quedan con NULL.
-- Tras aplicar, las altas nuevas desde empezar.php guardan fecha_partido automáticamente.

ALTER TABLE `partidos_mundial2026`
  ADD COLUMN `fecha_partido` DATE NULL DEFAULT NULL AFTER `resultado`;
