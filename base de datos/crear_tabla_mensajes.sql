-- Script para crear la tabla de mensajes del chat
-- Ejecutar este SQL en phpMyAdmin o consola MySQL

-- Verificar si la tabla ya existe y crearla si no existe
CREATE TABLE IF NOT EXISTS `tb_mensajes` (
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

-- Agregar algunos mensajes de ejemplo (opcional)
-- INSERT INTO `tb_mensajes` (`de_usuario`, `para_usuario`, `mensaje`, `fecha`) VALUES
-- (1, 2, '¡Hola! ¿Cómo estás?', NOW()),
-- (2, 1, 'Todo bien, gracias. ¿Y tú?', NOW());