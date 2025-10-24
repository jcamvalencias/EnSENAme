# 🗄️ Base de Datos EnSEÑAme

Esta carpeta contiene los archivos de la base de datos del sistema EnSEÑAme.

## 🎯 Archivo Principal

### `kaboom.sql` ⭐ **USAR ESTE ARCHIVO**
**Base de datos completa y consolidada** - Contiene todo lo necesario:

- ✅ **Tablas completas**: usuarios, roles, chat, chatbot
- ✅ **Sistema de fotos**: columna foto_perfil incluida
- ✅ **Campos adicionales**: teléfono, región, condición auditiva
- ✅ **Datos de ejemplo**: usuarios listos para probar
- ✅ **Relaciones configuradas**: claves foráneas establecidas
- ✅ **Comentarios documentados**: cada campo explicado

## 🚀 Instalación Rápida

1. **Crear base de datos en phpMyAdmin:**
   ```sql
   CREATE DATABASE kaboom CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
   ```

2. **Importar archivo completo:**
   - Seleccionar base de datos `kaboom`
   - Ir a "Importar"
   - Seleccionar `kaboom.sql`
   - Ejecutar

3. **¡Listo!** Base de datos completa instalada

## 👤 Usuarios de Prueba

| Usuario     | ID         | Rol           | Contraseña Hasheada |
|-------------|------------|---------------|---------------------|
| Jeremy      | 1015189816 | Administrador | [Ver kaboom.sql]    |
| Morita      | 123456789  | Administrador | [Ver kaboom.sql]    |
| Jacob       | 1015196766 | Operador      | [Ver kaboom.sql]    |

## 📊 Estructura de Tablas

### `tb_usuarios` - Usuarios del Sistema
- `ID` - Identificación única
- `Tipo_Documento` - Tipo de documento
- `p_nombre`, `s_nombre` - Nombres
- `p_apellido`, `s_apellido` - Apellidos
- `Clave` - Contraseña hasheada
- `id_rol` - Rol del usuario
- `needs_pw_change` - Requiere cambio de contraseña
- **`foto_perfil`** - Foto de perfil ✨
- **`telefono`** - Número de teléfono ✨
- **`region`** - Región geográfica ✨
- **`condicion`** - Condición auditiva ✨
- **`fecha_registro`** - Fecha de registro ✨
- **`ultima_conexion`** - Última conexión ✨
- **`estado`** - Estado del usuario ✨

### `tbl_rol` - Roles del Sistema
- `id` - ID del rol
- `nombre_rol` - Nombre (administrador, operador, asesor)

### `tb_mensajes` - Chat del Sistema
- `id` - ID del mensaje
- `usuario_id` - Usuario que envía
- `mensaje` - Contenido del mensaje
- `timestamp` - Fecha y hora
- `tipo` - usuario/admin
- `leido` - Estado de lectura

### `tb_chatbot_logs` - Logs del Chatbot
- `id` - ID del log
- `usuario_id` - Usuario que consulta
- `mensaje_usuario` - Pregunta del usuario
- `respuesta_bot` - Respuesta del bot
- `timestamp` - Fecha y hora
- `tipo_respuesta` - Categoría de respuesta
- `origen` - Origen de la consulta

## 🛠️ Archivos de Utilidad

### `verificar_bd_completa.sql`
Script SQL para verificar que la estructura esté completa.

### `datos_entrenamiento_senas (3).json`
Datos de entrenamiento para el sistema de IA/reconocimiento de señas.

## ⚠️ Archivos Eliminados

Los siguientes archivos fueron **consolidados en kaboom.sql**:
- ~~agregar_columna_foto.sql~~ (ya incluido)
- ~~agregar_columnas_completas.sql~~ (ya incluido)
- ~~crear_tabla_mensajes.sql~~ (ya incluido)
- ~~agregar_tablas_chatbot.sql~~ (ya incluido)
- ~~insertar_datos_ejemplo.sql~~ (ya incluido)

## 🔒 Seguridad

- Contraseñas hasheadas con Argon2 y bcrypt
- Validación de tipos de datos
- Claves foráneas para integridad referencial
- Comentarios para documentación

## 📝 Notas Importantes

1. **Usar solo `kaboom.sql`** - Contiene todo lo necesario
2. **Charset UTF8MB4** - Soporte completo para caracteres especiales
3. **Collation Spanish** - Ordenamiento correcto para español
4. **Timestamps automáticos** - Registro de fechas automático

---

**🎯 Para nuevas instalaciones:** Solo importar `kaboom.sql`
**🔄 Para actualizaciones:** Consultar documentación en `docs/`

*Desarrollado para la comunidad sorda colombiana - EnSEÑAme 2025*