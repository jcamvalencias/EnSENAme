-- Script para agregar las tablas faltantes a la base de datos kaboom
-- Ejecutar este SQL en phpMyAdmin o MySQL

USE kaboom;

-- Eliminar tablas si existen (para recrearlas correctamente)
DROP TABLE IF EXISTS `tb_chatbot_logs`;
DROP TABLE IF EXISTS `tb_mensajes`;

-- Tabla para logs del chatbot (estadísticas)
CREATE TABLE `tb_chatbot_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `mensaje_usuario` text NOT NULL,
  `respuesta_bot` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_respuesta` varchar(50) DEFAULT 'info',
  `origen` varchar(20) DEFAULT 'user',
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `timestamp` (`timestamp`),
  KEY `tipo_respuesta` (`tipo_respuesta`),
  KEY `origen` (`origen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Tabla para mensajes del chat
CREATE TABLE `tb_mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo` enum('usuario','admin') DEFAULT 'usuario',
  `leido` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `timestamp` (`timestamp`),
  KEY `tipo` (`tipo`),
  FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuarios` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Insertar algunos registros de ejemplo para pruebas
INSERT INTO `tb_chatbot_logs` (`usuario_id`, `mensaje_usuario`, `respuesta_bot`, `tipo_respuesta`, `origen`) VALUES
(123456789, '¿Qué es LSC?', 'La Lengua de Señas Colombiana (LSC) es la lengua natural de las personas sordas en Colombia...', 'info', 'user'),
(123456789, '¿Cómo puedo aprender señas?', 'Puedes comenzar aprendiendo el alfabeto dactilológico y palabras básicas...', 'educativo', 'user'),
(1015189816, 'Estadísticas del sistema', 'Consulta administrativa sobre métricas del chatbot', 'admin', 'admin');

INSERT INTO `tb_mensajes` (`usuario_id`, `mensaje`, `tipo`) VALUES
(123456789, 'Hola, necesito ayuda con las guías LSC', 'usuario'),
(1015189816, 'Bienvenido al sistema EnSEÑAme', 'admin'),
(123456789, 'Gracias por la información', 'usuario');

-- Verificar que las tablas se crearon correctamente
SELECT 'Tablas creadas exitosamente' as status;
SHOW TABLES;