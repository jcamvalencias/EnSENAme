<?php
/**
 * Test para verificar el funcionamiento del chatbot
 */

session_start();
include_once "conexion.php";

echo "<h1>🤖 Test del Chatbot EnSEÑAme</h1>";

// Simular una sesión de usuario para prueba
if (!isset($_SESSION['txtdoc'])) {
    $_SESSION['txtdoc'] = 123456789; // Usuario de prueba
    echo "<p>✅ Sesión simulada para usuario 123456789</p>";
}

// Verificar conexión a base de datos
if ($conexion) {
    echo "<p>✅ Conexión a base de datos exitosa</p>";
} else {
    echo "<p>❌ Error de conexión a base de datos: " . mysqli_connect_error() . "</p>";
    exit;
}

// Verificar tabla tb_chatbot_logs
$result = mysqli_query($conexion, "SHOW TABLES LIKE 'tb_chatbot_logs'");
if (mysqli_num_rows($result) > 0) {
    echo "<p>✅ Tabla tb_chatbot_logs existe</p>";
    
    // Verificar estructura de la tabla
    $structure = mysqli_query($conexion, "DESCRIBE tb_chatbot_logs");
    echo "<h3>📊 Estructura de tb_chatbot_logs:</h3>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Por defecto</th></tr>";
    while ($row = mysqli_fetch_assoc($structure)) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} else {
    echo "<p>❌ Tabla tb_chatbot_logs NO existe</p>";
}

// Test de inserción
echo "<h3>🧪 Test de Inserción de Log:</h3>";

$test_user = 123456789;
$test_message = "Test de funcionamiento";
$test_response = "Respuesta de prueba desde el sistema";

$mensaje_usuario = mysqli_real_escape_string($conexion, $test_message);
$respuesta_bot = mysqli_real_escape_string($conexion, $test_response);
$tipo_respuesta = 'info';
$origen = 'user';

$sql = "INSERT INTO tb_chatbot_logs (usuario_id, mensaje_usuario, respuesta_bot, tipo_respuesta, origen) 
        VALUES ($test_user, '$mensaje_usuario', '$respuesta_bot', '$tipo_respuesta', '$origen')";

if (mysqli_query($conexion, $sql)) {
    echo "<p>✅ Log insertado correctamente</p>";
    echo "<p><strong>Datos insertados:</strong></p>";
    echo "<ul>";
    echo "<li>Usuario: $test_user</li>";
    echo "<li>Mensaje: $test_message</li>";
    echo "<li>Respuesta: $test_response</li>";
    echo "<li>Tipo: $tipo_respuesta</li>";
    echo "<li>Origen: $origen</li>";
    echo "</ul>";
} else {
    echo "<p>❌ Error al insertar log: " . mysqli_error($conexion) . "</p>";
}

// Verificar últimos logs
echo "<h3>📋 Últimos 5 Logs:</h3>";
$logs = mysqli_query($conexion, "SELECT * FROM tb_chatbot_logs ORDER BY timestamp DESC LIMIT 5");

if (mysqli_num_rows($logs) > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Usuario</th><th>Mensaje</th><th>Respuesta</th><th>Tipo</th><th>Origen</th><th>Fecha</th></tr>";
    while ($log = mysqli_fetch_assoc($logs)) {
        echo "<tr>";
        echo "<td>" . $log['id'] . "</td>";
        echo "<td>" . $log['usuario_id'] . "</td>";
        echo "<td>" . substr($log['mensaje_usuario'], 0, 50) . "...</td>";
        echo "<td>" . substr($log['respuesta_bot'], 0, 50) . "...</td>";
        echo "<td>" . $log['tipo_respuesta'] . "</td>";
        echo "<td>" . $log['origen'] . "</td>";
        echo "<td>" . $log['timestamp'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>⚠️ No hay logs en la base de datos</p>";
}

// Test de API
echo "<h3>🌐 Test de API del Chatbot:</h3>";
echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
echo "<h4>Mensaje de prueba:</h4>";
echo "<p><strong>Pregunta:</strong> ¿Qué es LSC?</p>";

// Simular llamada a la API
$test_data = json_encode(['mensaje' => '¿Qué es LSC?', 'usuario_id' => 123456789]);

echo "<p><strong>Datos enviados:</strong> $test_data</p>";
echo "<p><strong>URL de API:</strong> <a href='chatbot_api_clean.php' target='_blank'>chatbot_api_clean.php</a></p>";
echo "</div>";

echo "<hr>";
echo "<h3>🎯 Instrucciones para probar manualmente:</h3>";
echo "<ol>";
echo "<li>Abre la consola del navegador (F12)</li>";
echo "<li>Ve a la página del chatbot</li>";
echo "<li>Envía un mensaje</li>";
echo "<li>Revisa si hay errores en la consola</li>";
echo "<li>Verifica que los logs se guarden aquí</li>";
echo "</ol>";

echo "<p><strong>🔧 Si hay errores:</strong></p>";
echo "<ul>";
echo "<li>Verifica que la base de datos 'kaboom' exista</li>";
echo "<li>Importa kaboom.sql si es necesario</li>";
echo "<li>Revisa las credenciales en conexion.php</li>";
echo "<li>Verifica permisos de PHP para escritura en base de datos</li>";
echo "</ul>";

mysqli_close($conexion);
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1, h3 { color: #2c3e50; }
table { border-collapse: collapse; margin: 10px 0; }
th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
th { background-color: #f2f2f2; }
p { margin: 10px 0; }
ul, ol { margin: 10px 0; padding-left: 20px; }
</style>