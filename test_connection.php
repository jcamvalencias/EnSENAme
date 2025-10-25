<?php
// Archivo de prueba para verificar la conexión a la base de datos
echo "Iniciando prueba de conexión...\n<br>";

try {
    include "conexion.php";
    
    if ($conexion) {
        echo "✅ Conexión exitosa a la base de datos\n<br>";
        echo "Información de conexión:\n<br>";
        echo "- Host: " . mysqli_get_host_info($conexion) . "\n<br>";
        echo "- Versión del servidor: " . mysqli_get_server_info($conexion) . "\n<br>";
        echo "- Charset: " . mysqli_character_set_name($conexion) . "\n<br>";
        
        // Verificar si la tabla de usuarios existe
        $result = mysqli_query($conexion, "SHOW TABLES LIKE 'tb_usuarios'");
        if (mysqli_num_rows($result) > 0) {
            echo "✅ Tabla 'tb_usuarios' encontrada\n<br>";
            
            // Contar usuarios
            $count = mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_usuarios");
            $row = mysqli_fetch_assoc($count);
            echo "- Total de usuarios registrados: " . $row['total'] . "\n<br>";
        } else {
            echo "❌ Tabla 'tb_usuarios' no encontrada\n<br>";
        }
        
        mysqli_close($conexion);
    } else {
        echo "❌ Error en la conexión\n<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n<br>";
}

echo "\n<br>Prueba completada.";
?>