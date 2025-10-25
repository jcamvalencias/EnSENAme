# 🤟 EnSEÑAme - Plataforma Educativa LSC

**Sistema de Gestión Educativa para la Lengua de Señas Colombiana (LSC)**

## 📋 Descripción

EnSEÑAme es una plataforma web integral diseñada para la comunidad sorda colombiana, que facilita el aprendizaje, la práctica y la gestión de recursos educativos relacionados con la Lengua de Señas Colombiana (LSC).

## 🚀 Características Principales

### 👥 Sistema de Usuarios
- **Roles diferenciados**: Administrador, Operador, Asesor
- **Perfiles personalizables** con fotos de perfil
- **Gestión de contraseñas temporales** para nuevos usuarios
- **Autenticación segura** con hash Argon2

### 💬 Sistema de Chat
- **Chat en tiempo real** entre usuarios
- **Chatbot inteligente** con información sobre LSC
- **Historial de conversaciones**
- **Estadísticas de uso** para administradores

### 🤖 API de Información LSC
- **Base de conocimientos** sobre LSC
- **Información sobre variaciones regionales**
- **Recursos educativos estructurados**
- **Organizaciones y contactos**

### 🎨 Interfaz Unificada
- **Navegación consistente** entre módulos
- **Diseño responsive** con Bootstrap 5
- **Visualizaciones interactivas** con Chart.js
- **Experiencia de usuario optimizada**

## 🛠️ Tecnologías Utilizadas

### Backend
- **PHP 8.2.12** - Lógica del servidor
- **MySQL/MariaDB** - Base de datos
- **Apache 2.4.58** - Servidor web

### Frontend
- **HTML5 & CSS3** - Estructura y estilos
- **Bootstrap 5** - Framework CSS
- **JavaScript** - Interactividad
- **Chart.js** - Gráficos y visualizaciones

### Herramientas
- **XAMPP** - Entorno de desarrollo
- **Git** - Control de versiones
- **VS Code** - Editor de código

## 📁 Estructura del Proyecto

```
EnSENAme/
├── 📂 admin/               # Panel administrativo
│   ├── 📂 dashboard/       # Tablero de control
│   └── 📂 assets/         # Recursos del admin
├── 📂 user/               # Panel de usuario
├── 📂 base de datos/      # Scripts SQL
├── 📂 docs/               # Documentación
│   ├── 📂 api/           # Docs de API
│   ├── 📂 sistema/       # Docs del sistema
│   └── 📂 usuario/       # Docs de usuario
├── 📂 includes/          # Archivos PHP compartidos
├── 📂 uploads/           # Archivos subidos
│   └── 📂 profile_images/ # Fotos de perfil
├── 📂 css/               # Estilos CSS
├── 📂 js/                # Scripts JavaScript
└── 📂 IA/                # Módulo de IA
```

## 🔧 Instalación

### Requisitos Previos
- XAMPP (Apache + MySQL + PHP)
- Git
- Navegador web moderno

### Pasos de Instalación

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/ENSENA-1101-EQ-9-2025/EnSENAme.git
   cd EnSENAme
   ```

2. **Configurar XAMPP:**
   - Colocar el proyecto en `c:\xampp\htdocs\enseñame\enSENAme\EnSENAme\`
   - Iniciar Apache y MySQL

3. **Configurar base de datos:**
   ```sql
   -- En phpMyAdmin, importar:
   base de datos/kaboom.sql
   ```

4. **Configurar conexión:**
   - Editar `conexion.php` con tus credenciales de MySQL

5. **Acceder al sistema:**
   ```
   http://localhost/enseñame/enSENAme/EnSENAme/
   ```

## 👤 Usuarios de Prueba

### Administrador
- **Usuario**: 1015189816
- **Contraseña**: [Ver en base de datos]

### Usuario Regular
- **Usuario**: 123456789
- **Contraseña**: [Ver en base de datos]

## 📚 Documentación

### Sistema
- [Documentación del Chat](docs/sistema/CHAT_DOCUMENTATION.md)
- [Sistema de Contraseñas Temporales](docs/sistema/SISTEMA_PASSWORD_TEMPORAL.md)
- [Problemas Solucionados](docs/sistema/PROBLEMAS_SOLUCIONADOS_PHP.md)
- [Mejoras del Login](docs/sistema/MEJORAS_LOGIN.md)
- [Guía de Despliegue](docs/sistema/GUIA_DESPLIEGUE.md)

### API
- [API de Información LSC](docs/api/API_INFO_SORDOS_DOCUMENTACION.md)

### Usuario
- [Navegación Unificada](docs/usuario/NAVEGACION_UNIFICADA.md)

## 🔒 Seguridad

- **Contraseñas hasheadas** con Argon2
- **Validación de sesiones** en todas las páginas
- **Protección contra SQL injection**
- **Validación de archivos subidos**
- **Protección de directorios** con .htaccess

## 🎯 Características del Sistema

### Sistema de Perfiles
- ✅ Fotos de perfil personalizables
- ✅ Información personal completa
- ✅ Validación de archivos de imagen
- ✅ Gestión segura de uploads

### Chat Inteligente
- ✅ Mensajes en tiempo real
- ✅ Chatbot con IA
- ✅ Historial persistente
- ✅ Estadísticas de uso

### Panel Administrativo
- ✅ Gestión de usuarios
- ✅ Estadísticas del sistema
- ✅ Control de roles
- ✅ Monitoreo de actividad

## 🤝 Contribuir

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/nueva-caracteristica`)
3. Commit tus cambios (`git commit -m 'Agregar nueva característica'`)
4. Push a la rama (`git push origin feature/nueva-caracteristica`)
5. Abrir un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver `LICENSE` para más detalles.

## 👥 Equipo de Desarrollo

**ENSENA-1101-EQ-9-2025**
- Plataforma educativa para la comunidad sorda colombiana
- Enfoque en accesibilidad y usabilidad
- Desarrollo colaborativo y open source

## 📞 Contacto

- **Repositorio**: [GitHub - EnSENAme](https://github.com/ENSENA-1101-EQ-9-2025/EnSENAme)
- **Issues**: Reportar problemas en GitHub Issues
- **Documentación**: Ver carpeta `docs/`

---

**🎯 Misión**: Facilitar el aprendizaje y uso de la Lengua de Señas Colombiana a través de tecnología accesible e innovadora.

**🌟 Visión**: Ser la plataforma líder en educación LSC en Colombia, conectando y empoderando a la comunidad sorda.

---

*Desarrollado con ❤️ para la comunidad sorda colombiana*