<?php
require_once __DIR__ . '/../Connections/conexion.php';
require_once __DIR__ . '/../mysql_compat.php';
// No incluimos los archivos de lógica de página porque dependen de $_POST, etc. Los incluiremos en los tests con contextos simulados.