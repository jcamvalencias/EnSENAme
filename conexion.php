<?php
// Incluir configuración del sistema
require_once __DIR__ . '/config.php';

// Crear conexión usando las constantes definidas en config.php
$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexión
if (!$conexion) {
    if (DEBUG_MODE) {
        die("Error en la conexión a la base de datos: " . mysqli_connect_error());
    } else {
        die("Error en la conexión a la base de datos. Contacte al administrador.");
    }
}

// Establecer charset UTF-8 para caracteres especiales
if (!mysqli_set_charset($conexion, "utf8")) {
    if (DEBUG_MODE) {
        die("Error estableciendo charset UTF-8: " . mysqli_error($conexion));
    } else {
        die("Error de configuración de base de datos.");
    }
}
?>