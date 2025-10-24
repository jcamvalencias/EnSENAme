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
try {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'kaboom';
    
    echo "<p>Intentando conectar a: $host | Usuario: $user | Base: $db</p>";
    
    $connection = @mysqli_connect($host, $user, $pass, $db);
    
    if ($connection) {
        echo "<p>✅ <strong>Conexión exitosa</strong></p>";
        
        // Test de tabla usuarios
        $result = @mysqli_query($connection, "SELECT COUNT(*) as count FROM tb_usuarios");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            echo "<p>✅ <strong>Tabla tb_usuarios:</strong> " . $row['count'] . " registros</p>";
        } else {
            echo "<p>⚠️ <strong>Tabla tb_usuarios:</strong> " . mysqli_error($connection) . "</p>";
        }
        
        mysqli_close($connection);
    } else {
        echo "<p>❌ <strong>Error de conexión:</strong> " . mysqli_connect_error() . "</p>";
        echo "<p><strong>Posibles soluciones:</strong></p>";
        echo "<ul>";
        echo "<li>Verificar que MySQL esté ejecutándose en XAMPP</li>";
        echo "<li>Verificar que la base de datos 'kaboom' exista</li>";
        echo "<li>Verificar permisos de usuario</li>";
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
    'chatbot_api_simple.php' => 'API del chatbot (simple)',
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