<?php
include "../../conexion.php";

echo "<h2>Test de Consultas SQL - Chatbot Stats</h2>";

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

echo "<p>✅ Conexión exitosa</p>";

// Test 1: Total de interacciones
echo "<h3>Test 1: Total de interacciones</h3>";
$query = "SELECT COUNT(*) as total FROM tb_chatbot_logs";
$result = mysqli_query($conexion, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo "<p>✅ Total interacciones: " . $row['total'] . "</p>";
} else {
    echo "<p>❌ Error: " . mysqli_error($conexion) . "</p>";
}

// Test 2: Interacciones de hoy
echo "<h3>Test 2: Interacciones de hoy</h3>";
$query = "SELECT COUNT(*) as total FROM tb_chatbot_logs WHERE DATE(timestamp) = CURDATE()";
$result = mysqli_query($conexion, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo "<p>✅ Interacciones hoy: " . $row['total'] . "</p>";
} else {
    echo "<p>❌ Error: " . mysqli_error($conexion) . "</p>";
}

// Test 3: Consultas administrativas
echo "<h3>Test 3: Consultas administrativas</h3>";
$query = "SELECT COUNT(*) as total FROM tb_chatbot_logs WHERE origen = 'admin'";
$result = mysqli_query($conexion, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo "<p>✅ Consultas admin: " . $row['total'] . "</p>";
} else {
    echo "<p>❌ Error: " . mysqli_error($conexion) . "</p>";
}

// Test 4: Preguntas más frecuentes
echo "<h3>Test 4: Preguntas más frecuentes</h3>";
$query = "SELECT mensaje_usuario, COUNT(*) as frecuencia FROM tb_chatbot_logs GROUP BY mensaje_usuario ORDER BY frecuencia DESC LIMIT 5";
$result = mysqli_query($conexion, $query);
if ($result) {
    echo "<p>✅ Consulta exitosa:</p>";
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . htmlspecialchars($row['mensaje_usuario']) . " (" . $row['frecuencia'] . " veces)</li>";
    }
    echo "</ul>";
} else {
    echo "<p>❌ Error: " . mysqli_error($conexion) . "</p>";
}

// Test 5: Actividad por horas
echo "<h3>Test 5: Actividad por horas</h3>";
$query = "SELECT HOUR(timestamp) as hora, COUNT(*) as total FROM tb_chatbot_logs WHERE timestamp >= DATE_SUB(NOW(), INTERVAL 24 HOUR) GROUP BY HOUR(timestamp) ORDER BY hora";
$result = mysqli_query($conexion, $query);
if ($result) {
    echo "<p>✅ Consulta de actividad exitosa</p>";
    echo "<p>Registros encontrados: " . mysqli_num_rows($result) . "</p>";
} else {
    echo "<p>❌ Error: " . mysqli_error($conexion) . "</p>";
}

// Test 6: Tabla combinada con usuarios
echo "<h3>Test 6: Últimos logs con usuarios</h3>";
$query = "SELECT l.*, u.p_nombre, u.p_apellido FROM tb_chatbot_logs l LEFT JOIN tb_usuarios u ON l.usuario_id = u.ID ORDER BY l.timestamp DESC LIMIT 3";
$result = mysqli_query($conexion, $query);
if ($result) {
    echo "<p>✅ Consulta combinada exitosa:</p>";
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        $nombre = $row['p_nombre'] ? $row['p_nombre'] . ' ' . $row['p_apellido'] : 'Usuario Anónimo';
        echo "<li><strong>" . htmlspecialchars($nombre) . "</strong>: " . htmlspecialchars(substr($row['mensaje_usuario'], 0, 50)) . "...</li>";
    }
    echo "</ul>";
} else {
    echo "<p>❌ Error: " . mysqli_error($conexion) . "</p>";
}

echo "<hr>";
echo "<h3>✅ Todas las pruebas completadas</h3>";
echo "<p><a href='chatbot_stats.php'>Ir a Estadísticas del Chatbot</a></p>";
?>