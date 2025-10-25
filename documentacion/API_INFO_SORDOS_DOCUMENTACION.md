# API de Información sobre Sordera y Comunidad Sorda

## 📋 Descripción General

Esta API proporciona información educativa completa sobre:
- Definición y tipos de sordera
- Causas congénitas y adquiridas
- Grados de pérdida auditiva
- Cultura sorda
- Lengua de Señas Colombiana (LSC)
- Tecnologías de apoyo
- Inclusión educativa
- Mitos y realidades
- Datos estadísticos
- Consejos de comunicación

## 🔗 Endpoints

### Archivo API: `info_sordos_api.php`
### Demo: `demo_info_sordos.html`

---

## 📖 Uso de la API

### 1. **Obtener todas las secciones disponibles**
```http
GET /info_sordos_api.php
```

**Respuesta:**
```json
{
    "success": true,
    "message": "API de información sobre sordera y comunidad sorda",
    "secciones_disponibles": [
        "definicion",
        "causas_principales",
        "grados_perdida",
        "cultura_sorda",
        "lengua_señas_colombiana",
        "tecnologias_apoyo",
        "inclusion_educativa",
        "mitos_realidades",
        "datos_estadisticos",
        "como_comunicarse"
    ],
    "ejemplos": [
        "?seccion=definicion",
        "?seccion=causas_principales",
        "?seccion=cultura_sorda",
        "?seccion=lengua_señas_colombiana"
    ]
}
```

### 2. **Obtener información específica por sección**
```http
GET /info_sordos_api.php?seccion={nombre_seccion}
```

**Ejemplo:**
```http
GET /info_sordos_api.php?seccion=definicion
```

### 3. **Búsqueda en contenido**
```http
POST /info_sordos_api.php
Content-Type: application/json

{
    "buscar": "término de búsqueda"
}
```

---

## 📚 Secciones Disponibles

### 1. **definicion**
- ¿Qué es la sordera?
- Tipos: conductiva, neurosensorial, mixta
- Causas por tipo

### 2. **causas_principales**
- **Congénitas**: Genética (50-60%), infecciones maternas (15-20%), complicaciones perinatales (10-15%), malformaciones (5-10%)
- **Adquiridas**: Ruido, infecciones, medicamentos ototóxicos, traumatismos, envejecimiento

### 3. **grados_perdida**
- Normal (0-20 dB)
- Leve (21-40 dB)
- Moderada (41-70 dB)
- Severa (71-90 dB)
- Profunda (91+ dB)

### 4. **cultura_sorda**
- Definición de cultura sorda
- Características y valores
- Identidad cultural positiva

### 5. **lengua_señas_colombiana**
- Reconocimiento legal (Ley 324/1996, Ley 982/2005)
- ~450,000 usuarios
- Componentes: configuración, ubicación, movimiento, orientación, expresión facial
- Importancia educativa

### 6. **tecnologias_apoyo**
- Audífonos
- Implantes cocleares
- Sistemas FM
- Aplicaciones móviles

### 7. **inclusion_educativa**
- Enfoques: bilingüe bicultural, inclusión con apoyo, oralismo
- Adaptaciones necesarias

### 8. **mitos_realidades**
- 5 mitos comunes con sus realidades correspondientes
- Información para desestigmatizar

### 9. **datos_estadisticos**
- Estadísticas mundiales
- Datos específicos de Colombia

### 10. **como_comunicarse**
- Consejos básicos para comunicarse
- Qué NO hacer

---

## 💡 Ejemplos de Uso

### JavaScript Frontend
```javascript
// Obtener información sobre LSC
fetch('info_sordos_api.php?seccion=lengua_señas_colombiana')
    .then(response => response.json())
    .then(data => console.log(data));

// Buscar información
fetch('info_sordos_api.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ buscar: 'genética' })
})
.then(response => response.json())
.then(data => console.log(data));
```

### PHP Backend
```php
// Obtener sección específica
$response = file_get_contents('info_sordos_api.php?seccion=cultura_sorda');
$data = json_decode($response, true);

// Realizar búsqueda
$postData = json_encode(['buscar' => 'implante']);
$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => $postData
    ]
]);
$response = file_get_contents('info_sordos_api.php', false, $context);
$data = json_decode($response, true);
```

### cURL
```bash
# Obtener sección
curl "http://localhost/info_sordos_api.php?seccion=causas_principales"

# Buscar contenido
curl -X POST "http://localhost/info_sordos_api.php" \
     -H "Content-Type: application/json" \
     -d '{"buscar":"LSC"}'
```

---

## 🎯 Características Técnicas

### Headers de Respuesta
- `Content-Type: application/json`
- `Access-Control-Allow-Origin: *` (CORS habilitado)
- `Access-Control-Allow-Methods: GET, POST, OPTIONS`

### Formato de Respuesta
```json
{
    "success": true|false,
    "seccion": "nombre_seccion",
    "data": { ... },
    "error": "mensaje_error" // solo si success: false
}
```

### Métodos HTTP Soportados
- **GET**: Obtener información por sección
- **POST**: Búsqueda en contenido
- **OPTIONS**: Para CORS preflight

### Manejo de Errores
- Sección no encontrada
- Método HTTP no permitido
- Parámetros faltantes en búsqueda

---

## 🌟 Datos Destacados Incluidos

### Estadísticas Importantes
- **Mundial**: +70M personas sordas, +300 lenguas de señas
- **Colombia**: ~450,000 personas con limitación auditiva
- **Genética**: 50-60% de casos congénitos son hereditarios

### Información Educativa Clave
- Componentes técnicos de la LSC
- Diferencias entre tipos de sordera
- Tecnologías de apoyo disponibles
- Enfoques educativos inclusivos
- Desmitificación de creencias erróneas

### Consejos Prácticos
- Cómo comunicarse efectivamente
- Qué evitar al interactuar
- Importancia del contacto visual
- Respeto por métodos de comunicación preferidos

---

## 🚀 Integración en EnSEÑAme

Esta API puede integrarse en:
- Módulos educativos del sistema
- Chat bot para respuestas automáticas
- Sección de recursos informativos
- Material de apoyo para profesores
- Contenido para padres y familiares

### Ejemplo de Integración en Chat
```javascript
// En el chat, detectar preguntas sobre sordera
if (mensaje.includes('qué es sordera') || mensaje.includes('causas')) {
    // Obtener información automáticamente
    fetch('info_sordos_api.php?seccion=definicion')
        .then(response => response.json())
        .then(data => enviarRespuestaAutomatica(data));
}
```

---

## 📱 Demo Interactivo

La página `demo_info_sordos.html` incluye:
- Interfaz visual atractiva
- Búsqueda en tiempo real
- Navegación por secciones
- Formato responsive
- Iconografía apropiada
- Colores del tema EnSEÑAme

### Características del Demo
- **Diseño**: Bootstrap 5 con tema personalizado
- **Interactividad**: JavaScript vanilla
- **Responsivo**: Compatible móvil/desktop
- **Accesible**: Textos claros y navegación intuitiva
- **Visual**: Gradientes y animaciones suaves

---

## 🎨 Personalización

### Colores del Tema
```css
:root {
    --primary-color: #4680ff;
    --secondary-color: #04a9f5;
    --success-color: #2ed8b6;
    --info-color: #40c7e0;
    --warning-color: #ffb400;
    --danger-color: #ff5722;
}
```

### Iconos Utilizados
- `ti-ear-off`: Sordera
- `ti-users`: Comunidad
- `ti-hand-finger`: Lengua de señas
- `ti-school`: Educación
- `ti-device-mobile`: Tecnología

---

## 🔧 Instalación y Configuración

1. Subir `info_sordos_api.php` al servidor web
2. Asegurar permisos de lectura
3. Verificar que PHP esté habilitado
4. Probar endpoints básicos
5. Integrar en aplicación principal

### Verificación de Funcionamiento
```bash
curl "http://tu-dominio.com/info_sordos_api.php"
```

Debería retornar las secciones disponibles.

---

## 📋 Casos de Uso

1. **Educación**: Material de apoyo para clases sobre LSC
2. **Información**: Respuestas automáticas en chatbots
3. **Sensibilización**: Contenido para campañas de concientización
4. **Capacitación**: Recursos para profesores y terapeutas
5. **Investigación**: Base de datos estructurada para estudios

Esta API proporciona una base sólida de conocimiento sobre la sordera y la comunidad sorda, específicamente adaptada para el contexto colombiano y educativo de EnSEÑAme.