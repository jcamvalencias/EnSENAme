# Sistema de Chat EnSEÑAme - Documentación

## 🎯 Funcionalidades Implementadas

### ✅ Chat en Tiempo Real
- **Ubicación**: `/user/chat.php`
- **API**: `/chat_api.php`
- **Base de datos**: Tabla `tb_mensajes` (se crea automáticamente)

### 🔧 Características Técnicas

#### 1. **Interfaz de Usuario**
- ✅ Lista de usuarios disponibles en sidebar
- ✅ Área de mensajes con scroll automático
- ✅ Campo de entrada con envío por Enter o botón
- ✅ Búsqueda de usuarios en tiempo real
- ✅ Interfaz personalizada con nombre del usuario logueado

#### 2. **Funcionalidades de Chat**
- ✅ Mensajería privada entre usuarios
- ✅ Carga automática de mensajes cada 3 segundos
- ✅ Visualización diferenciada (mensajes enviados vs recibidos)
- ✅ Timestamps en cada mensaje
- ✅ Anti-spam (5 segundos entre mensajes)

#### 3. **Seguridad**
- ✅ Verificación de sesión en API y frontend
- ✅ Sanitización de entradas SQL
- ✅ Verificación de permisos por usuario
- ✅ Creación automática de tabla si no existe

### 🔗 Navegación Integrada
El chat está accesible desde todas las páginas de usuario:
- `/user/index.php` - Dashboard principal
- `/user/producto.php` - Guías LSC
- `/user/servicio.php` - Servicios
- `/user/user-profile.php` - Perfil de usuario

### 📊 Base de Datos

#### Tabla: `tb_mensajes`
```sql
CREATE TABLE `tb_mensajes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `de_usuario` INT NOT NULL,
  `para_usuario` INT NOT NULL,
  `mensaje` TEXT NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_conversacion` (`de_usuario`, `para_usuario`, `fecha`),
  INDEX `idx_usuario_fecha` (`de_usuario`, `fecha`),
  FOREIGN KEY (`de_usuario`) REFERENCES `tb_usuarios`(`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`para_usuario`) REFERENCES `tb_usuarios`(`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
```

### 🚀 API Endpoints

#### `GET /chat_api.php?para={user_id}`
- **Función**: Obtener mensajes entre el usuario actual y el especificado
- **Respuesta**: Array JSON con mensajes ordenados por fecha
- **Ejemplo**: `[{"id":1,"de_usuario":1,"para_usuario":2,"mensaje":"Hola","fecha":"2025-10-23 10:30:00"}]`

#### `POST /chat_api.php`
- **Función**: Enviar nuevo mensaje
- **Parámetros**: 
  - `para` (int): ID del usuario destinatario
  - `mensaje` (string): Contenido del mensaje
- **Respuesta**: `{"success":true}` o `{"success":false,"error":"mensaje"}`

#### `GET /chat_api.php?get_users=1`
- **Función**: Obtener lista de usuarios disponibles
- **Respuesta**: Array con usuarios `[{"ID":1,"p_nombre":"Juan","p_apellido":"Pérez"}]`

### 📱 JavaScript Frontend

#### Funciones Principales:
- `seleccionarUsuario(userId, userName)` - Inicializar chat con usuario
- `cargarMensajes()` - Obtener mensajes del servidor
- `mostrarMensajes(mensajes)` - Renderizar mensajes en UI
- `enviarMensaje(mensaje)` - Enviar mensaje via API

#### Auto-actualización:
- Intervalo de 3 segundos para cargar nuevos mensajes
- Scroll automático al mensaje más reciente
- Limpieza de intervalos al cambiar de usuario

### 🛠️ Correcciones Implementadas

#### 1. **Compatibilidad con Sistema Existente**
- ✅ Mantenidas todas las correcciones previas en interfaces personalizadas
- ✅ Dropdown de perfil funcional en todas las páginas
- ✅ Sistema de navegación consistente
- ✅ Sin conflictos con archivos existentes

#### 2. **Mejoras en Robustez**
- ✅ Creación automática de tabla `tb_mensajes` si no existe
- ✅ Manejo de errores de conexión
- ✅ Validación de sesión en todos los endpoints
- ✅ Escape de caracteres especiales

### 🎨 Interfaz Usuario
- **Tema**: Mantis Bootstrap 5 con adaptaciones EnSEÑAme
- **Iconos**: Tabler Icons (`ti-brand-hipchat` para chat)
- **Responsive**: Compatible con dispositivos móviles
- **Accesibilidad**: Textos descriptivos y navegación por teclado

### 📋 Archivos Creados/Modificados

#### Nuevos:
- `/user/chat.php` - Interfaz principal del chat
- `/base de datos/crear_tabla_mensajes.sql` - Script de creación de tabla

#### Modificados:
- `/chat_api.php` - API mejorada con seguridad
- `/codigo.php` - Funciones robustas con auto-creación de tabla
- `/user/index.php` - Agregado enlace de chat
- `/user/producto.php` - Agregado enlace de chat  
- `/user/servicio.php` - Agregado enlace de chat
- `/user/user-profile.php` - Agregado enlace de chat

### 🔍 Testing
Para probar el sistema:
1. Acceder a `http://localhost/enseñame/enSENAme/EnSENAme/user/chat.php`
2. Iniciar sesión con usuario válido
3. Seleccionar usuario de la lista para comenzar chat
4. Enviar mensajes y verificar recepción

### 📝 Notas Técnicas
- Compatible con PHP 8.2.12 y MariaDB 10.4.32
- Usa mysqli para conexiones de base de datos
- Implementa principios REST en API
- JavaScript vanilla (sin dependencias externas)
- CSS integrado con framework Mantis existente