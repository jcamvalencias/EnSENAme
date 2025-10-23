<?php
// Chatbot inteligente con información sobre sordera
// Integración con info_sordos_api.php

class ChatbotSordos {
    private $palabras_clave = [
        'definicion' => ['qué es sordera', 'definición sordera', 'tipos sordera', 'sordo', 'sorda'],
        'causas_principales' => ['causas sordera', 'por qué sordera', 'cómo se produce', 'origen sordera', 'genética', 'congénito', 'hereditario'],
        'grados_perdida' => ['grados', 'niveles', 'decibeles', 'leve', 'moderada', 'severa', 'profunda'],
        'cultura_sorda' => ['cultura sorda', 'comunidad sorda', 'identidad sorda', 'valores'],
        'lengua_señas_colombiana' => ['LSC', 'lengua de señas', 'señas colombiana', 'lenguaje señas', 'colombiano'],
        'tecnologias_apoyo' => ['audífono', 'implante coclear', 'tecnología', 'ayuda auditiva', 'dispositivos'],
        'inclusion_educativa' => ['educación', 'inclusión', 'escuela', 'aprendizaje', 'bilingüe'],
        'mitos_realidades' => ['mito', 'verdad', 'realidad', 'falso', 'cierto'],
        'datos_estadisticos' => ['estadísticas', 'números', 'cuántos', 'población', 'datos'],
        'como_comunicarse' => ['cómo comunicar', 'hablar con', 'comunicación', 'consejos', 'tips']
    ];
    
    private $respuestas_generales = [
        'saludo' => '¡Hola! Soy el asistente de EnSEÑAme. Puedo ayudarte con información sobre sordera, LSC y la comunidad sorda. ¿En qué te puedo ayudar?',
        'despedida' => '¡Hasta luego! Recuerda que siempre puedes preguntarme sobre sordera y lengua de señas. ¡Que tengas un buen día!',
        'no_entiendo' => 'No estoy seguro de entender tu pregunta. Puedo ayudarte con información sobre: causas de sordera, LSC, cultura sorda, tecnologías de apoyo, educación inclusiva y más. ¿Podrías ser más específico?',
        'agradecimiento' => '¡De nada! Me alegra poder ayudarte a aprender más sobre la comunidad sorda y la LSC. ¿Hay algo más en lo que pueda ayudarte?'
    ];
    
    public function procesarMensaje($mensaje) {
        $mensaje = strtolower(trim($mensaje));
        
        // Detectar tipo de mensaje
        if ($this->esSaludo($mensaje)) {
            return $this->respuestas_generales['saludo'];
        }
        
        if ($this->esDespedida($mensaje)) {
            return $this->respuestas_generales['despedida'];
        }
        
        if ($this->esAgradecimiento($mensaje)) {
            return $this->respuestas_generales['agradecimiento'];
        }
        
        // Buscar información específica
        $seccion = $this->detectarSeccion($mensaje);
        if ($seccion) {
            return $this->obtenerInformacion($seccion, $mensaje);
        }
        
        // Si no se detecta intención específica, buscar en contenido
        $resultados = $this->buscarEnContenido($mensaje);
        if ($resultados) {
            return $resultados;
        }
        
        return $this->respuestas_generales['no_entiendo'];
    }
    
    private function esSaludo($mensaje) {
        $saludos = ['hola', 'buenos días', 'buenas tardes', 'buenas noches', 'hey', 'hi'];
        foreach ($saludos as $saludo) {
            if (strpos($mensaje, $saludo) !== false) {
                return true;
            }
        }
        return false;
    }
    
    private function esDespedida($mensaje) {
        $despedidas = ['adiós', 'chao', 'hasta luego', 'nos vemos', 'bye', 'gracias'];
        foreach ($despedidas as $despedida) {
            if (strpos($mensaje, $despedida) !== false) {
                return true;
            }
        }
        return false;
    }
    
    private function esAgradecimiento($mensaje) {
        $agradecimientos = ['gracias', 'thank you', 'excelente', 'perfecto', 'muy bien'];
        foreach ($agradecimientos as $agradecimiento) {
            if (strpos($mensaje, $agradecimiento) !== false) {
                return true;
            }
        }
        return false;
    }
    
    private function detectarSeccion($mensaje) {
        foreach ($this->palabras_clave as $seccion => $palabras) {
            foreach ($palabras as $palabra) {
                if (strpos($mensaje, $palabra) !== false) {
                    return $seccion;
                }
            }
        }
        return null;
    }
    
    private function obtenerInformacion($seccion, $mensaje_original = '') {
        try {
            // Llamar a la API interna
            $url = __DIR__ . '/info_sordos_api.php';
            
            // Simular petición GET
            $_GET['seccion'] = $seccion;
            ob_start();
            include $url;
            $response = ob_get_clean();
            
            $data = json_decode($response, true);
            
            if ($data && $data['success']) {
                return $this->formatearRespuesta($seccion, $data['data'], $mensaje_original);
            }
        } catch (Exception $e) {
            // Fallback si no se puede acceder a la API
            return $this->obtenerRespuestaFallback($seccion);
        }
        
        return $this->respuestas_generales['no_entiendo'];
    }
    
    private function formatearRespuesta($seccion, $data, $mensaje_original) {
        switch ($seccion) {
            case 'definicion':
                return "🔍 **¿Qué es la sordera?**\n\n" . 
                       $data['descripcion'] . "\n\n" .
                       "**Tipos principales:**\n" .
                       "• " . implode("\n• ", array_column($data['tipos'], 'tipo')) . "\n\n" .
                       "¿Te gustaría saber más sobre algún tipo específico?";
            
            case 'causas_principales':
                return "📊 **Principales causas de sordera:**\n\n" .
                       "**Congénitas (desde nacimiento):**\n" .
                       "• Genética: 50-60% de los casos\n" .
                       "• Infecciones maternas: 15-20%\n" .
                       "• Complicaciones perinatales: 10-15%\n\n" .
                       "**Adquiridas (desarrolladas después):**\n" .
                       "• Exposición a ruido intenso\n" .
                       "• Infecciones (meningitis, otitis crónica)\n" .
                       "• Medicamentos ototóxicos\n" .
                       "• Traumatismos\n" .
                       "• Envejecimiento\n\n" .
                       "¿Quieres información específica sobre alguna causa?";
            
            case 'lengua_señas_colombiana':
                return "🤟 **Lengua de Señas Colombiana (LSC)**\n\n" .
                       "• **Reconocida oficialmente** por las leyes 324/1996 y 982/2005\n" .
                       "• **Usuarios:** Aproximadamente 450,000 personas en Colombia\n" .
                       "• **Características:** Lengua visual-espacial completa con gramática propia\n\n" .
                       "**Componentes de las señas:**\n" .
                       "• Configuración de mano\n" .
                       "• Ubicación en el cuerpo\n" .
                       "• Movimiento\n" .
                       "• Orientación de palmas\n" .
                       "• Expresión facial\n\n" .
                       "¿Te interesa aprender más sobre algún aspecto específico de la LSC?";
            
            case 'cultura_sorda':
                return "👥 **Cultura Sorda**\n\n" .
                       $data['definicion'] . "\n\n" .
                       "**Valores principales:**\n" .
                       "• Comunidad y apoyo mutuo\n" .
                       "• Orgullo por la lengua de señas\n" .
                       "• La sordera como diferencia cultural (no discapacidad)\n" .
                       "• Preferencia por comunicación visual\n" .
                       "• Importancia de la educación bilingüe\n\n" .
                       "La comunidad sorda tiene una rica tradición cultural. ¿Quieres saber más?";
            
            case 'tecnologias_apoyo':
                return "🔧 **Tecnologías de Apoyo**\n\n" .
                       "**Audífonos:** Amplifican el sonido (pérdida leve a severa)\n" .
                       "**Implantes cocleares:** Estimulan directamente el nervio auditivo (pérdida severa-profunda)\n" .
                       "**Sistemas FM:** Transmiten sonido directo (ideal para aulas)\n" .
                       "**Apps móviles:** Traductores voz-texto, videollamadas, alertas visuales\n\n" .
                       "Cada tecnología es útil según el grado de pérdida auditiva. ¿Necesitas información específica?";
            
            case 'mitos_realidades':
                return "💡 **Mitos y Realidades sobre la Sordera**\n\n" .
                       "**MITO:** Las personas sordas no pueden conducir\n" .
                       "**REALIDAD:** Son conductores muy seguros gracias a su aguda percepción visual\n\n" .
                       "**MITO:** Todas las personas sordas leen labios\n" .
                       "**REALIDAD:** Solo 30-40% del español es visible en labios\n\n" .
                       "**MITO:** La lengua de señas es universal\n" .
                       "**REALIDAD:** Cada país tiene su propia lengua de señas\n\n" .
                       "¿Hay algún otro mito que hayas escuchado?";
            
            case 'como_comunicarse':
                return "💬 **Cómo comunicarse con personas sordas**\n\n" .
                       "**SÍ hacer:**\n" .
                       "✅ Establecer contacto visual\n" .
                       "✅ Hablar de frente\n" .
                       "✅ Usar gestos naturales\n" .
                       "✅ Ser paciente y respetuoso\n" .
                       "✅ Preguntar su método preferido\n\n" .
                       "**NO hacer:**\n" .
                       "❌ Gritar (no ayuda)\n" .
                       "❌ Cubrir la boca al hablar\n" .
                       "❌ Dar la espalda\n" .
                       "❌ Asumir que leen labios\n\n" .
                       "La clave es el respeto y la paciencia. ¿Tienes alguna situación específica en mente?";
            
            default:
                return $this->generarRespuestaGenerica($data);
        }
    }
    
    private function generarRespuestaGenerica($data) {
        return "📚 Encontré información relevante sobre tu consulta. " .
               "Te recomiendo usar el sistema completo para obtener todos los detalles. " .
               "¿Hay algo específico que te gustaría saber?";
    }
    
    private function buscarEnContenido($mensaje) {
        // Simular búsqueda en la API
        try {
            $postData = json_encode(['buscar' => $mensaje]);
            
            // Aquí podrías implementar una búsqueda real
            // Por ahora, devuelve una respuesta general
            return "🔍 Busqué información sobre '$mensaje'. " .
                   "Puedes preguntarme sobre: causas de sordera, LSC, cultura sorda, " .
                   "tecnologías de apoyo, educación inclusiva, mitos y realidades. " .
                   "¿Qué aspecto específico te interesa más?";
        } catch (Exception $e) {
            return null;
        }
    }
    
    private function obtenerRespuestaFallback($seccion) {
        $fallbacks = [
            'definicion' => 'La sordera es la pérdida total o parcial de la audición. Puede ser congénita o adquirida, y se clasifica en conductiva, neurosensorial o mixta.',
            'causas_principales' => 'Las causas principales incluyen factores genéticos (50-60%), infecciones, exposición a ruido, medicamentos ototóxicos y traumatismos.',
            'lengua_señas_colombiana' => 'La LSC es la lengua oficial de la comunidad sorda colombiana, reconocida por ley. Es una lengua visual-espacial completa con más de 450,000 usuarios.',
            'cultura_sorda' => 'La cultura sorda es una identidad cultural basada en la lengua de señas, valores comunitarios y una perspectiva visual del mundo.',
            'tecnologias_apoyo' => 'Incluyen audífonos, implantes cocleares, sistemas FM y aplicaciones móviles que facilitan la comunicación y accesibilidad.',
            'como_comunicarse' => 'Lo más importante es el contacto visual, hablar de frente, usar gestos naturales y ser paciente y respetuoso.'
        ];
        
        return $fallbacks[$seccion] ?? $this->respuestas_generales['no_entiendo'];
    }
    
    public function obtenerSugerencias() {
        return [
            "¿Qué es la sordera?",
            "¿Cuáles son las causas de la sordera?",
            "¿Qué es la LSC?",
            "¿Cómo comunicarse con personas sordas?",
            "Mitos sobre la sordera",
            "Tecnologías de apoyo auditivo",
            "Cultura de la comunidad sorda"
        ];
    }
}

// Función para integrar con el chat existente
function procesarMensajeBot($mensaje, $usuario_id = null) {
    $chatbot = new ChatbotSordos();
    
    // Si el mensaje contiene ciertas palabras clave, activar el bot
    $palabras_activacion = ['sordera', 'sordo', 'sorda', 'lsc', 'señas', 'cultura sorda', 'audífono', 'implante'];
    $mensaje_lower = strtolower($mensaje);
    
    $activar_bot = false;
    foreach ($palabras_activacion as $palabra) {
        if (strpos($mensaje_lower, $palabra) !== false) {
            $activar_bot = true;
            break;
        }
    }
    
    // También activar si es una pregunta general
    if (strpos($mensaje_lower, '?') !== false || 
        strpos($mensaje_lower, 'qué') !== false ||
        strpos($mensaje_lower, 'cómo') !== false ||
        strpos($mensaje_lower, 'por qué') !== false) {
        $activar_bot = true;
    }
    
    if ($activar_bot) {
        $respuesta = $chatbot->procesarMensaje($mensaje);
        return [
            'es_bot' => true,
            'respuesta' => $respuesta,
            'sugerencias' => $chatbot->obtenerSugerencias()
        ];
    }
    
    return null; // No es una consulta para el bot
}

// Si se llama directamente para pruebas
if (isset($_GET['test'])) {
    header('Content-Type: application/json');
    
    $chatbot = new ChatbotSordos();
    $mensaje = $_GET['mensaje'] ?? '¿Qué es la sordera?';
    
    $respuesta = $chatbot->procesarMensaje($mensaje);
    
    echo json_encode([
        'mensaje' => $mensaje,
        'respuesta' => $respuesta,
        'sugerencias' => $chatbot->obtenerSugerencias()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>