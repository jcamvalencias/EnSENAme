<?php
/**
 * Visor de logs del chatbot en tiempo real
 */
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔍 Debug Chatbot - EnSEÑAme</title>
    <style>
        body { font-family: monospace; background: #1e1e1e; color: #fff; padding: 20px; }
        .log-container { background: #2d2d2d; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { color: #ff6b6b; }
        .info { color: #4ecdc4; }
        .warning { color: #ffe66d; }
        .success { color: #51cf66; }
        h1 { color: #4ecdc4; }
        .refresh-btn { background: #4ecdc4; color: #1e1e1e; padding: 10px; border: none; border-radius: 5px; cursor: pointer; }
        .test-section { background: #2a3f5f; padding: 15px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>🔍 Debug del Chatbot EnSEÑAme</h1>
    
    <button class="refresh-btn" onclick="location.reload()">🔄 Refrescar Logs</button>
    
    <div class="test-section">
        <h3>🧪 Test Rápido de API</h3>
        <button onclick="testChatbot()" class="refresh-btn">Probar Chatbot</button>
        <div id="test-result"></div>
    </div>

    <div class="log-container">
        <h3>📊 Estado de la Sesión</h3>
        <?php
        session_start();
        echo "<p><strong>SESSION STATUS:</strong> " . (session_status() === PHP_SESSION_ACTIVE ? "✅ ACTIVA" : "❌ INACTIVA") . "</p>";
        echo "<p><strong>SESSION ID:</strong> " . session_id() . "</p>";
        echo "<p><strong>txtdoc:</strong> " . ($_SESSION['txtdoc'] ?? '❌ NO SET') . "</p>";
        echo "<p><strong>display_name:</strong> " . ($_SESSION['display_name'] ?? '❌ NO SET') . "</p>";
        
        // Mostrar todas las variables de sesión
        echo "<h4>🔧 Variables de Sesión:</h4>";
        echo "<pre>";
        foreach ($_SESSION as $key => $value) {
            echo "$key: " . (is_string($value) ? $value : json_encode($value)) . "\n";
        }
        echo "</pre>";
        ?>
    </div>

    <div class="log-container">
        <h3>🗄️ Estado de Base de Datos</h3>
        <?php
        include_once "conexion.php";
        
        if ($conexion) {
            echo "<p class='success'>✅ Conexión a BD exitosa</p>";
            
            // Verificar tabla tb_chatbot_logs
            $result = mysqli_query($conexion, "SHOW TABLES LIKE 'tb_chatbot_logs'");
            if (mysqli_num_rows($result) > 0) {
                echo "<p class='success'>✅ Tabla tb_chatbot_logs existe</p>";
                
                // Contar registros
                $count = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_chatbot_logs"))['total'];
                echo "<p class='info'>📊 Total de logs: $count</p>";
                
                // Último log
                $last_log = mysqli_query($conexion, "SELECT * FROM tb_chatbot_logs ORDER BY timestamp DESC LIMIT 1");
                if ($log = mysqli_fetch_assoc($last_log)) {
                    echo "<p class='info'>🕐 Último log: " . $log['timestamp'] . "</p>";
                    echo "<p class='info'>👤 Usuario: " . $log['usuario_id'] . "</p>";
                    echo "<p class='info'>💬 Mensaje: " . substr($log['mensaje_usuario'], 0, 50) . "...</p>";
                }
            } else {
                echo "<p class='error'>❌ Tabla tb_chatbot_logs NO existe</p>";
            }
        } else {
            echo "<p class='error'>❌ Error de conexión: " . mysqli_connect_error() . "</p>";
        }
        ?>
    </div>

    <div class="log-container">
        <h3>📋 Logs del Sistema PHP</h3>
        <?php
        // Configuración de logs
        echo "<h4>🔧 Configuración de Logs:</h4>";
        echo "<p><strong>Log errors:</strong> " . (ini_get('log_errors') ? '✅ Habilitado' : '❌ Deshabilitado') . "</p>";
        echo "<p><strong>Error log file:</strong> " . (ini_get('error_log') ?: '❌ No configurado') . "</p>";
        echo "<p><strong>Display errors:</strong> " . (ini_get('display_errors') ? '✅ Habilitado' : '❌ Deshabilitado') . "</p>";
        
        // Intentar diferentes ubicaciones de logs
        $possible_logs = [
            ini_get('error_log'),
            'C:\xampp\php\logs\php_error_log',
            'C:\xampp\apache\logs\error.log',
            __DIR__ . '/error.log',
            __DIR__ . '/debug.log'
        ];
        
        echo "<h4>📂 Buscando archivos de log:</h4>";
        $found_log = false;
        
        foreach ($possible_logs as $log_path) {
            if ($log_path && file_exists($log_path)) {
                echo "<p class='success'>✅ Encontrado: $log_path</p>";
                $found_log = true;
                
                // Mostrar últimas líneas del log
                $lines = file($log_path);
                $chatbot_logs = array_filter($lines, function($line) {
                    return stripos($line, 'chatbot') !== false || stripos($line, 'Chatbot') !== false;
                });
                
                if (!empty($chatbot_logs)) {
                    echo "<h5>🔍 Logs relacionados con Chatbot (últimos 10):</h5>";
                    $recent_logs = array_slice($chatbot_logs, -10);
                    foreach ($recent_logs as $log) {
                        $class = 'info';
                        if (stripos($log, 'error') !== false || stripos($log, 'Error') !== false) $class = 'error';
                        if (stripos($log, 'warning') !== false || stripos($log, 'Warning') !== false) $class = 'warning';
                        echo "<p class='$class'>" . htmlspecialchars(trim($log)) . "</p>";
                    }
                } else {
                    echo "<p class='warning'>⚠️ No hay logs específicos del chatbot en este archivo</p>";
                }
                break;
            } else if ($log_path) {
                echo "<p class='error'>❌ No encontrado: $log_path</p>";
            }
        }
        
        if (!$found_log) {
            echo "<p class='warning'>⚠️ No se encontraron archivos de log</p>";
            echo "<h4>💡 Solución:</h4>";
            echo "<p>1. Crear un archivo de log personalizado</p>";
            echo "<p>2. Habilitar logging en PHP</p>";
        }
        
        // Crear sistema de log personalizado
        $custom_log = __DIR__ . '/chatbot_debug.log';
        echo "<h4>📝 Log Personalizado:</h4>";
        echo "<p><strong>Ubicación:</strong> $custom_log</p>";
        
        // Verificar/crear log personalizado
        if (!file_exists($custom_log)) {
            file_put_contents($custom_log, "[" . date('Y-m-d H:i:s') . "] Debug log iniciado\n", FILE_APPEND | LOCK_EX);
            echo "<p class='success'>✅ Log personalizado creado</p>";
        } else {
            echo "<p class='success'>✅ Log personalizado existe</p>";
            
            // Mostrar últimas líneas del log personalizado
            if (filesize($custom_log) > 0) {
                $lines = file($custom_log);
                $recent_lines = array_slice($lines, -15);
                echo "<h5>🔍 Últimas 15 líneas del log personalizado:</h5>";
                echo "<div style='background: #000; padding: 10px; border-radius: 5px; font-size: 12px;'>";
                foreach ($recent_lines as $line) {
                    echo htmlspecialchars($line) . "<br>";
                }
                echo "</div>";
            }
        }
        
        // Botón para limpiar log
        if (isset($_GET['clear_log'])) {
            file_put_contents($custom_log, "[" . date('Y-m-d H:i:s') . "] Log limpiado\n");
            echo "<p class='success'>✅ Log limpiado</p>";
        }
        echo "<a href='?clear_log=1' style='color: #ffe66d; text-decoration: none;'>🗑️ Limpiar Log</a>";
        ?>
    </div>

    <script>
    function testChatbot() {
        const resultDiv = document.getElementById('test-result');
        resultDiv.innerHTML = '<p style="color: #ffe66d;">🔄 Probando...</p>';
        
    fetch('chatbot_api_clean.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                mensaje: '¿Qué es LSC?',
                usuario_id: <?php echo $_SESSION['txtdoc'] ?? '123456789'; ?>
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', [...response.headers.entries()]);
            return response.text();
        })
        .then(text => {
            console.log('Raw response:', text);
            try {
                const data = JSON.parse(text);
                console.log('Parsed data:', data);
                if (data.success) {
                    resultDiv.innerHTML = `
                        <p style="color: #51cf66;">✅ Test exitoso</p>
                        <p><strong>Respuesta:</strong> ${data.respuesta.substring(0, 100)}...</p>
                        <p><strong>Timestamp:</strong> ${data.timestamp}</p>
                    `;
                } else {
                    resultDiv.innerHTML = `
                        <p style="color: #ff6b6b;">❌ Error: ${data.error}</p>
                    `;
                }
            } catch (e) {
                console.error('JSON Parse Error:', e);
                resultDiv.innerHTML = `
                    <p style="color: #ff6b6b;">❌ Error de JSON: ${e.message}</p>
                    <p><strong>Respuesta cruda:</strong></p>
                    <pre style="background: #000; color: #fff; padding: 10px; border-radius: 5px; max-height: 300px; overflow-y: auto; font-size: 12px;">${text.substring(0, 1000)}${text.length > 1000 ? '...' : ''}</pre>
                `;
            }
        })
        })
        .catch(error => {
            console.error('Error:', error);
            resultDiv.innerHTML = `
                <p style="color: #ff6b6b;">❌ Error de conexión: ${error.message}</p>
            `;
        });
    }
    
    // Auto-refresh cada 30 segundos
    // setTimeout(() => location.reload(), 30000);
    </script>
</body>
</html>