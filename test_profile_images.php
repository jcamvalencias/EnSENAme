<?php
/**
 * Script de prueba para verificar el sistema de imágenes de perfil
 */

include 'conexion.php';
include 'includes/helpers.php';

echo "<h1>Test del Sistema de Imágenes de Perfil - EnSEÑAme</h1>";

// Verificar si existe la columna foto_perfil
echo "<h2>1. Verificación de Base de Datos</h2>";
$query_check = "SHOW COLUMNS FROM tb_usuarios LIKE 'foto_perfil'";
$result_check = mysqli_query($conexion, $query_check);

if (mysqli_num_rows($result_check) > 0) {
    echo "✅ La columna 'foto_perfil' existe en la tabla tb_usuarios<br>";
} else {
    echo "❌ La columna 'foto_perfil' NO existe en la tabla tb_usuarios<br>";
    echo "🔧 Ejecuta el archivo 'agregar_columna_foto.sql' en tu base de datos<br>";
}

// Verificar directorios
echo "<h2>2. Verificación de Directorios</h2>";
$upload_dir = "uploads/profile_images/";
if (file_exists($upload_dir)) {
    echo "✅ El directorio 'uploads/profile_images/' existe<br>";
    echo "📁 Permisos del directorio: " . substr(sprintf('%o', fileperms($upload_dir)), -4) . "<br>";
} else {
    echo "❌ El directorio 'uploads/profile_images/' NO existe<br>";
    echo "🔧 Creando directorio...<br>";
    if (mkdir($upload_dir, 0755, true)) {
        echo "✅ Directorio creado exitosamente<br>";
    } else {
        echo "❌ Error al crear el directorio<br>";
    }
}

// Verificar archivo .htaccess
$htaccess_file = $upload_dir . ".htaccess";
if (file_exists($htaccess_file)) {
    echo "✅ El archivo de seguridad .htaccess existe<br>";
} else {
    echo "❌ El archivo .htaccess NO existe en el directorio de uploads<br>";
}

// Verificar archivo helpers.php
echo "<h2>3. Verificación de Funciones Helper</h2>";
if (file_exists('includes/helpers.php')) {
    echo "✅ El archivo 'includes/helpers.php' existe<br>";
    
    // Probar función obtenerFotoPerfil
    if (function_exists('obtenerFotoPerfil')) {
        echo "✅ Función 'obtenerFotoPerfil' disponible<br>";
        $test_foto = obtenerFotoPerfil('', '');
        echo "🧪 Prueba con foto vacía: " . $test_foto . "<br>";
    } else {
        echo "❌ Función 'obtenerFotoPerfil' NO disponible<br>";
    }
    
    if (function_exists('validarImagenPerfil')) {
        echo "✅ Función 'validarImagenPerfil' disponible<br>";
    } else {
        echo "❌ Función 'validarImagenPerfil' NO disponible<br>";
    }
    
    if (function_exists('guardarImagenPerfil')) {
        echo "✅ Función 'guardarImagenPerfil' disponible<br>";
    } else {
        echo "❌ Función 'guardarImagenPerfil' NO disponible<br>";
    }
} else {
    echo "❌ El archivo 'includes/helpers.php' NO existe<br>";
}

// Mostrar usuarios con fotos
echo "<h2>4. Usuarios con Fotos de Perfil</h2>";
$query_users = "SELECT ID, p_nombre, p_apellido, foto_perfil FROM tb_usuarios WHERE foto_perfil IS NOT NULL AND foto_perfil != ''";
$result_users = mysqli_query($conexion, $query_users);

if ($result_users && mysqli_num_rows($result_users) > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-top: 10px;'>";
    echo "<tr style='background-color: #f0f0f0;'><th>ID</th><th>Nombre</th><th>Foto</th><th>Archivo Existe</th><th>Vista Previa</th></tr>";
    
    while ($user = mysqli_fetch_assoc($result_users)) {
        $foto_path = $upload_dir . $user['foto_perfil'];
        $archivo_existe = file_exists($foto_path) ? "✅ Sí" : "❌ No";
        $foto_url = obtenerFotoPerfil($user['foto_perfil'], '');
        
        echo "<tr>";
        echo "<td>" . $user['ID'] . "</td>";
        echo "<td>" . $user['p_nombre'] . " " . $user['p_apellido'] . "</td>";
        echo "<td>" . $user['foto_perfil'] . "</td>";
        echo "<td>" . $archivo_existe . "</td>";
        echo "<td><img src='" . $foto_url . "' alt='Foto de perfil' style='width: 50px; height: 50px; border-radius: 50%; object-fit: cover;'></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "ℹ️ No hay usuarios con fotos de perfil guardadas<br>";
}

// Información del sistema
echo "<h2>5. Información del Sistema</h2>";
echo "📊 PHP Version: " . phpversion() . "<br>";
echo "📊 Max Upload Size: " . ini_get('upload_max_filesize') . "<br>";
echo "📊 Max Post Size: " . ini_get('post_max_size') . "<br>";
echo "📊 Memory Limit: " . ini_get('memory_limit') . "<br>";

// Verificar extensiones PHP necesarias
$extensions = ['gd', 'mysqli'];
echo "<h3>Extensiones PHP:</h3>";
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ " . $ext . " cargada<br>";
    } else {
        echo "❌ " . $ext . " NO cargada<br>";
    }
}

echo "<hr>";
echo "<p><strong>Instrucciones:</strong></p>";
echo "<ol>";
echo "<li>Si hay errores marcados con ❌, corrige esos problemas primero</li>";
echo "<li>Asegúrate de que el servidor web tenga permisos de escritura en el directorio uploads/</li>";
echo "<li>Prueba subir una foto desde el perfil de usuario</li>";
echo "<li>Verifica que las fotos aparezcan correctamente en el chat y otros lugares</li>";
echo "</ol>";

echo "<p><em>Desarrollado para EnSEÑAme - Sistema de gestión de perfiles</em></p>";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h1 { color: #2c3e50; }
h2 { color: #34495e; border-bottom: 2px solid #3498db; padding-bottom: 5px; }
h3 { color: #7f8c8d; }
table { margin-top: 10px; }
th, td { padding: 8px; text-align: left; }
th { background-color: #3498db; color: white; }
tr:nth-child(even) { background-color: #f2f2f2; }
</style>