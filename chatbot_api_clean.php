<?php
// API limpia y autocontenida para el chatbot (no depende de archivos externos dañados)
// Logging simple a archivo para depurar conexión
function api_log($msg){
    $ts=date('Y-m-d H:i:s');
    @file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'chatbot_clean_debug.log',"[$ts] ".$msg.PHP_EOL,FILE_APPEND|LOCK_EX);
}
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { api_log('OPTIONS preflight'); http_response_code(204); exit; }

class SimpleChatbot {
    private $pal = [
        'causas_principales' => ['causas','causa','por qué','origen','genética','congénito','hereditario','infecciones','ruido','medicamentos','traumatismo','meningitis','otitis','ototóxicos'],
        'definicion' => ['qué es','definición','concepto','tipos','sordera','pérdida auditiva','hipoacusia','anacusia','deficiencia auditiva'],
        'lengua_senas_colombiana' => ['lsc','lengua de señas','señas','lenguaje de señas','gestos','comunicación visual','señas colombianas'],
        'cultura_sorda' => ['cultura sorda','comunidad sorda','identidad sorda','valores','tradiciones','arte sordo','teatro sordo'],
        'tecnologias_apoyo' => ['audífonos','implante coclear','tecnología','dispositivos','apps','aplicaciones','ayudas técnicas','sistemas fm']
    ];
    private $resp = [
        'causas_principales' => "📊 Principales causas de sordera:\n\n🧬 Congénitas: Genéticas (50-60%), infecciones maternas (15-20%), complicaciones perinatales (10-15%).\n\n⚡ Adquiridas: Ruido intenso, infecciones (meningitis/otitis crónica), fármacos ototóxicos, traumatismos, envejecimiento (presbiacusia).\n\n¿Quieres detalles de alguna causa?",
        'definicion' => "🔍 La sordera es la pérdida total o parcial de la audición. Tipos por intensidad: leve (20-40 dB), moderada (40-70), severa (70-90), profunda (90+). Por localización: conductiva, neurosensorial y mixta.",
        'lengua_senas_colombiana' => "🤟 Lengua de Señas Colombiana (LSC): reconocida por leyes 324/1996 y 982/2005. Lengua visual-espacial con gramática propia. Dónde aprender: INSOR, FENASCOL, universidades, comunidades locales.",
        'cultura_sorda' => "🎭 Cultura sorda: identidad visual, lengua de señas como base, valores comunitarios, arte y teatro en señas. Organizaciones: FENASCOL y asociaciones regionales.",
        'tecnologias_apoyo' => "🔧 Tecnologías de apoyo: audífonos (BTE, ITE, ITC, CIC), implantes cocleares, apps de transcripción, videollamadas LSC, alertas visuales."
    ];
    public function procesar($m){
        $m = trim((string)$m);
        if ($m==='') return $this->fallback();
        $sec = $this->det($m);
        return $sec && isset($this->resp[$sec]) ? $this->resp[$sec] : $this->fallback();
    }
    public function sugerencias(){return ["¿Qué es la sordera?","¿Cuáles son las causas de la sordera?","¿Qué es la LSC?","¿Cómo comunicarse con personas sordas?","Tecnologías de apoyo auditivo"];}
    private function det($m){$m=mb_strtolower($m,'UTF-8');$best=null;$bestS=0;foreach($this->pal as $s=>$ps){$sc=0;foreach($ps as $p){if(mb_strpos($m,mb_strtolower($p,'UTF-8'))!==false)$sc+=mb_strlen($p,'UTF-8');}if($sc>$bestS){$bestS=$sc;$best=$s;}}return $best;}
    private function fallback(){return "No estoy seguro de entender tu pregunta. Puedo ayudarte con: causas de sordera, LSC, cultura sorda, tecnologías de apoyo y educación inclusiva. ¿Podrías ser más específico?";}
}

try {
    api_log('Nueva solicitud: '.$_SERVER['REQUEST_METHOD'].' IP '.($_SERVER['REMOTE_ADDR']??'unknown'));
    $raw = file_get_contents('php://input');
    api_log('Body: '.substr($raw,0,200));
    $data = $raw ? json_decode($raw, true) : null;
    $mensaje = $data['mensaje'] ?? ($_POST['mensaje'] ?? '');
    api_log('Mensaje: '.(is_string($mensaje)?$mensaje:json_encode($mensaje)));
    $bot = new SimpleChatbot();
    $respuesta = $bot->procesar($mensaje);
    $payload = [
        'success' => true,
        'respuesta' => $respuesta,
        'sugerencias' => $bot->sugerencias(),
        'timestamp' => date('Y-m-d H:i:s')
    ];
    api_log('OK respuesta corta: '.substr($respuesta,0,80));
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    api_log('ERROR: '.$e->getMessage());
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>'Error interno']);
}
