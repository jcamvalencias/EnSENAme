-- Insertar datos de ejemplo para las tablas del chatbot
-- Ejecutar DESPUÉS de crear las tablas correctamente

USE kaboom;

-- Insertar algunos registros de ejemplo para pruebas
INSERT INTO `tb_chatbot_logs` (`usuario_id`, `mensaje_usuario`, `respuesta_bot`, `tipo_respuesta`, `origen`) VALUES
(123456789, '¿Qué es LSC?', 'La Lengua de Señas Colombiana (LSC) es la lengua natural de las personas sordas en Colombia...', 'info', 'user'),
(123456789, '¿Cómo puedo aprender señas?', 'Puedes comenzar aprendiendo el alfabeto dactilológico y palabras básicas...', 'educativo', 'user'),
(1015189816, 'Estadísticas del sistema', 'Consulta administrativa sobre métricas del chatbot', 'admin', 'admin');

INSERT INTO `tb_mensajes` (`usuario_id`, `mensaje`, `tipo`) VALUES
(123456789, 'Hola, necesito ayuda con las guías LSC', 'usuario'),
(1015189816, 'Bienvenido al sistema EnSEÑAme', 'admin'),
(123456789, 'Gracias por la información', 'usuario');

-- Verificar que los datos se insertaron correctamente
SELECT 'Datos insertados exitosamente' as status;
SELECT COUNT(*) as total_logs FROM tb_chatbot_logs;
SELECT COUNT(*) as total_mensajes FROM tb_mensajes;