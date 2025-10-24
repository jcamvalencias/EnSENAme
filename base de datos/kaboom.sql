-- ====================================================================
-- BASE DE DATOS COMPLETA ENSENAME - LSC (Lengua de Señas Colombiana)
-- ====================================================================
-- 
-- Plataforma Educativa para la Comunidad Sorda Colombiana
-- Versión: 2.0 - Consolidada
-- Fecha: 24-10-2025
-- 
-- INCLUYE:
-- ✅ Sistema de usuarios con roles
-- ✅ Chat en tiempo real
-- ✅ Chatbot inteligente con logs
-- ✅ Sistema de fotos de perfil
-- ✅ Campos adicionales de perfil usuario
-- ✅ Datos de ejemplo y prueba
-- 
-- INSTRUCCIONES:
-- 1. Crear base de datos 'kaboom' en MySQL/MariaDB
-- 2. Importar este archivo completo
-- 3. ¡Listo para usar!
-- ====================================================================

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2025 a las 03:48:13
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kaboom`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_rol`
--

CREATE TABLE `tbl_rol` (
  `id` int(11) NOT NULL,
  `nombre_rol` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tbl_rol`
--

INSERT INTO `tbl_rol` (`id`, `nombre_rol`) VALUES
(1, 'administrador'),
(2, 'operador'),
(3, 'asesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_chatbot_logs`
--

CREATE TABLE `tb_chatbot_logs` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `mensaje_usuario` text NOT NULL,
  `respuesta_bot` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_respuesta` varchar(50) DEFAULT 'info',
  `origen` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_chatbot_logs`
--

INSERT INTO `tb_chatbot_logs` (`id`, `usuario_id`, `mensaje_usuario`, `respuesta_bot`, `timestamp`, `tipo_respuesta`, `origen`) VALUES
(1, 123456789, '¿Qué es LSC?', 'La Lengua de Señas Colombiana (LSC) es la lengua natural de las personas sordas en Colombia...', '2025-10-24 00:50:25', 'info', 'user'),
(2, 123456789, '¿Cómo puedo aprender señas?', 'Puedes comenzar aprendiendo el alfabeto dactilológico y palabras básicas...', '2025-10-24 00:50:25', 'educativo', 'user'),
(3, 1015189816, 'Estadísticas del sistema', 'Consulta administrativa sobre métricas del chatbot', '2025-10-24 00:50:25', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_mensajes`
--

CREATE TABLE `tb_mensajes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo` enum('usuario','admin') DEFAULT 'usuario',
  `leido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_mensajes`
--

INSERT INTO `tb_mensajes` (`id`, `usuario_id`, `mensaje`, `timestamp`, `tipo`, `leido`) VALUES
(1, 123456789, 'Hola, necesito ayuda con las guías LSC', '2025-10-24 00:50:25', 'usuario', 0),
(2, 1015189816, 'Bienvenido al sistema EnSEÑAme', '2025-10-24 00:50:25', 'admin', 0),
(3, 123456789, 'Gracias por la información', '2025-10-24 00:50:25', 'usuario', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuarios`
-- Incluye todas las columnas necesarias para el sistema completo
--

CREATE TABLE `tb_usuarios` (
  `ID` int(11) NOT NULL,
  `Tipo_Documento` int(1) NOT NULL,
  `p_nombre` tinytext NOT NULL,
  `s_nombre` tinytext NOT NULL,
  `p_apellido` tinytext NOT NULL,
  `s_apellido` tinytext NOT NULL,
  `Clave` varchar(101) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `needs_pw_change` tinyint(1) DEFAULT 0,
  `foto_perfil` varchar(255) DEFAULT NULL COMMENT 'Ruta del archivo de imagen de perfil del usuario',
  `telefono` varchar(20) DEFAULT NULL COMMENT 'Número de teléfono del usuario',
  `region` varchar(100) DEFAULT NULL COMMENT 'Región geográfica del usuario (Bogotá, Medellín, Cali, etc.)',
  `condicion` varchar(100) DEFAULT NULL COMMENT 'Condición auditiva del usuario (sordo, hipoacúsico, oyente, etc.)',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora de registro del usuario',
  `ultima_conexion` timestamp NULL DEFAULT NULL COMMENT 'Fecha y hora de la última conexión del usuario',
  `estado` enum('activo','inactivo','suspendido') DEFAULT 'activo' COMMENT 'Estado del usuario en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tb_usuarios`
-- Incluye datos de ejemplo con todas las columnas
--

INSERT INTO `tb_usuarios` (`ID`, `Tipo_Documento`, `p_nombre`, `s_nombre`, `p_apellido`, `s_apellido`, `Clave`, `id_rol`, `needs_pw_change`, `foto_perfil`, `telefono`, `region`, `condicion`, `fecha_registro`, `ultima_conexion`, `estado`) VALUES
(11111111, 2, 'Admin', 'Abuse', 'Sistema', 'Principal', '1@15189816Pepe', 1, 0, NULL, '3001234567', 'Bogotá', 'oyente', '2025-10-01 10:00:00', '2025-10-24 08:30:00', 'activo'),
(123456789, 2, 'Morita', 'Moringa', 'Chica', 'Tapasco', '$argon2id$v=19$m=131072,t=4,p=2$YktsTE93T3pBb2dYaC9WdQ$PbqWYS3KXSnax8yPsos22q7XRyotCoHooVClUbZvLAI', 1, 0, NULL, '3009876543', 'Medellín', 'sordo', '2025-10-15 14:20:00', '2025-10-24 09:15:00', 'activo'),
(1015189816, 1, 'Jeremy', '', 'Chica', 'Tapasco', '$argon2id$v=19$m=131072,t=4,p=2$Znd1Qmo5MVRPS3pyUllobA$lnmz/WxHUJamR6rQymjGe5ku8DzKC2zSDPxGi9lQsHk', 1, 0, NULL, '3205551234', 'Cali', 'hipoacúsico', '2025-09-20 16:45:00', '2025-10-24 07:00:00', 'activo'),
(1015196766, 1, 'Jacob', 'Rafael', 'Rojas', 'Chica', '$2y$10$yB21eoCgcAWmZFTaPbDZ.OD9gUk8KwKzncInlLq0/1oVcnNcuEc6e', 2, 1, NULL, '3157890123', 'Barranquilla', 'sordo', '2025-10-10 11:30:00', '2025-10-23 18:45:00', 'activo'),
(1017136002, 2, 'Ana', 'Milena', 'Chica', 'Tapasco', '$argon2id$v=19$m=131072,t=4,p=2$a1U3Slcub0pRWEpianJRRg$EsnBTeMvWu5CdSEqFrmBuLTADum+dTjRUAbfAp8dmNo', 2, 0, NULL, '3116547890', 'Bucaramanga', 'oyente', '2025-10-05 09:15:00', '2025-10-24 06:30:00', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_rol`
--
ALTER TABLE `tbl_rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tb_chatbot_logs`
--
ALTER TABLE `tb_chatbot_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `timestamp` (`timestamp`),
  ADD KEY `tipo_respuesta` (`tipo_respuesta`),
  ADD KEY `origen` (`origen`);

--
-- Indices de la tabla `tb_mensajes`
--
ALTER TABLE `tb_mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `timestamp` (`timestamp`),
  ADD KEY `tipo` (`tipo`);

--
-- Indices de la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_chatbot_logs`
--
ALTER TABLE `tb_chatbot_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_mensajes`
--
ALTER TABLE `tb_mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_mensajes`
--
ALTER TABLE `tb_mensajes`
  ADD CONSTRAINT `tb_mensajes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuarios` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD CONSTRAINT `tb_usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `tbl_rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- ====================================================================
-- INFORMACIÓN ADICIONAL
-- ====================================================================

-- USUARIOS DE PRUEBA:
-- Admin: 1015189816 (Jeremy Chica Tapasco)
-- Usuario: 123456789 (Morita Moringa Chica Tapasco)
-- Operador: 1015196766 (Jacob Rafael Rojas Chica)

-- CARACTERÍSTICAS INCLUIDAS:
-- ✅ Sistema completo de usuarios con roles
-- ✅ Chat en tiempo real con historial
-- ✅ Chatbot inteligente con logs y estadísticas
-- ✅ Sistema de fotos de perfil
-- ✅ Campos adicionales: teléfono, región, condición auditiva
-- ✅ Control de estado de usuarios
-- ✅ Timestamps de registro y última conexión
-- ✅ Datos de ejemplo listos para usar

-- PRÓXIMOS PASOS:
-- 1. Verificar que la base de datos se importó correctamente
-- 2. Configurar conexión en conexion.php
-- 3. Crear directorio uploads/profile_images/ con permisos 755
-- 4. Probar login con usuarios de ejemplo
-- 5. ¡Disfrutar del sistema EnSEÑAme!

-- SOPORTE LSC:
-- Esta base de datos soporta variaciones regionales de LSC:
-- - Bogotá y Cundinamarca
-- - Antioquia (Medellín)  
-- - Valle del Cauca (Cali)
-- - Costa Atlántica (Barranquilla)
-- - Santander (Bucaramanga)

-- Desarrollado con ❤️ para la comunidad sorda colombiana
-- ENSENA-1101-EQ-9-2025

COMMIT;
