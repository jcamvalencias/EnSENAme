<?php
include "../../conexion.php";

echo "<h2>Diagnóstico de Base de Datos - kaboom</h2>";

// Verificar conexión
if ($conexion) {
    echo "<p>✅ Conexión exitosa a la base de datos</p>";
    
    // Mostrar todas las tablas
    echo "<h3>Tablas existentes:</h3>";
    $result = mysqli_query($conexion, "SHOW TABLES");
    if ($result) {
        echo "<ul>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<li>" . $row[0] . "</li>";
        }
        echo "</ul>";
    }
    
    // Verificar estructura de tbl_rol
    echo "<h3>Estructura de tbl_rol:</h3>";
    $result = mysqli_query($conexion, "DESCRIBE tbl_rol");
    if ($result) {
        echo "<table border='1'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Default</th><th>Extra</th></tr>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "<td>" . $row['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Verificar si existe tb_chatbot_logs
    echo "<h3>Verificando tabla tb_chatbot_logs:</h3>";
    $result = mysqli_query($conexion, "SHOW TABLES LIKE 'tb_chatbot_logs'");
    if (mysqli_num_rows($result) > 0) {
        echo "<p>✅ Tabla tb_chatbot_logs existe</p>";
        
        // Mostrar estructura
        $result = mysqli_query($conexion, "DESCRIBE tb_chatbot_logs");
        if ($result) {
            echo "<table border='1'>";
            echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Default</th><th>Extra</th></tr>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['Field'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "<td>" . $row['Null'] . "</td>";
                echo "<td>" . $row['Key'] . "</td>";
                echo "<td>" . $row['Default'] . "</td>";
                echo "<td>" . $row['Extra'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        echo "<p>❌ Tabla tb_chatbot_logs NO existe</p>";
        echo "<p>📝 Necesitas crear esta tabla para que funcionen las estadísticas del chatbot.</p>";
        
        echo "<h4>SQL para crear la tabla:</h4>";
        echo "<pre>";
        echo "CREATE TABLE `tb_chatbot_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `mensaje_usuario` text NOT NULL,
  `respuesta_bot` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_respuesta` varchar(50) DEFAULT 'info',
  `origen` varchar(20) DEFAULT 'user',
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";
        echo "</pre>";
    }
    
    // Verificar si existe tb_mensajes
    echo "<h3>Verificando tabla tb_mensajes:</h3>";
    $result = mysqli_query($conexion, "SHOW TABLES LIKE 'tb_mensajes'");
    if (mysqli_num_rows($result) > 0) {
        echo "<p>✅ Tabla tb_mensajes existe</p>";
    } else {
        echo "<p>❌ Tabla tb_mensajes NO existe</p>";
        echo "<p>📝 Necesitas crear esta tabla para el sistema de chat.</p>";
        
        echo "<h4>SQL para crear la tabla:</h4>";
        echo "<pre>";
        echo "CREATE TABLE `tb_mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo` enum('usuario','admin') DEFAULT 'usuario',
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuarios` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";
        echo "</pre>";
    }
    
} else {
    echo "<p>❌ Error de conexión: " . mysqli_connect_error() . "</p>";
}
?>