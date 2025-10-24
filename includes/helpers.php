<?php
/**
 * Funciones auxiliares para el sistema EnSEÑAme
 */

// Evitar redeclaración de funciones
if (!function_exists('obtenerFotoPerfil')) {

/**
 * Obtiene la URL de la foto de perfil de un usuario
 * @param string $foto_perfil Nombre del archivo de foto desde la base de datos
 * @param string $ruta_base Ruta base desde donde se llama la función
 * @return string URL de la imagen de perfil o imagen por defecto
 */
function obtenerFotoPerfil($foto_perfil, $ruta_base = '') {
    $ruta_uploads = $ruta_base . 'uploads/profile_images/';
    $imagen_default = $ruta_base . 'admin/assets/images/user/avatar-2.jpg';
    
    if (!empty($foto_perfil) && file_exists($ruta_uploads . $foto_perfil)) {
        return $ruta_uploads . $foto_perfil;
    }
    
    return $imagen_default;
}

} // Fin guard obtenerFotoPerfil

if (!function_exists('formatearNombreCompleto')) {

/**
 * Formatea el nombre completo de un usuario
 * @param array $usuario Datos del usuario de la base de datos
 * @return string Nombre completo formateado
 */
function formatearNombreCompleto($usuario) {
    $partes = array_filter([
        $usuario['p_nombre'] ?? '',
        $usuario['s_nombre'] ?? '',
        $usuario['p_apellido'] ?? '',
        $usuario['s_apellido'] ?? ''
    ]);
    
    return implode(' ', $partes);
}

} // Fin guard formatearNombreCompleto

if (!function_exists('validarImagenPerfil')) {

/**
 * Valida si un archivo de imagen es válido
 * @param array $archivo Archivo $_FILES
 * @return array ['valido' => bool, 'mensaje' => string]
 */
function validarImagenPerfil($archivo) {
    $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $tamaño_maximo = 5 * 1024 * 1024; // 5MB
    
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return ['valido' => false, 'mensaje' => 'Error al subir el archivo.'];
    }
    
    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $extensiones_permitidas)) {
        return ['valido' => false, 'mensaje' => 'Formato no válido. Solo JPG, JPEG, PNG, GIF, WEBP.'];
    }
    
    if ($archivo['size'] > $tamaño_maximo) {
        return ['valido' => false, 'mensaje' => 'La imagen es demasiado grande. Máximo 5MB.'];
    }
    
    // Verificar que realmente es una imagen
    $info_imagen = getimagesize($archivo['tmp_name']);
    if ($info_imagen === false) {
        return ['valido' => false, 'mensaje' => 'El archivo no es una imagen válida.'];
    }
    
    return ['valido' => true, 'mensaje' => 'Imagen válida.'];
}

} // Fin guard validarImagenPerfil

if (!function_exists('guardarImagenPerfil')) {

/**
 * Guarda una imagen de perfil
 * @param array $archivo Archivo $_FILES
 * @param int $user_id ID del usuario
 * @param string $foto_anterior Nombre de la foto anterior para eliminar
 * @param string $ruta_base Ruta base donde está la carpeta uploads
 * @return array ['exito' => bool, 'archivo' => string, 'mensaje' => string]
 */
function guardarImagenPerfil($archivo, $user_id, $foto_anterior = '', $ruta_base = '') {
    $validacion = validarImagenPerfil($archivo);
    if (!$validacion['valido']) {
        return ['exito' => false, 'archivo' => '', 'mensaje' => $validacion['mensaje']];
    }
    
    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    $nombre_archivo = $user_id . '_' . time() . '.' . $extension;
    $directorio = $ruta_base . 'uploads/profile_images/';
    $ruta_completa = $directorio . $nombre_archivo;
    
    // Crear directorio si no existe
    if (!file_exists($directorio)) {
        mkdir($directorio, 0755, true);
    }
    
    // Mover archivo
    if (move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
        // Eliminar foto anterior si existe
        if (!empty($foto_anterior) && file_exists($directorio . $foto_anterior)) {
            unlink($directorio . $foto_anterior);
        }
        
        return ['exito' => true, 'archivo' => $nombre_archivo, 'mensaje' => 'Imagen guardada correctamente.'];
    }
    
    return ['exito' => false, 'archivo' => '', 'mensaje' => 'Error al guardar la imagen.'];
}

} // Fin guard guardarImagenPerfil
?>