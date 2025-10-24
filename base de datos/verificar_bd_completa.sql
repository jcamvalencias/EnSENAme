-- Verificación y comparación de estructura de base de datos
-- Basado en kaboom.sql actual vs estructura esperada

USE kaboom;

-- ===========================================
-- 1. VERIFICACIÓN DE TABLAS PRINCIPALES
-- ===========================================

-- Verificar que existan todas las tablas principales
SELECT 
    CASE 
        WHEN COUNT(*) = 4 THEN '✅ Todas las tablas principales existen'
        ELSE CONCAT('❌ Faltan ', (4 - COUNT(*)), ' tablas principales')
    END AS estado_tablas
FROM information_schema.tables 
WHERE table_schema = 'kaboom' 
    AND table_name IN ('tb_usuarios', 'tbl_rol', 'tb_mensajes', 'tb_chatbot_logs');

-- ===========================================
-- 2. ESTRUCTURA DETALLADA DE tb_usuarios
-- ===========================================

-- Verificar columnas en tb_usuarios según kaboom.sql
SELECT 
    'tb_usuarios' AS tabla,
    column_name,
    data_type,
    is_nullable,
    column_default,
    CASE 
        WHEN column_name IN ('ID', 'Tipo_Documento', 'p_nombre', 's_nombre', 'p_apellido', 's_apellido', 'Clave', 'id_rol', 'needs_pw_change', 'foto_perfil') THEN '✅ Requerida'
        WHEN column_name IN ('telefono', 'region', 'condicion', 'fecha_registro', 'ultima_conexion', 'estado') THEN '⚠️ Adicional'
        ELSE '❓ No documentada'
    END AS status
FROM information_schema.columns 
WHERE table_schema = 'kaboom' AND table_name = 'tb_usuarios'
ORDER BY ordinal_position;

-- ===========================================
-- 3. VERIFICACIÓN DE CLAVES FORÁNEAS
-- ===========================================

-- Verificar relaciones foráneas existentes
SELECT 
    constraint_name,
    table_name,
    column_name,
    referenced_table_name,
    referenced_column_name,
    CASE 
        WHEN constraint_name LIKE '%usuarios_ibfk%' THEN '✅ Correcta'
        WHEN constraint_name LIKE '%mensajes_ibfk%' THEN '✅ Correcta'
        ELSE '⚠️ Revisar'
    END AS estado
FROM information_schema.key_column_usage 
WHERE referenced_table_schema = 'kaboom'
ORDER BY table_name, constraint_name;

-- ===========================================
-- 4. COMPARACIÓN CON ESTRUCTURA ESPERADA
-- ===========================================

-- Verificar columnas que deberían existir según kaboom.sql
SELECT 
    'Verificación de columnas requeridas' AS tipo,
    CASE 
        WHEN (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = 'kaboom' AND table_name = 'tb_usuarios' AND column_name = 'ID') > 0 THEN '✅ ID'
        ELSE '❌ ID'
    END AS ID_status,
    CASE 
        WHEN (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = 'kaboom' AND table_name = 'tb_usuarios' AND column_name = 'foto_perfil') > 0 THEN '✅ foto_perfil'
        ELSE '❌ foto_perfil'
    END AS foto_status,
    CASE 
        WHEN (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = 'kaboom' AND table_name = 'tb_usuarios' AND column_name = 'needs_pw_change') > 0 THEN '✅ needs_pw_change'
        ELSE '❌ needs_pw_change'
    END AS pw_change_status;

-- ===========================================
-- 5. DATOS DE PRUEBA
-- ===========================================

-- Verificar datos existentes
SELECT 
    'Datos existentes' AS categoria,
    (SELECT COUNT(*) FROM tb_usuarios) AS total_usuarios,
    (SELECT COUNT(*) FROM tbl_rol) AS total_roles,
    (SELECT COUNT(*) FROM tb_mensajes) AS total_mensajes,
    (SELECT COUNT(*) FROM tb_chatbot_logs) AS total_logs;

-- ===========================================
-- 6. ÍNDICES Y RENDIMIENTO
-- ===========================================

-- Verificar índices importantes
SELECT 
    table_name,
    index_name,
    column_name,
    CASE 
        WHEN index_name = 'PRIMARY' THEN '🔑 Clave Primaria'
        WHEN non_unique = 0 THEN '🔒 Único'
        ELSE '📊 Índice'
    END AS tipo_indice
FROM information_schema.statistics 
WHERE table_schema = 'kaboom'
ORDER BY table_name, index_name;

-- ===========================================
-- 7. SCRIPT DE CORRECCIÓN SI ES NECESARIO
-- ===========================================

-- Generar scripts de corrección para columnas faltantes
SELECT 
    CONCAT(
        'ALTER TABLE tb_usuarios ADD COLUMN ',
        CASE 
            WHEN NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = 'kaboom' AND table_name = 'tb_usuarios' AND column_name = 'telefono') 
            THEN 'telefono VARCHAR(20) NULL, '
            ELSE ''
        END,
        CASE 
            WHEN NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = 'kaboom' AND table_name = 'tb_usuarios' AND column_name = 'region') 
            THEN 'region VARCHAR(100) NULL, '
            ELSE ''
        END,
        CASE 
            WHEN NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = 'kaboom' AND table_name = 'tb_usuarios' AND column_name = 'condicion') 
            THEN 'condicion VARCHAR(100) NULL;'
            ELSE ''
        END
    ) AS script_correccion
WHERE 
    NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = 'kaboom' AND table_name = 'tb_usuarios' AND column_name = 'telefono')
    OR NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = 'kaboom' AND table_name = 'tb_usuarios' AND column_name = 'region')
    OR NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema = 'kaboom' AND table_name = 'tb_usuarios' AND column_name = 'condicion');

-- ===========================================
-- RESUMEN FINAL
-- ===========================================

SELECT 
    '🎯 RESUMEN DE VERIFICACIÓN' AS titulo,
    CONCAT(
        'Tablas: ', (SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = 'kaboom'), ' | ',
        'Usuarios: ', (SELECT COUNT(*) FROM tb_usuarios), ' | ',
        'Columnas tb_usuarios: ', (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = 'kaboom' AND table_name = 'tb_usuarios')
    ) AS estadisticas,
    CASE 
        WHEN (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = 'kaboom' AND table_name = 'tb_usuarios' AND column_name = 'foto_perfil') > 0 
        THEN '✅ Sistema de fotos listo'
        ELSE '❌ Falta sistema de fotos'
    END AS estado_fotos;