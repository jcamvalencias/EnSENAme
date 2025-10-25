<?php
// Incluir configuración del sistema
require_once __DIR__ . '/config.php';

// Crear conexión usando las constantes definidas en config.php
$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexión
if (!$conexion) {
    if (DEBUG_MODE) {
        die("Error en la conexión a la base de datos: " . mysqli_connect_error());
    <?php
    require_once __DIR__ . '/config.php';

    // Conexión robusta con puerto explícito y mensajes útiles
    $host = defined('DB_HOST') ? DB_HOST : '127.0.0.1';
    $user = defined('DB_USER') ? DB_USER : 'root';
    $pass = defined('DB_PASS') ? DB_PASS : '';
    $db   = defined('DB_NAME') ? DB_NAME : '';
    $port = defined('DB_PORT') ? (int)DB_PORT : 3306;

    $conexion = @mysqli_connect($host, $user, $pass, $db, $port);

    if (!$conexion) {
        if (DEBUG_MODE) {
            $errno = mysqli_connect_errno();
            $err   = mysqli_connect_error();
            $hint = '';
            if ($errno === 2002) {
                $hint = " | Hint: Verifique que el servicio MySQL/MariaDB esté INICIADO en XAMPP y que el puerto ($port) sea correcto. Si XAMPP usa 3307, cambie DB_PORT en config.php.";
            } elseif ($errno === 1045) {
                $hint = " | Hint: Credenciales incorrectas (usuario/contraseña).";
            } elseif ($errno === 1049) {
                $hint = " | Hint: La base de datos '$db' no existe.";
            }
            die("Error de conexión ($errno): $err$hint");
        } else {
            die("Error en la conexión a la base de datos. Contacte al administrador.");
        }
    }

    // Establecer charset UTF-8 para caracteres especiales
    if (!mysqli_set_charset($conexion, 'utf8')) {
        if (DEBUG_MODE) {
            die("Error estableciendo charset UTF-8: " . mysqli_error($conexion));
        } else {
            die("Error de configuración de base de datos.");
        }
    }
    ?>