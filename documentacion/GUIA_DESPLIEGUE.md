# Guía de Despliegue - Sistema EnSENAme

## 📋 Requisitos del Servidor

### Requisitos Mínimos
- **PHP**: 7.4 o superior (recomendado: PHP 8.0+)
- **MySQL/MariaDB**: 5.7 o superior
- **Apache/Nginx**: Con mod_rewrite habilitado
- **Memoria**: 256MB mínimo
- **Espacio en Disco**: 500MB mínimo

### Extensiones PHP Requeridas
- mysqli
- session
- json
- mbstring
- openssl (para Argon2ID)

## 🚀 Pasos para el Despliegue

### 1. Preparación del Servidor

#### Para cPanel/Hosting Compartido:
1. Sube todos los archivos al directorio `public_html` o la carpeta raíz de tu dominio
2. Asegúrate de que el archivo `.htaccess` se haya subido correctamente

#### Para VPS/Servidor Dedicado:
1. Clona o sube el proyecto al directorio web del servidor
2. Configura el virtual host apuntando al directorio del proyecto
3. Asegúrate de que Apache/Nginx tenga permisos de lectura

### 2. Configuración de Base de Datos

1. **Crear la base de datos**:
   ```sql
   CREATE DATABASE kaboom CHARACTER SET utf8 COLLATE utf8_general_ci;
   ```

2. **Importar el esquema**:
   - Usa el archivo `base de datos/kaboom.sql`
   - Puedes usar phpMyAdmin, MySQL Workbench o línea de comandos:
   ```bash
   mysql -u username -p kaboom < "base de datos/kaboom.sql"
   ```

3. **Crear usuario de base de datos** (recomendado para producción):
   ```sql
   CREATE USER 'ensename_user'@'localhost' IDENTIFIED BY 'password_seguro';
   GRANT ALL PRIVILEGES ON kaboom.* TO 'ensename_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

### 3. Configuración del Sistema

#### Método 1: Variables de Entorno (Recomendado)
Configura las siguientes variables de entorno en tu servidor:

```bash
export DB_HOST="localhost"
export DB_USER="ensename_user"
export DB_PASS="password_seguro"
export DB_NAME="kaboom"
```

#### Método 2: Editar config.php
Si no puedes usar variables de entorno, edita el archivo `config.php`:

```php
// Cambiar esta sección para producción
define('DB_HOST', 'tu_host_de_bd');
define('DB_USER', 'tu_usuario_bd');
define('DB_PASS', 'tu_password_bd');
define('DB_NAME', 'nombre_de_tu_bd');
define('DEBUG_MODE', false); // ¡IMPORTANTE! Siempre false en producción
```

### 4. Configuración de Permisos

Establece los permisos correctos para los directorios:

```bash
# Archivos generales
find . -type f -exec chmod 644 {} \;

# Directorios
find . -type d -exec chmod 755 {} \;

# Archivos PHP ejecutables
chmod 644 *.php

# Archivo de configuración (extra seguridad)
chmod 600 config.php
chmod 600 conexion.php

# Directorio de uploads (si existe)
chmod 755 admin/dashboard/uploads/
chmod 644 admin/dashboard/uploads/*
```

### 5. Configuración de SSL (Recomendado)

1. **Obtener certificado SSL**:
   - Let's Encrypt (gratuito)
   - Certificado del proveedor de hosting
   - Certificado comercial

2. **Configurar redirección HTTPS**:
   - Descomenta las líneas de redirección en `.htaccess`
   - O configura en el panel de control del hosting

### 6. Pruebas Post-Despliegue

#### Verificaciones Básicas:
1. **Acceso a la página principal**: `https://tudominio.com/`
2. **Prueba de login**: Crear usuario de prueba
3. **Verificar rutas**: Todas las páginas cargan correctamente
4. **Revisar logs**: No debe haber errores PHP

#### Verificaciones de Seguridad:
1. **Archivos protegidos**: Intenta acceder a `/config.php` directamente (debe dar error 403)
2. **SQL Injection**: Usar herramientas como SQLMap
3. **XSS**: Verificar formularios de entrada
4. **CSRF**: Verificar tokens en formularios

### 7. Optimizaciones de Producción

#### Rendimiento:
1. **Habilitar cache de PHP** (OPCache)
2. **Optimizar MySQL**:
   ```sql
   OPTIMIZE TABLE tb_usuarios;
   ```
3. **Comprimir archivos estáticos** (ya configurado en .htaccess)

#### Seguridad:
1. **Cambiar credenciales por defecto**
2. **Configurar backups automáticos**
3. **Instalar firewall web (ModSecurity)**
4. **Configurar monitoreo de logs**

### 8. Mantenimiento

#### Backups Regulares:
```bash
# Backup de base de datos
mysqldump -u username -p kaboom > backup_$(date +%Y%m%d).sql

# Backup de archivos
tar -czf ensename_backup_$(date +%Y%m%d).tar.gz /ruta/al/proyecto/
```

#### Actualizaciones:
1. Mantener PHP actualizado
2. Actualizar dependencias
3. Revisar logs regularmente
4. Monitorear rendimiento

## 🔧 Solución de Problemas Comunes

### Error de Conexión a Base de Datos
- Verificar credenciales en `config.php`
- Confirmar que el servicio MySQL esté funcionando
- Revisar permisos del usuario de base de datos

### Páginas en Blanco
- Verificar logs de error de PHP
- Confirmar que `display_errors` esté deshabilitado en producción
- Revisar permisos de archivos

### Problemas de Sesión
- Verificar configuración de sesiones en PHP
- Confirmar que el directorio de sesiones tenga permisos de escritura

### Errores 404
- Verificar que mod_rewrite esté habilitado
- Confirmar que el archivo `.htaccess` esté presente
- Revisar configuración del virtual host

## 📞 Soporte

Para problemas adicionales, verificar:
1. Logs del servidor web
2. Logs de PHP
3. Logs de MySQL
4. Documentación en `/documentacion/`

---

**Última actualización**: Octubre 2025
**Versión**: 1.0.0