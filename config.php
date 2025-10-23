<?php
/**
 * Archivo de configuración del sistema EnSENAme
 * Configuración para diferentes entornos (desarrollo, producción)
 */

// Configuración de sesión (debe ir antes de session_start)
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    // ini_set('session.cookie_secure', 1); // Activar solo en HTTPS
}

// Detectar el entorno
$is_local = (isset($_SERVER['HTTP_HOST']) && 
             ($_SERVER['HTTP_HOST'] === 'localhost' || 
              $_SERVER['HTTP_HOST'] === '127.0.0.1' || 
              strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0)) || 
             php_sapi_name() === 'cli';

// Configuración de base de datos
if ($is_local) {
    // Configuración para desarrollo local
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'kaboom');
    define('DEBUG_MODE', true);
} else {
    // Configuración para producción (ajustar según el servidor)
    define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
    define('DB_USER', $_ENV['DB_USER'] ?? 'username');
    define('DB_PASS', $_ENV['DB_PASS'] ?? 'password');
    define('DB_NAME', $_ENV['DB_NAME'] ?? 'database_name');
    define('DEBUG_MODE', false);
}

// Configuración de URLs base
if (php_sapi_name() !== 'cli' && isset($_SERVER['HTTP_HOST'])) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $script_name = $_SERVER['SCRIPT_NAME'];
    $base_path = dirname($script_name);

    // Eliminar la parte específica del proyecto de la ruta
    $base_path = str_replace('/enseñame/enSENAme/EnSENAme', '', $base_path);
    $base_path = str_replace('/EnSENAme', '', $base_path);

    // Asegurar que la ruta base termine con "/"
    if ($base_path !== '/' && substr($base_path, -1) !== '/') {
        $base_path .= '/';
    }

    define('BASE_URL', $protocol . '://' . $host . $base_path);
} else {
    // Para CLI o cuando no hay HTTP_HOST disponible
    define('BASE_URL', '');
}
define('SITE_ROOT', __DIR__);

// Configuración de errores
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Configuración de zona horaria
date_default_timezone_set('America/Bogota');

?>