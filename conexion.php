<?php
// Incluir configuración del sistema
require_once __DIR__ . '/config.php';

// Conexión robusta con puerto explícito y mensajes útiles
$host = defined('DB_HOST') ? DB_HOST : '127.0.0.1';
$user = defined('DB_USER') ? DB_USER : 'root';
$pass = defined('DB_PASS') ? DB_PASS : '';
$db   = defined('DB_NAME') ? DB_NAME : '';

// Construir lista de puertos a probar: DB_PORT (si existe), 3306 y 3307 (sin duplicados)
$ports = [];
if (defined('DB_PORT')) { 
    $ports[] = (int)DB_PORT; 
}
$ports[] = 3306;
$ports[] = 3307;
$ports = array_values(array_unique(array_filter($ports, function($p) { return (int)$p > 0; })));

$conexion = null;
$usedPort = null;
$lastErrno = null;
$lastError = null;

foreach ($ports as $p) {
    $tmp = @mysqli_connect($host, $user, $pass, $db, (int)$p);
    if ($tmp) {
        $conexion = $tmp;
        $usedPort = (int)$p;
        if (defined('DEBUG_MODE') && DEBUG_MODE) {
            if (defined('DB_PORT') && (int)DB_PORT !== (int)$p) {
                error_log("[DB] Conectado usando puerto alterno $p (configurado: " . (int)DB_PORT . ")");
            } else {
                error_log("[DB] Conectado en puerto $p");
            }
        }
        break;
    } else {
        $lastErrno = mysqli_connect_errno();
        $lastError = mysqli_connect_error();
        // Si fue error distinto a 2002 (conexión rechazada/no disponible), igual intentamos siguientes puertos
    }
}

if (!$conexion) {
    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        $errno = $lastErrno;
        $err   = $lastError;
        $hint = '';
        if ($errno === 2002) {
            $hint = " | Hint: Verifique que el servicio MySQL/MariaDB esté INICIADO en XAMPP y el puerto (probados: " . implode(',', $ports) . ") sea correcto. Si usa otro puerto, ajuste DB_PORT en config.php.";
        } elseif ($errno === 1045) {
            $hint = " | Hint: Credenciales incorrectas (usuario/contraseña).";
        } elseif ($errno === 1049) {
            $hint = " | Hint: La base de datos '$db' no existe.";
        }
        http_response_code(500);
        die("Error de conexión ($errno): $err$hint");
    } else {
        http_response_code(500);
        die("Error en la conexión a la base de datos. Contacte al administrador.");
    }
}

// Establecer charset UTF-8 para caracteres especiales
if (!mysqli_set_charset($conexion, 'utf8')) {
    if (defined('DEBUG_MODE') && DEBUG_MODE) {
        die("Error estableciendo charset UTF-8: " . mysqli_error($conexion));
    } else {
        die("Error de configuración de base de datos.");
    }
}
?>