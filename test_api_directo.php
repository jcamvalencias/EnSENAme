<?php
// Test directo de la API sin interfaz
header('Content-Type: text/plain; charset=utf-8');

echo "=== TEST DIRECTO CHATBOT API ===\n\n";

// Simular sesión
session_start();
$_SESSION['txtdoc'] = 1017136002;

echo "1. Sesión establecida: " . $_SESSION['txtdoc'] . "\n";

// Preparar datos de prueba
$test_data = json_encode([
    'mensaje' => 'hola',
    'usuario_id' => 1017136002
]);

echo "2. Datos de prueba: $test_data\n\n";

// Hacer petición interna
$url = 'http://localhost/enseñame/enSENAme/EnSENAme/chatbot_api_clean.php';

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => [
            'Content-Type: application/json',
            'Cookie: ' . session_name() . '=' . session_id()
        ],
        'content' => $test_data
    ]
]);

echo "3. Haciendo petición a: $url\n";
echo "4. Contexto preparado\n\n";

$response = file_get_contents($url, false, $context);

echo "5. RESPUESTA CRUDA:\n";
echo "---INICIO---\n";
echo $response;
echo "\n---FIN---\n\n";

echo "6. ANÁLISIS:\n";
echo "- Longitud: " . strlen($response) . " caracteres\n";
echo "- Primer caracter: '" . (strlen($response) > 0 ? $response[0] : 'VACIO') . "'\n";
echo "- Es JSON válido: " . (json_decode($response) !== null ? 'SÍ' : 'NO') . "\n";

if (json_decode($response) === null) {
    echo "- Error JSON: " . json_last_error_msg() . "\n";
    echo "- Primeros 200 caracteres:\n";
    echo substr($response, 0, 200) . "\n";
}

echo "\n=== FIN TEST ===\n";
?>