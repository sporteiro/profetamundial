-- Script SQL para corregir las fechas de los partidos 73-88 (16avos de final)
-- Basado en el calendario oficial del Mundial 2026 de ESPN
-- Verificado 5 veces antes de ejecutar

-- Partidos que NO necesitan corrección (ya están correctos):
-- Partido 73: 2026-06-28 ✓ CORRECTO
-- Partido 74: 2026-06-29 ✓ CORRECTO
-- Partido 75: 2026-06-30 ✓ CORRECTO

-- Partidos que SÍ necesitan corrección:

-- Lunes 29 de junio
UPDATE partidos_mundial2026 SET fecha = '2026-06-29' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 76;

-- Martes 30 de junio
UPDATE partidos_mundial2026 SET fecha = '2026-06-30' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 77;
UPDATE partidos_mundial2026 SET fecha = '2026-06-30' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 78;
UPDATE partidos_mundial2026 SET fecha = '2026-06-30' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 79;

-- Miércoles 1 de julio
UPDATE partidos_mundial2026 SET fecha = '2026-07-01' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 80;
UPDATE partidos_mundial2026 SET fecha = '2026-07-01' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 81;
UPDATE partidos_mundial2026 SET fecha = '2026-07-01' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 82;

-- Jueves 2 de julio
UPDATE partidos_mundial2026 SET fecha = '2026-07-02' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 83;
UPDATE partidos_mundial2026 SET fecha = '2026-07-02' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 84;
UPDATE partidos_mundial2026 SET fecha = '2026-07-02' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 85;

-- Viernes 3 de julio
UPDATE partidos_mundial2026 SET fecha = '2026-07-03' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 86;
UPDATE partidos_mundial2026 SET fecha = '2026-07-03' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 87;
UPDATE partidos_mundial2026 SET fecha = '2026-07-03' WHERE CodUsu = 'ProfetaMundial' AND CodPar = 88;

-- Verificación después de ejecutar:
-- SELECT CodPar, local, visitante, fecha FROM partidos_mundial2026 WHERE CodUsu = 'ProfetaMundial' AND CodPar BETWEEN 73 AND 88 ORDER BY CodPar;
