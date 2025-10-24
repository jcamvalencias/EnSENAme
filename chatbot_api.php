<?php
session_start();
include_once "conexion.php";
include_once "chatbot_sordos.php";

header('Content-Type: application/json');

// Verificar sesión del usuario
if (empty($_SESSION['txtdoc'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del POST
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['mensaje'])) {
        echo json_encode(["success" => false, "error" => "Mensaje no proporcionado"]);
        exit;
    }
    
    $mensaje = trim($input['mensaje']);
    $usuario_id = isset($input['usuario_id']) ? intval($input['usuario_id']) : $_SESSION['txtdoc'];
    $es_admin = isset($input['es_admin']) ? $input['es_admin'] : false;
    
    if (empty($mensaje)) {
        echo json_encode(["success" => false, "error" => "Mensaje vacío"]);
        exit;
    }
    
    try {
        // Crear instancia del chatbot
        $chatbot = new ChatbotSordos();
        
        // Procesar mensaje con contexto de administrador si es necesario
        if ($es_admin && (strpos(strtolower($mensaje), 'admin') !== false || strpos(strtolower($mensaje), 'ayuda administrativa') !== false)) {
            $respuesta = procesarConsultaAdmin($mensaje);
        } else {
            $respuesta = $chatbot->procesarMensaje($mensaje);
        }
        
        $sugerencias = $es_admin ? obtenerSugerenciasAdmin() : $chatbot->obtenerSugerencias();
        
        // Guardar interacción en logs
        guardarInteraccionChatbot($usuario_id, $mensaje, $respuesta, $es_admin);
        
        echo json_encode([
            "success" => true,
            "respuesta" => $respuesta,
            "sugerencias" => $sugerencias,
            "timestamp" => date('Y-m-d H:i:s')
        ]);
        
    } catch (Exception $e) {
        error_log("Error en chatbot: " . $e->getMessage());
        echo json_encode([
            "success" => false,
            "error" => "Error interno del servidor"
        ]);
    }
    
} else {
    // Método no permitido
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
}

function guardarInteraccionChatbot($usuario_id, $pregunta, $respuesta, $es_admin = false) {
    global $conexion;
    
    // Crear tabla de logs si no existe
    $createTable = "CREATE TABLE IF NOT EXISTS `tb_chatbot_logs` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `usuario_id` INT NOT NULL,
        `pregunta` TEXT NOT NULL,
        `respuesta` TEXT NOT NULL,
        `es_admin` BOOLEAN DEFAULT FALSE,
        `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX `idx_usuario_fecha` (`usuario_id`, `fecha`),
        INDEX `idx_admin` (`es_admin`, `fecha`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci";
    
    mysqli_query($conexion, $createTable);
    
    // Insertar log
    $usuario_id = intval($usuario_id);
    $pregunta = mysqli_real_escape_string($conexion, $pregunta);
    $respuesta = mysqli_real_escape_string($conexion, $respuesta);
    $es_admin = $es_admin ? 1 : 0;
    
    $sql = "INSERT INTO tb_chatbot_logs (usuario_id, pregunta, respuesta, es_admin, fecha) 
            VALUES ($usuario_id, '$pregunta', '$respuesta', $es_admin, NOW())";
    
    mysqli_query($conexion, $sql);
}

function procesarConsultaAdmin($mensaje) {
    $mensaje_lower = strtolower($mensaje);
    
    if (strpos($mensaje_lower, 'ayuda administrativa') !== false || strpos($mensaje_lower, 'ayuda admin') !== false) {
        return "👨‍💼 **Panel de Ayuda Administrativa**\n\n" .
               "Como administrador de EnSEÑAme, puedes:\n\n" .
               "🔧 **Gestión del Sistema:**\n" .
               "• Administrar usuarios y roles\n" .
               "• Supervisar actividad del chatbot\n" .
               "• Revisar logs de interacciones\n" .
               "• Gestionar contenido educativo\n\n" .
               "📊 **Monitoreo:**\n" .
               "• Ver estadísticas de uso\n" .
               "• Analizar consultas frecuentes\n" .
               "• Identificar necesidades de usuarios\n\n" .
               "🤖 **Chatbot:**\n" .
               "• Todas las funciones educativas estándar\n" .
               "• Información sobre sordera y LSC\n" .
               "• Soporte técnico básico\n\n" .
               "¿En qué área específica necesitas ayuda?";
    }
    
    if (strpos($mensaje_lower, 'usuarios') !== false) {
        global $conexion;
        $total_usuarios = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_usuarios"))['total'];
        $usuarios_admin = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_usuarios WHERE id_rol = 1"))['total'];
        
        return "👥 **Información de Usuarios**\n\n" .
               "📈 **Estadísticas actuales:**\n" .
               "• Total de usuarios: $total_usuarios\n" .
               "• Administradores: $usuarios_admin\n" .
               "• Usuarios regulares: " . ($total_usuarios - $usuarios_admin) . "\n\n" .
               "🔧 **Gestión disponible:**\n" .
               "• Crear nuevos usuarios\n" .
               "• Modificar roles y permisos\n" .
               "• Revisar actividad\n" .
               "• Resetear contraseñas\n\n" .
               "Para más detalles, accede al panel de gestión de usuarios.";
    }
    
    if (strpos($mensaje_lower, 'logs') !== false || strpos($mensaje_lower, 'registros') !== false) {
        global $conexion;
        
        // Verificar si existe la tabla de logs
        $logs_table_exists = mysqli_query($conexion, "SHOW TABLES LIKE 'tb_chatbot_logs'");
        if (mysqli_num_rows($logs_table_exists) > 0) {
            $total_logs = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_chatbot_logs"))['total'];
            $logs_admin = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_chatbot_logs WHERE es_admin = 1"))['total'];
            $logs_hoy = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_chatbot_logs WHERE DATE(fecha) = CURDATE()"))['total'];
            
            return "📋 **Logs del Chatbot**\n\n" .
                   "📊 **Estadísticas:**\n" .
                   "• Total de interacciones: $total_logs\n" .
                   "• Consultas administrativas: $logs_admin\n" .
                   "• Interacciones hoy: $logs_hoy\n\n" .
                   "🔍 **Análisis disponible:**\n" .
                   "• Preguntas más frecuentes\n" .
                   "• Horarios de mayor actividad\n" .
                   "• Usuarios más activos\n" .
                   "• Efectividad de respuestas\n\n" .
                   "Para análisis detallados, consulta la base de datos directamente.";
        } else {
            return "📋 **Logs del Chatbot**\n\n" .
                   "ℹ️ Aún no hay logs registrados. Los logs se crean automáticamente " .
                   "cuando los usuarios interactúan con el chatbot.\n\n" .
                   "Los logs incluirán:\n" .
                   "• Preguntas de usuarios\n" .
                   "• Respuestas del bot\n" .
                   "• Fecha y hora\n" .
                   "• Tipo de usuario (admin/regular)";
        }
    }
    
    // Si no es una consulta administrativa específica, usar el chatbot normal
    $chatbot = new ChatbotSordos();
    return "👨‍💼 [Modo Admin] " . $chatbot->procesarMensaje($mensaje);
}

function obtenerSugerenciasAdmin() {
    return [
        "¿Qué es la sordera?",
        "¿Qué es la LSC?",
        "Ayuda administrativa",
        "Estado de usuarios",
        "Logs del sistema",
        "¿Cómo comunicarse con personas sordas?",
        "Estadísticas del chatbot"
    ];
}
?>