<?php
// Prueba simple de conexión MySQL
echo "=== PRUEBA DE CONEXIÓN MYSQL ===\n";

// Probar conexión directa sin incluir config.php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db = 'kaboom';
$port = 3306;

echo "Intentando conectar a:\n";
echo "Host: $host\n";
echo "Usuario: $user\n";
echo "Base de datos: $db\n";
echo "Puerto: $port\n\n";

// Intento 1: Sin especificar puerto
echo "--- Intento 1: Sin puerto específico ---\n";
$conexion1 = @mysqli_connect($host, $user, $pass, $db);
if ($conexion1) {
    echo "✅ Conexión exitosa sin puerto específico\n";
    echo "Info del servidor: " . mysqli_get_server_info($conexion1) . "\n";
    mysqli_close($conexion1);
} else {
    echo "❌ Error: " . mysqli_connect_error() . "\n";
}

echo "\n--- Intento 2: Con puerto 3306 ---\n";
$conexion2 = @mysqli_connect($host, $user, $pass, $db, 3306);
if ($conexion2) {
    echo "✅ Conexión exitosa con puerto 3306\n";
    echo "Info del servidor: " . mysqli_get_server_info($conexion2) . "\n";
    
    // Verificar si existe la base de datos
    $result = mysqli_query($conexion2, "SHOW DATABASES LIKE 'kaboom'");
    if (mysqli_num_rows($result) > 0) {
        echo "✅ Base de datos 'kaboom' encontrada\n";
    } else {
        echo "❌ Base de datos 'kaboom' NO encontrada\n";
        echo "Bases de datos disponibles:\n";
        $dbs = mysqli_query($conexion2, "SHOW DATABASES");
        while ($row = mysqli_fetch_array($dbs)) {
            echo "  - " . $row[0] . "\n";
        }
    }
    
    mysqli_close($conexion2);
} else {
    echo "❌ Error: " . mysqli_connect_error() . "\n";
}

echo "\n--- Intento 3: Con puerto 3307 ---\n";
$conexion3 = @mysqli_connect($host, $user, $pass, $db, 3307);
if ($conexion3) {
    echo "✅ Conexión exitosa con puerto 3307\n";
    mysqli_close($conexion3);
} else {
    echo "❌ Error: " . mysqli_connect_error() . "\n";
}

echo "\n=== FIN DE LA PRUEBA ===\n";
?>