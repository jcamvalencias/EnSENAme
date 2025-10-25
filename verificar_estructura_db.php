<?php
/**
 * Script de verificación completa de la estructura de la base de datos EnSEÑAme
 */

include 'conexion.php';

echo "<h1>🔍 Verificación Completa de Base de Datos - EnSEÑAme</h1>";
echo "<p><strong>Fecha de verificación:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<hr>";

// Verificar conexión
if (!$conexion) {
    echo "<div style='color: red; font-weight: bold;'>❌ Error de conexión a la base de datos</div>";
    exit;
}

echo "<div style='color: green;'>✅ Conexión a la base de datos exitosa</div><br>";

// 1. Verificar tablas existentes
echo "<h2>📋 1. Tablas Existentes</h2>";
$query_tables = "SHOW TABLES";
$result_tables = mysqli_query($conexion, $query_tables);

$tablas_existentes = [];
if ($result_tables) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
    echo "<tr style='background-color: #3498db; color: white;'><th>Nombre de Tabla</th><th>Estado</th></tr>";
    
    while ($row = mysqli_fetch_array($result_tables)) {
        $tabla = $row[0];
        $tablas_existentes[] = $tabla;
        echo "<tr><td>" . $tabla . "</td><td style='color: green;'>✅ Existe</td></tr>";
    }
    echo "</table>";
} else {
    echo "<div style='color: red;'>❌ Error al obtener las tablas</div>";
}

// Tablas requeridas
$tablas_requeridas = ['tb_usuarios', 'tbl_rol', 'tb_mensajes', 'tb_chatbot_logs'];
$tablas_faltantes = array_diff($tablas_requeridas, $tablas_existentes);

if (empty($tablas_faltantes)) {
    echo "<div style='color: green; font-weight: bold;'>✅ Todas las tablas requeridas están presentes</div>";
} else {
    echo "<div style='color: red; font-weight: bold;'>❌ Tablas faltantes: " . implode(', ', $tablas_faltantes) . "</div>";
}

echo "<br>";

// 2. Verificar estructura de tb_usuarios
echo "<h2>👤 2. Estructura de tb_usuarios</h2>";
$query_usuarios = "DESCRIBE tb_usuarios";
$result_usuarios = mysqli_query($conexion, $query_usuarios);

$columnas_usuarios = [];
if ($result_usuarios) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
    echo "<tr style='background-color: #3498db; color: white;'><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Por Defecto</th><th>Extra</th></tr>";
    
    while ($row = mysqli_fetch_assoc($result_usuarios)) {
        $columnas_usuarios[] = $row['Field'];
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Columnas requeridas en tb_usuarios
$columnas_requeridas_usuarios = [
    'ID', 'Tipo_Documento', 'p_nombre', 's_nombre', 'p_apellido', 's_apellido', 
    'Clave', 'id_rol', 'needs_pw_change', 'foto_perfil'
];

echo "<h3>Verificación de columnas requeridas:</h3>";
foreach ($columnas_requeridas_usuarios as $columna) {
    if (in_array($columna, $columnas_usuarios)) {
        echo "<div style='color: green;'>✅ " . $columna . "</div>";
    } else {
        echo "<div style='color: red;'>❌ " . $columna . " (FALTANTE)</div>";
    }
}

// Verificar columnas adicionales que podrían faltar
$columnas_adicionales = ['telefono', 'region', 'condicion'];
echo "<h3>Columnas adicionales que podrían ser necesarias:</h3>";
foreach ($columnas_adicionales as $columna) {
    if (in_array($columna, $columnas_usuarios)) {
        echo "<div style='color: green;'>✅ " . $columna . "</div>";
    } else {
        echo "<div style='color: orange;'>⚠️ " . $columna . " (Podría ser necesaria)</div>";
    }
}

echo "<br>";

// 3. Verificar estructura de tb_mensajes
echo "<h2>💬 3. Estructura de tb_mensajes</h2>";
$query_mensajes = "DESCRIBE tb_mensajes";
$result_mensajes = mysqli_query($conexion, $query_mensajes);

if ($result_mensajes) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
    echo "<tr style='background-color: #3498db; color: white;'><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Por Defecto</th></tr>";
    
    while ($row = mysqli_fetch_assoc($result_mensajes)) {
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
    echo "<div style='color: red;'>❌ Error al obtener estructura de tb_mensajes</div>";
}

echo "<br>";

// 4. Verificar estructura de tb_chatbot_logs
echo "<h2>🤖 4. Estructura de tb_chatbot_logs</h2>";
$query_chatbot = "DESCRIBE tb_chatbot_logs";
$result_chatbot = mysqli_query($conexion, $query_chatbot);

if ($result_chatbot) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
    echo "<tr style='background-color: #3498db; color: white;'><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Por Defecto</th></tr>";
    
    while ($row = mysqli_fetch_assoc($result_chatbot)) {
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
    echo "<div style='color: red;'>❌ Error al obtener estructura de tb_chatbot_logs</div>";
}

echo "<br>";

// 5. Verificar relaciones foráneas
echo "<h2>🔗 5. Relaciones Foráneas</h2>";
$query_fk = "
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM 
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
WHERE 
    REFERENCED_TABLE_SCHEMA = DATABASE()
    AND REFERENCED_TABLE_NAME IS NOT NULL
";

$result_fk = mysqli_query($conexion, $query_fk);

if ($result_fk && mysqli_num_rows($result_fk) > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
    echo "<tr style='background-color: #3498db; color: white;'><th>Tabla</th><th>Columna</th><th>Referencia Tabla</th><th>Referencia Columna</th></tr>";
    
    while ($row = mysqli_fetch_assoc($result_fk)) {
        echo "<tr>";
        echo "<td>" . $row['TABLE_NAME'] . "</td>";
        echo "<td>" . $row['COLUMN_NAME'] . "</td>";
        echo "<td>" . $row['REFERENCED_TABLE_NAME'] . "</td>";
        echo "<td>" . $row['REFERENCED_COLUMN_NAME'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<div style='color: orange;'>⚠️ No se encontraron relaciones foráneas configuradas</div>";
}

echo "<br>";

// 6. Verificar datos de ejemplo
echo "<h2>📊 6. Datos de Ejemplo</h2>";

// Contar usuarios
$query_count_users = "SELECT COUNT(*) as total FROM tb_usuarios";
$result_count_users = mysqli_query($conexion, $query_count_users);
$count_users = mysqli_fetch_assoc($result_count_users)['total'];

// Contar mensajes
$query_count_messages = "SELECT COUNT(*) as total FROM tb_mensajes";
$result_count_messages = mysqli_query($conexion, $query_count_messages);
$count_messages = mysqli_fetch_assoc($result_count_messages)['total'];

// Contar logs del chatbot
$query_count_logs = "SELECT COUNT(*) as total FROM tb_chatbot_logs";
$result_count_logs = mysqli_query($conexion, $query_count_logs);
$count_logs = mysqli_fetch_assoc($result_count_logs)['total'];

echo "<table border='1' style='border-collapse: collapse; width: 50%; margin: 10px 0;'>";
echo "<tr style='background-color: #3498db; color: white;'><th>Tabla</th><th>Cantidad de registros</th></tr>";
echo "<tr><td>tb_usuarios</td><td>" . $count_users . "</td></tr>";
echo "<tr><td>tb_mensajes</td><td>" . $count_messages . "</td></tr>";
echo "<tr><td>tb_chatbot_logs</td><td>" . $count_logs . "</td></tr>";
echo "</table>";

echo "<br>";

// 7. Scripts de corrección recomendados
echo "<h2>🛠️ 7. Scripts de Corrección Recomendados</h2>";

$correcciones_necesarias = [];

// Verificar si falta foto_perfil
if (!in_array('foto_perfil', $columnas_usuarios)) {
    $correcciones_necesarias[] = "Ejecutar agregar_columna_foto.sql";
}

// Verificar si faltan columnas adicionales de perfil
$columnas_perfil_faltantes = array_diff($columnas_adicionales, $columnas_usuarios);
if (!empty($columnas_perfil_faltantes)) {
    $correcciones_necesarias[] = "Agregar columnas de perfil: " . implode(', ', $columnas_perfil_faltantes);
}

if (empty($correcciones_necesarias)) {
    echo "<div style='color: green; font-weight: bold;'>✅ No se requieren correcciones adicionales</div>";
} else {
    echo "<div style='color: orange; font-weight: bold;'>⚠️ Se requieren las siguientes correcciones:</div>";
    echo "<ul>";
    foreach ($correcciones_necesarias as $correccion) {
        echo "<li>" . $correccion . "</li>";
    }
    echo "</ul>";
}

// 8. Script para agregar columnas faltantes
if (!empty($columnas_perfil_faltantes)) {
    echo "<h3>Script SQL para agregar columnas de perfil faltantes:</h3>";
    echo "<div style='background-color: #f8f9fa; padding: 15px; border: 1px solid #ddd; font-family: monospace;'>";
    foreach ($columnas_perfil_faltantes as $columna) {
        switch ($columna) {
            case 'telefono':
                echo "ALTER TABLE tb_usuarios ADD COLUMN telefono VARCHAR(20) NULL;<br>";
                break;
            case 'region':
                echo "ALTER TABLE tb_usuarios ADD COLUMN region VARCHAR(100) NULL;<br>";
                break;
            case 'condicion':
                echo "ALTER TABLE tb_usuarios ADD COLUMN condicion VARCHAR(100) NULL;<br>";
                break;
        }
    }
    echo "</div>";
}

echo "<hr>";
echo "<p><strong>🎯 Resumen:</strong> " . (empty($correcciones_necesarias) ? "Base de datos completa y funcional" : "Se requieren " . count($correcciones_necesarias) . " correcciones") . "</p>";
echo "<p><em>Desarrollado para EnSEÑAme - Verificación de integridad de base de datos</em></p>";

mysqli_close($conexion);
?>

<style>
body { 
    font-family: Arial, sans-serif; 
    margin: 20px; 
    background-color: #f8f9fa;
}
h1 { 
    color: #2c3e50; 
    border-bottom: 3px solid #3498db;
    padding-bottom: 10px;
}
h2 { 
    color: #34495e; 
    border-bottom: 2px solid #3498db; 
    padding-bottom: 5px; 
    margin-top: 30px;
}
h3 { 
    color: #7f8c8d; 
}
table { 
    margin-top: 10px; 
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
th, td { 
    padding: 8px; 
    text-align: left; 
}
th { 
    background-color: #3498db; 
    color: white; 
}
tr:nth-child(even) { 
    background-color: #f2f2f2; 
}
tr:hover {
    background-color: #e8f4fd;
}
hr {
    border: 1px solid #3498db;
    margin: 20px 0;
}
</style>