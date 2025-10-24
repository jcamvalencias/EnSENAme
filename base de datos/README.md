# 🗄️ Base de Datos - EnSEÑAme

## 📁 Archivos SQL Organizados

### 🔥 Archivo Principal
- **`kaboom.sql`** - ⭐ **BASE DE DATOS COMPLETA**
  - Contiene toda la estructura y datos
  - Incluye: tb_usuarios, tbl_rol, tb_mensajes, tb_chatbot_logs
  - Datos de ejemplo incluidos
  - **USAR ESTE ARCHIVO PARA INSTALACIÓN NUEVA**

### 🔧 Scripts de Mantenimiento

#### Para Instalaciones Existentes:
- **`agregar_columna_foto.sql`** - Agrega columna foto_perfil a tb_usuarios
- **`agregar_columnas_completas.sql`** - Agrega columnas adicionales de perfil

#### Para Verificación:
- **`verificar_bd_completa.sql`** - Script SQL de verificación completa

### 📊 Datos de Entrenamiento
- **`datos_entrenamiento_senas (3).json`** - Datos para IA de reconocimiento

### 🛡️ Seguridad
- **`.htaccess`** - Protección del directorio

## 🚀 Instrucciones de Uso

### ✨ Nueva Instalación
```sql
-- 1. Crear base de datos
CREATE DATABASE kaboom;

-- 2. Importar estructura completa
SOURCE kaboom.sql;
```

### 🔄 Actualizar Instalación Existente
```sql
-- Solo si necesitas agregar la columna de foto de perfil
SOURCE agregar_columna_foto.sql;

-- O para agregar todas las columnas adicionales
SOURCE agregar_columnas_completas.sql;
```

### 🔍 Verificar Estado
```sql
-- Ejecutar script de verificación
SOURCE verificar_bd_completa.sql;
```

## ❌ Archivos Eliminados (Ya incluidos en kaboom.sql)

Los siguientes archivos fueron eliminados porque ya están incluidos en `kaboom.sql`:
- ~~crear_tabla_mensajes.sql~~ ➡️ Incluido en kaboom.sql
- ~~agregar_tablas_chatbot.sql~~ ➡️ Incluido en kaboom.sql  
- ~~insertar_datos_ejemplo.sql~~ ➡️ Incluido en kaboom.sql

## 🗂️ Estructura de la Base de Datos

### Tablas Principales:
```sql
kaboom/
├── 👥 tb_usuarios (usuarios del sistema)
│   ├── ID (PK)
│   ├── p_nombre, s_nombre, p_apellido, s_apellido
│   ├── Clave (password hash)
│   ├── id_rol (FK a tbl_rol)
│   ├── needs_pw_change
│   └── foto_perfil ✨ (nueva)
├── 🔐 tbl_rol (roles del sistema)
│   ├── id (PK)
│   └── nombre_rol (admin, operador, asesor)
├── 💬 tb_mensajes (mensajes del chat)
│   ├── id (PK)
│   ├── usuario_id (FK)
│   ├── mensaje
│   ├── timestamp
│   ├── tipo (usuario/admin)
│   └── leido
└── 🤖 tb_chatbot_logs (logs del chatbot)
    ├── id (PK)
    ├── usuario_id (FK)
    ├── mensaje_usuario
    ├── respuesta_bot
    ├── timestamp
    ├── tipo_respuesta
    └── origen
```

### Relaciones:
- `tb_usuarios.id_rol` → `tbl_rol.id`
- `tb_mensajes.usuario_id` → `tb_usuarios.ID`

## 🔧 Mantenimiento

### Backup Regular:
```bash
mysqldump -u root -p kaboom > backup_kaboom_$(date +%Y%m%d).sql
```

### Optimización:
```sql
OPTIMIZE TABLE tb_usuarios, tb_mensajes, tb_chatbot_logs;
```

---

*📝 Nota: Mantén siempre backups antes de ejecutar scripts de actualización*