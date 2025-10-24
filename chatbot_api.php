<?php<?php

session_start();// Prevenir cualquier salida antes de los headers

require_once 'conexion.php';ob_start();

require_once 'chatbot_sordos.php';

require_once 'helpers.php';// Configurar manejo de errores ESPECÍFICAMENTE para API

error_reporting(0);

// Configuración de headers para APIini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');ini_set('display_startup_errors', 0);

header('Access-Control-Allow-Origin: *');ini_set('log_errors', 0);

header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

header('Access-Control-Allow-Headers: Content-Type');// Sistema de logging personalizado simplificado

function debug_log($message) {

// Función de logging para la API    $log_file = __DIR__ . '/chatbot_debug.log';

function debug_log_api($mensaje) {    $timestamp = date('Y-m-d H:i:s');

    $timestamp = date('Y-m-d H:i:s');    $log_message = "[$timestamp] " . mb_convert_encoding($message, 'UTF-8', 'auto') . "\n";

    $log_entry = "[$timestamp] API: $mensaje" . PHP_EOL;    @file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);

    file_put_contents('chatbot_debug.log', $log_entry, FILE_APPEND | LOCK_EX);}

}

// Función para enviar respuesta JSON limpia

// Limpiar cualquier output buffer previofunction enviar_respuesta_json($data) {

if (ob_get_level()) {    // Limpiar cualquier output buffer

    ob_clean();    while (ob_get_level()) {

}        ob_end_clean();

    }

try {    

    debug_log_api("=== NUEVA SOLICITUD API ===");    header('Content-Type: application/json; charset=utf-8');

    debug_log_api("Método HTTP: " . $_SERVER['REQUEST_METHOD']);    header('Cache-Control: no-cache, must-revalidate');

        header('Access-Control-Allow-Origin: *');

    // Validar método HTTP    header('Access-Control-Allow-Methods: POST');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {    header('Access-Control-Allow-Headers: Content-Type');

        throw new Exception('Solo se permiten solicitudes POST');    

    }    echo json_encode($data, JSON_UNESCAPED_UNICODE);

    exit;

    // Validar datos POST}

    $input = file_get_contents('php://input');

    if (!empty($input)) {// Función para manejo de errores

        $data = json_decode($input, true);function manejar_error($mensaje, $codigo = 500) {

        if ($data && isset($data['mensaje'])) {    debug_log("ERROR API: $mensaje");

            $_POST['mensaje'] = $data['mensaje'];    http_response_code($codigo);

        }    enviar_respuesta_json(["success" => false, "error" => $mensaje]);

    }}



    debug_log_api("Datos recibidos: " . json_encode($_POST));debug_log("=== INICIO CHATBOT API ===");

debug_log("Método: " . $_SERVER['REQUEST_METHOD']);

    if (!isset($_POST['mensaje']) || empty(trim($_POST['mensaje']))) {debug_log("Content-Type: " . ($_SERVER['CONTENT_TYPE'] ?? 'No definido'));

        throw new Exception('Mensaje vacío o no proporcionado');

    }// Cargar conexión primero

debug_log("Cargando conexión...");

    $mensaje = trim($_POST['mensaje']);include_once "conexion.php";

    $usuario_id = $_SESSION['usuario_id'] ?? 'invitado';debug_log("Conexión cargada");

    

    debug_log_api("Mensaje procesado: '$mensaje'");// Luego cargar sesión

    debug_log_api("Usuario: $usuario_id");debug_log("Cargando sesión...");

require_once __DIR__ . '/includes/session.php';

    // Verificar que el chatbot esté disponibledebug_log("Sesión cargada");

    if (!class_exists('ChatbotSordos')) {

        throw new Exception('Sistema de chatbot no disponible');// Cargar chatbot paso a paso para identificar el problema

    }debug_log("Iniciando carga de chatbot...");

try {

    // Crear y usar el chatbot    debug_log("Verificando archivo chatbot_sordos.php");

    debug_log_api("Creando instancia del chatbot...");    if (!file_exists("chatbot_sordos.php")) {

    $chatbot = new ChatbotSordos();        debug_log("ERROR: Archivo chatbot_sordos.php no existe");

            manejar_error("Archivo del chatbot no encontrado");

    debug_log_api("Procesando mensaje con chatbot...");    }

    $respuesta = $chatbot->procesarMensaje($mensaje, $usuario_id);    

        debug_log("Incluyendo chatbot_sordos.php");

    if (empty($respuesta)) {    include_once "chatbot_sordos.php";

        throw new Exception('El chatbot no pudo generar una respuesta');    debug_log("Archivo incluido, verificando clase");

    }    

    if (!class_exists('ChatbotSordos')) {

    debug_log_api("Respuesta generada exitosamente");        debug_log("ERROR: Clase ChatbotSordos no existe después de incluir");

        manejar_error("Clase ChatbotSordos no encontrada");

    // Preparar respuesta JSON    }

    $resultado = [    

        'success' => true,    debug_log("Chatbot cargado exitosamente");

        'respuesta' => $respuesta,} catch (ParseError $e) {

        'sugerencias' => $chatbot->obtenerSugerencias(),    debug_log("ERROR DE SINTAXIS: " . $e->getMessage() . " en línea " . $e->getLine());

        'timestamp' => date('Y-m-d H:i:s'),    manejar_error("Error de sintaxis en chatbot: " . $e->getMessage());

        'usuario' => $usuario_id} catch (Exception $e) {

    ];    debug_log("ERROR EXCEPCIÓN: " . $e->getMessage());

    manejar_error("Error interno del chatbot: " . $e->getMessage());

    debug_log_api("Enviando respuesta JSON...");} catch (Error $e) {

        debug_log("ERROR FATAL: " . $e->getMessage());

    // Enviar respuesta    manejar_error("Error fatal del chatbot: " . $e->getMessage());

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);}



} catch (Exception $e) {// Verificar sesión del usuario

    debug_log_api("ERROR: " . $e->getMessage());if (empty($_SESSION['txtdoc'])) {

    debug_log_api("Trace: " . $e->getTraceAsString());    manejar_error("No autorizado - Sesión no válida", 401);

    }

    http_response_code(500);

    echo json_encode([if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        'success' => false,    // Debug: Log de la entrada

        'error' => $e->getMessage(),    debug_log("Chatbot API: Entrada recibida");

        'timestamp' => date('Y-m-d H:i:s')    debug_log("Session txtdoc: " . ($_SESSION['txtdoc'] ?? 'NO_SET'));

    ], JSON_UNESCAPED_UNICODE);    debug_log("POST data: " . file_get_contents('php://input'));

    

} catch (Error $e) {    // Obtener datos del POST

    debug_log_api("ERROR FATAL: " . $e->getMessage());    $input = json_decode(file_get_contents('php://input'), true);

    debug_log_api("Archivo: " . $e->getFile() . " Línea: " . $e->getLine());    

        if (!$input || !isset($input['mensaje'])) {

    http_response_code(500);        manejar_error("Mensaje no proporcionado", 400);

    echo json_encode([    }

        'success' => false,    

        'error' => 'Error interno del sistema',    $mensaje = trim($input['mensaje']);

        'timestamp' => date('Y-m-d H:i:s')    $usuario_id = isset($input['usuario_id']) ? intval($input['usuario_id']) : $_SESSION['txtdoc'];

    ], JSON_UNESCAPED_UNICODE);    $es_admin = isset($input['es_admin']) ? $input['es_admin'] : false;

}    

    debug_log("Chatbot API: Procesando mensaje: $mensaje para usuario: $usuario_id");

debug_log_api("=== FIN SOLICITUD API ===");    

?>    if (empty($mensaje)) {
        manejar_error("Mensaje vacío", 400);
    }
    
    try {
        debug_log("Iniciando procesamiento de mensaje");
        
        // Verificar nuevamente que la clase existe
        if (!class_exists('ChatbotSordos')) {
            debug_log("ERROR: Clase no disponible para instanciar");
            // Fallback a respuesta básica
            $respuesta = "🤖 Sistema en modo básico. Tu consulta: '$mensaje' ha sido recibida.";
            $sugerencias = ["¿Qué es la sordera?", "¿Qué es la LSC?", "Cultura sorda"];
        } else {
            debug_log("Creando instancia de ChatbotSordos");
            $chatbot = new ChatbotSordos();
            debug_log("Instancia creada exitosamente");
            
            // Procesar mensaje
            if ($es_admin && (strpos(strtolower($mensaje), 'admin') !== false)) {
                debug_log("Procesando consulta de admin");
                // Respuesta temporal para admin
                $respuesta = "👤 Admin: Consulta '$mensaje' procesada. Sistema operativo.";
                $sugerencias = ["Estado del sistema", "Usuarios activos", "Estadísticas"];
            } else {
                debug_log("Procesando mensaje normal con chatbot");
                $respuesta = $chatbot->procesarMensaje($mensaje, $usuario_id);
                debug_log("Mensaje procesado exitosamente");
                $sugerencias = $chatbot->obtenerSugerencias();
            }
        }
        
        debug_log("Omitiendo guardado por debug");
        
        $response_data = [
            "success" => true,
            "respuesta" => $respuesta,
            "sugerencias" => $sugerencias,
            "timestamp" => date('Y-m-d H:i:s')
        ];
        
        debug_log("Chatbot API: Enviando respuesta exitosa");
        enviar_respuesta_json($response_data);
        
    } catch (Exception $e) {
        manejar_error("Error interno del servidor: " . $e->getMessage(), 500);
    }
    
} else {
    // Método no permitido
    manejar_error("Método no permitido. Use POST.", 405);
}

function guardarInteraccionChatbot($usuario_id, $pregunta, $respuesta, $es_admin = false) {
    global $conexion;
    
    try {
        // La tabla ya existe en kaboom.sql, no necesitamos crearla
        // Insertar log usando la estructura correcta de kaboom.sql
        $usuario_id = intval($usuario_id);
        $mensaje_usuario = mysqli_real_escape_string($conexion, $pregunta);
        $respuesta_bot = mysqli_real_escape_string($conexion, $respuesta);
        
        // Determinar tipo_respuesta y origen basado en el contenido
        $tipo_respuesta = 'info'; // por defecto
        $origen = $es_admin ? 'admin' : 'user';
        
        // Clasificar el tipo de respuesta
        if (stripos($respuesta, 'LSC') !== false || stripos($respuesta, 'lengua de señas') !== false) {
            $tipo_respuesta = 'educativo';
        } elseif (stripos($respuesta, 'estadística') !== false || stripos($respuesta, 'datos') !== false) {
            $tipo_respuesta = 'admin';
        }
        
        $sql = "INSERT INTO tb_chatbot_logs (usuario_id, mensaje_usuario, respuesta_bot, tipo_respuesta, origen) 
                VALUES ($usuario_id, '$mensaje_usuario', '$respuesta_bot', '$tipo_respuesta', '$origen')";
        
        $result = mysqli_query($conexion, $sql);
        
        if (!$result) {
            debug_log("Error al guardar log de chatbot: " . mysqli_error($conexion));
        } else {
            debug_log("Log de chatbot guardado exitosamente");
        }
    } catch (Exception $e) {
        debug_log("Excepción al guardar log: " . $e->getMessage());
    }
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
            $logs_admin = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_chatbot_logs WHERE origen = 'admin'"))['total'];
            $logs_hoy = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_chatbot_logs WHERE DATE(timestamp) = CURDATE()"))['total'];
            
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