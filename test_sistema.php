<?php
echo "<h1>🔧 Test del Sistema EnSEÑAme</h1>";

echo "<div style='font-family: Arial; line-height: 1.6; max-width: 800px; margin: 20px;'>";

echo "<h2>1. ✅ PHP está funcionando</h2>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Hora del servidor:</strong> " . date('Y-m-d H:i:s') . "</p>";

echo "<h2>2. Test de Extensiones</h2>";
$extensiones = ['mysqli', 'json', 'session'];
foreach ($extensiones as $ext) {
    if (extension_loaded($ext)) {
        echo "<p>✅ <strong>$ext:</strong> Disponible</p>";
    } else {
        echo "<p>❌ <strong>$ext:</strong> NO disponible</p>";
    }
}

echo "<h2>3. Test de Conexión a Base de Datos</h2>";
// Intento multi-puerto: DB_PORT (si está definido), 3306 y 3307
require_once __DIR__ . '/config.php';
try {
    $host = defined('DB_HOST') ? DB_HOST : '127.0.0.1';
    $user = defined('DB_USER') ? DB_USER : 'root';
    $pass = defined('DB_PASS') ? DB_PASS : '';
    $db   = defined('DB_NAME') ? DB_NAME : 'kaboom';
    $ports = [];
    if (defined('DB_PORT')) { $ports[] = (int)DB_PORT; }
    $ports[] = 3306;
    $ports[] = 3307;
    $ports = array_values(array_unique(array_filter($ports, function($p){ return (int)$p > 0; })));

    echo "<p>Intentando conectar a: <strong>$host</strong> | Usuario: <strong>$user</strong> | Base: <strong>$db</strong></p>";
    echo "<p>Puertos a probar: <strong>" . implode(', ', $ports) . "</strong></p>";

    $connection = null;
    $usedPort = null;
    $attempts = [];
    foreach ($ports as $p) {
        $tmp = @mysqli_connect($host, $user, $pass, $db, (int)$p);
        if ($tmp) {
            $connection = $tmp;
            $usedPort = (int)$p;
            $attempts[] = [ 'port' => $p, 'ok' => true, 'errno' => 0, 'error' => '' ];
            break;
        } else {
            $attempts[] = [ 'port' => $p, 'ok' => false, 'errno' => mysqli_connect_errno(), 'error' => mysqli_connect_error() ];
        }
    }

    if ($connection) {
        echo "<p>✅ <strong>Conexión exitosa</strong> en el puerto <strong>$usedPort</strong></p>";
        // Test de tabla usuarios
        $result = @mysqli_query($connection, "SELECT COUNT(*) as count FROM tb_usuarios");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            echo "<p>✅ <strong>Tabla tb_usuarios:</strong> " . (int)$row['count'] . " registros</p>";
        } else {
            echo "<p>⚠️ <strong>Consulta a tb_usuarios falló:</strong> " . htmlspecialchars(mysqli_error($connection)) . "</p>";
        }
        mysqli_close($connection);
    } else {
        echo "<p>❌ <strong>Error de conexión:</strong> No se pudo conectar en ninguno de los puertos probados.</p>";
        echo "<ul>";
        foreach ($attempts as $a) {
            echo "<li>Puerto <strong>" . (int)$a['port'] . "</strong>: " . ($a['ok'] ? 'OK' : ('Error (' . (int)$a['errno'] . '): ' . htmlspecialchars($a['error']))) . "</li>";
        }
        echo "</ul>";
        echo "<p><strong>Posibles soluciones:</strong></p>";
        echo "<ul>";
        echo "<li>Inicie MySQL en XAMPP (Control Panel)</li>";
        echo "<li>Verifique el puerto de MySQL (3306/3307) y ajuste DB_PORT en config.php</li>";
        echo "<li>Confirme que la base de datos '<strong>$db</strong>' exista (phpMyAdmin) y que el usuario '<strong>$user</strong>' tenga permisos</li>";
        echo "</ul>";
    }
} catch (Exception $e) {
    echo "<p>❌ <strong>Excepción:</strong> " . $e->getMessage() . "</p>";
}

echo "<h2>4. Test de Archivos del Sistema</h2>";
$archivos_importantes = [
    'config.php' => 'Configuración principal',
    'conexion.php' => 'Conexión a base de datos',
    'includes/session.php' => 'Manejo de sesiones',
    // Endpoint actual del chatbot
    'chatbot_api_clean.php' => 'API del chatbot (limpia)',
    'user/chatbot.php' => 'Interface usuario chatbot',
    'admin/dashboard/chat.php' => 'Interface admin chat'
];

foreach ($archivos_importantes as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "<p>✅ <strong>$descripcion:</strong> $archivo existe</p>";
    } else {
        echo "<p>❌ <strong>$descripcion:</strong> $archivo NO encontrado</p>";
    }
}

echo "<h2>5. Instrucciones para Solucionar</h2>";
echo "<div style='background: #f0f8ff; padding: 15px; border-left: 4px solid #007bff;'>";
echo "<h3>📋 Pasos para arreglar:</h3>";
echo "<ol>";
echo "<li><strong>Abrir XAMPP Control Panel</strong> (como administrador)</li>";
echo "<li><strong>Iniciar Apache</strong> - Clic en 'Start' junto a Apache</li>";
echo "<li><strong>Iniciar MySQL</strong> - Clic en 'Start' junto a MySQL</li>";
echo "<li><strong>Verificar puertos:</strong> Apache (80), MySQL (3306)</li>";
echo "<li><strong>Probar de nuevo</strong> esta página</li>";
echo "</ol>";
echo "</div>";

echo "<h2>6. Enlaces de Prueba</h2>";
echo "<div style='background: #f8f9fa; padding: 15px; border: 1px solid #dee2e6;'>";
echo "<p><a href='index.php' style='color: #007bff;'>🏠 Página Principal</a></p>";
echo "<p><a href='user/chatbot.php' style='color: #28a745;'>🤖 Chatbot Usuario</a></p>";
echo "<p><a href='admin/dashboard/chat.php' style='color: #dc3545;'>👤 Chat Admin</a></p>";
echo "<p><a href='test_conexion.php' style='color: #ffc107;'>🔧 Test Conexión Simple</a></p>";
echo "</div>";

echo "</div>";
?>