<?php
require_once __DIR__ . '/../includes/session.php';

// Verificar si el usuario está logueado
if (empty($_SESSION['txtdoc'])) {
    header('Location: ../login.php');
    exit();
}

include '../conexion.php';

// Obtener información del usuario desde la base de datos
$doc = mysqli_real_escape_string($conexion, $_SESSION['txtdoc']);
$res = mysqli_query($conexion, "SELECT p_nombre, s_nombre, p_apellido, s_apellido, id_rol FROM tb_usuarios WHERE ID = '$doc' LIMIT 1");
if ($row = mysqli_fetch_assoc($res)) {
    $nombre = $row['p_nombre'];
    $nombre_completo = trim($row['p_nombre'] . ' ' . $row['s_nombre'] . ' ' . $row['p_apellido'] . ' ' . $row['s_apellido']);
    $es_admin = ($row['id_rol'] == 1);
} else {
    $nombre = 'Usuario';
    $nombre_completo = 'Usuario';
    $es_admin = false;
}

if (empty($nombre)) {
    $nombre = 'Usuario';
}
if (empty($nombre_completo)) {
    $nombre_completo = 'Usuario';
}

// Función para obtener lista de usuarios para el chat
function obtenerUsuarios() {
    global $conexion;
    $usuarios = array();
    
    $query = "SELECT ID, p_nombre, s_nombre, p_apellido, s_apellido, id_rol 
              FROM tb_usuarios 
              WHERE id_rol IN (1, 2, 3) 
              ORDER BY p_nombre ASC";
    
    $result = mysqli_query($conexion, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $usuarios[] = $row;
        }
    }
    
    return $usuarios;
}

// Obtener lista de usuarios para el chat
$usuarios = obtenerUsuarios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>EnSEÑAme Admin - Chat</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Chat administrativo de EnSEÑAme - Comunicación y soporte del sistema.">
  <meta name="keywords" content="Chat, EnSEÑAme, Administración, Soporte, LSC">
  <meta name="author" content="EnSEÑAme Team">

  <link rel="icon" href="../assets/images/favisena.png" type="image/x-icon"> 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css">
  <link rel="stylesheet" href="../assets/fonts/feather.css">
  <link rel="stylesheet" href="../assets/fonts/fontawesome.css">
  <link rel="stylesheet" href="../assets/fonts/material.css">
  <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link">
  <link rel="stylesheet" href="../assets/css/style-preset.css">
  
  <style>
    .chatbot-item {
      background: linear-gradient(135deg, #e8f5e8 0%, #f0f8f0 100%);
      border-left: 4px solid #4CAF50;
    }
    
    .chatbot-item:hover {
      background: linear-gradient(135deg, #dff0df 0%, #e8f5e8 100%);
      transform: translateX(2px);
      transition: all 0.3s ease;
    }
    
    .admin-chat-item {
      background: linear-gradient(135deg, #e3f2fd 0%, #f0f7ff 100%);
      border-left: 4px solid #2196F3;
    }
    
    .admin-chat-item:hover {
      background: linear-gradient(135deg, #d1e7dd 0%, #e3f2fd 100%);
      transform: translateX(2px);
      transition: all 0.3s ease;
    }
    
    .sugerencia-btn {
      font-size: 0.8rem;
      padding: 0.25rem 0.5rem;
      margin: 0.1rem;
      transition: all 0.2s ease;
    }
    
    .sugerencia-btn:hover {
      background-color: #4CAF50;
      border-color: #4CAF50;
      color: white;
      transform: scale(1.05);
    }
    
    .message-in .msg-content {
      background-color: #f8f9fa;
      border: 1px solid #e9ecef;
      border-radius: 15px;
      padding: 10px 15px;
    }
    
    .message-out .msg-content {
      background-color: #4CAF50;
      color: white;
      border-radius: 15px;
      padding: 10px 15px;
      margin-left: auto;
      max-width: fit-content;
    }
    
    .chat-avtar img[src*="avatar-10"] {
      border: 2px solid #4CAF50 !important;
      box-shadow: 0 0 10px rgba(76, 175, 80, 0.3);
    }
    
    .chat-message {
      background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
    }
    
    .typing-indicator {
      display: none;
      padding: 10px;
      font-style: italic;
      color: #6c757d;
    }
    
    .typing-indicator .dots {
      display: inline-block;
      width: 20px;
    }
    
    .typing-indicator .dots::after {
      content: '...';
      animation: typing 1.5s infinite;
    }
    
    @keyframes typing {
      0%, 60% { content: ''; }
      20% { content: '.'; }
      40% { content: '..'; }
      60% { content: '...'; }
    }
    
    .admin-badge {
      background: linear-gradient(45deg, #FF9800, #F57C00);
      color: white;
      font-size: 0.7rem;
      padding: 2px 6px;
      border-radius: 10px;
      margin-left: 5px;
    }
    
    .user-count-badge {
      background: linear-gradient(45deg, #4CAF50, #45a049);
      color: white;
    }
  </style>
</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <!-- [ Sidebar Menu ] start -->
  <nav class="pc-sidebar">
    <div class="navbar-wrapper">
      <div class="m-header">
        <a href="dashboard/index.php" class="b-brand text-primary">
          <img src="../assets/images/logoensenamenobg.png" alt="EnSEÑAme Logo" class="img-fluid" width="175" height="32" />
        </a>
      </div>
      <div class="navbar-content">
        <ul class="pc-navbar">
          <li class="pc-item">
            <a href="dashboard/index.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
              <span class="pc-mtext">Inicio</span>
            </a>
          </li>
          <li class="pc-item pc-hasmenu">
            <a href="javascript:void(0);" class="pc-link">
              <span class="pc-micon"><i class="ti ti-users"></i></span>
              <span class="pc-mtext">Usuarios</span>
              <span class="pc-arrow"><i class="ti ti-chevron-down"></i></span>
            </a>
            <ul class="pc-submenu" style="display: none;">
              <li class="pc-item"><a href="dashboard/crear.php" class="pc-link"><span class="pc-mtext">Agregar usuario</span></a></li>
              <li class="pc-item"><a href="dashboard/usuarios.php" class="pc-link"><span class="pc-mtext">Ver usuarios</span></a></li>
            </ul>
          </li>
          <li class="pc-item">
            <a href="dashboard/producto.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-book"></i></span>
              <span class="pc-mtext">Guías</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="dashboard/asistente_virtual.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-robot"></i></span>
              <span class="pc-mtext">Asistente Virtual</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="chat.php" class="pc-link active">
              <span class="pc-micon"><i class="ti ti-brand-hipchat"></i></span>
              <span class="pc-mtext">Chat</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="dashboard/chatbot_stats.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-chart-line"></i></span>
              <span class="pc-mtext">Estadísticas IA</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="dashboard/servicio.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-headset"></i></span>
              <span class="pc-mtext">Servicios</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="../IA/index.html" class="pc-link" target="_blank">
              <span class="pc-micon"><i class="ti ti-brain"></i></span>
              <span class="pc-mtext">Sistema IA</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- [ Sidebar Menu ] end -->

  <!-- [ Header Topbar ] start -->
  <header class="pc-header">
    <div class="header-wrapper">
      <div class="me-auto pc-mob-drp">
        <ul class="list-unstyled">
          <li class="pc-h-item pc-sidebar-collapse">
            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
          <li class="pc-h-item pc-sidebar-popup">
            <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
        </ul>
      </div>
      
      <div class="ms-auto">
        <ul class="list-unstyled">
          <li class="dropdown pc-h-item header-user-profile">
            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
              <img src="../assets/images/user/avatar-1.jpg" alt="user-image" class="user-avtar">
              <span><?php echo htmlspecialchars($nombre); ?></span>
              <?php if($es_admin): ?>
              <span class="admin-badge">ADMIN</span>
              <?php endif; ?>
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
              <div class="dropdown-header">
                <div class="d-flex mb-1">
                  <div class="flex-shrink-0">
                    <img src="../assets/images/user/avatar-1.jpg" alt="user-image" class="user-avtar wid-35">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1"><?php echo htmlspecialchars($nombre_completo); ?></h6>
                    <span><?php echo $es_admin ? 'Administrador' : 'Usuario'; ?></span>
                  </div>
                </div>
              </div>
              <div class="dropdown-divider"></div>
              <a href="index.php" class="dropdown-item">
                <i class="ti ti-dashboard"></i>
                <span>Dashboard</span>
              </a>
              <a href="logout.php" class="dropdown-item">
                <i class="ti ti-power"></i>
                <span>Cerrar Sesión</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </header>
  <!-- [ Header ] end -->

  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Chat Administrativo</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="chat-wrapper">
              <!-- Lista de usuarios -->
              <div class="offcanvas-xxl offcanvas-start chat-offcanvas" tabindex="-1" id="offcanvas_User_list">
                <div class="offcanvas-header">
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas_User_list" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0">
                  <div id="chat-user_list" class="show collapse collapse-horizontal">
                    <div class="chat-user_list">
                      <div class="card-body">
                        <h5 class="mb-4">Usuarios y Asistentes <span class="badge user-count-badge rounded-circle"><?php echo count($usuarios) + 1; ?></span></h5>
                        <div class="form-search">
                          <i class="ti ti-search"></i>
                          <input type="search" class="form-control" id="buscarUsuarios" placeholder="Buscar usuarios">
                        </div>
                      </div>
                      <div class="scroll-block">
                        <div class="card-body py-0">
                          <div class="list-group list-group-flush" id="listaUsuarios">
                            <!-- Bot EnSEÑAme -->
                            <a href="#" class="list-group-item list-group-item-action p-3 usuario-item chatbot-item" data-user-id="chatbot" data-user-name="🤖 Asistente EnSEÑAme">
                              <div class="media align-items-center">
                                <div class="chat-avtar">
                                  <img class="rounded-circle img-fluid wid-40" src="../assets/images/user/avatar-10.jpg" alt="Chatbot" style="background: linear-gradient(45deg, #4CAF50, #45a049); padding: 4px; border: 2px solid #4CAF50;">
                                  <i class="ti ti-robot chat-badge bg-primary"></i>
                                </div>
                                <div class="media-body mx-2">
                                  <h5 class="mb-0">🤖 Asistente EnSEÑAme</h5>
                                  <span class="text-sm text-success">Siempre disponible</span>
                                </div>
                              </div>
                            </a>
                            <!-- Usuarios normales -->
                            <?php foreach($usuarios as $usuario): ?>
                            <?php if($usuario['ID'] != $_SESSION['txtdoc']): // No mostrar el usuario actual ?>
                            <a href="#" class="list-group-item list-group-item-action p-3 usuario-item <?php echo ($es_admin && $usuario['ID'] != $_SESSION['txtdoc']) ? 'admin-chat-item' : ''; ?>" data-user-id="<?php echo $usuario['ID']; ?>" data-user-name="<?php echo htmlspecialchars($usuario['p_nombre'] . ' ' . $usuario['p_apellido']); ?>">
                              <div class="media align-items-center">
                                <div class="chat-avtar">
                                  <img class="rounded-circle img-fluid wid-40" src="../assets/images/user/avatar-2.jpg" alt="User image">
                                  <i class="ti ti-circle-check chat-badge bg-success"></i>
                                </div>
                                <div class="media-body mx-2">
                                  <h5 class="mb-0">
                                    <?php echo htmlspecialchars($usuario['p_nombre'] . ' ' . $usuario['p_apellido']); ?>
                                    <?php if($es_admin): ?>
                                    <small class="text-muted">(Usuario #<?php echo $usuario['ID']; ?>)</small>
                                    <?php endif; ?>
                                  </h5>
                                  <span class="text-sm text-muted">Disponible</span>
                                </div>
                              </div>
                            </a>
                            <?php endif; ?>
                            <?php endforeach; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Área de chat -->
              <div class="chat-content">
                <div class="card-header py-3" id="chat-header" style="display: none;">
                  <div class="d-sm-flex align-items-center">
                    <ul class="list-inline me-auto mb-0">
                      <li class="list-inline-item align-bottom">
                        <a href="#" class="d-xxl-none avtar avtar-s btn-link-secondary" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_User_list">
                          <i class="ti ti-menu-2 f-18"></i>
                        </a>
                        <a href="#" class="d-none d-xxl-inline-flex avtar avtar-s btn-link-secondary" data-bs-toggle="collapse" data-bs-target="#chat-user_list">
                          <i class="ti ti-menu-2 f-18"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <div class="media align-items-center">
                          <div class="chat-avtar">
                            <img class="rounded-circle img-fluid wid-40" src="../assets/images/user/avatar-2.jpg" alt="User image" id="chat-user-avatar">
                            <i class="ti ti-circle-check chat-badge bg-success" id="chat-user-status"></i>
                          </div>
                          <div class="media-body mx-3">
                            <h5 class="mb-0" id="chat-user-name">Selecciona un usuario</h5>
                            <span class="text-sm text-muted" id="chat-user-status-text">En línea</span>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>

                <!-- Área de mensajes -->
                <div class="scroll-block chat-message" id="chat-messages" style="height: 400px; display: none;">
                  <div class="card-body">
                    <div class="text-center py-5">
                      <i class="ti ti-message-circle f-48 text-muted mb-3"></i>
                      <h5>Selecciona un usuario para iniciar la conversación</h5>
                    </div>
                  </div>
                </div>

                <!-- Área de envío -->
                <div class="card-footer py-2" id="chat-input" style="display: none;">
                  <form id="form-enviar-mensaje">
                    <div class="d-flex align-items-end">
                      <div class="flex-grow-1 me-2">
                        <textarea class="form-control border-0 shadow-none px-0" id="mensaje-input" placeholder="Escribe tu mensaje aquí..." rows="2" required></textarea>
                      </div>
                      <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-success" id="btn-lsc" title="Reconocer LSC de la cámara">
                          <i class="ti ti-hand-stop"></i> LSC
                        </button>
                        <button type="submit" class="btn btn-primary">
                          <i class="ti ti-send f-18"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                  <video id="lsc-video" autoplay playsinline style="display:none;"></video>
                  <canvas id="lsc-canvas" style="display:none;"></canvas>
                </div>

                <!-- Pantalla inicial -->
                <div class="card-body text-center" id="pantalla-inicial">
                  <img src="../assets/images/chat-bg.png" alt="Chat" class="img-fluid mb-4" style="max-width: 300px;">
                  <h4>¡Panel de Chat Administrativo!</h4>
                  <p class="text-muted">Selecciona un usuario o el asistente EnSEÑAme para comenzar una conversación.</p>
                  <?php if($es_admin): ?>
                  <p class="text-primary mb-0"><i class="ti ti-crown"></i> <strong>Privilegios de Administrador:</strong> Puedes comunicarte con todos los usuarios del sistema.</p>
                  <?php else: ?>
                  <p class="text-muted mb-0">Comunícate con otros usuarios y obtén ayuda del asistente inteligente.</p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ Main Content ] end -->
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm my-1">
          <p class="m-0">EnSEÑAme &#9829; desarrollado por el Equipo EnSEÑAme</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Required Js -->
  <script src="../assets/js/plugins/popper.min.js"></script>
  <script src="../assets/js/plugins/simplebar.min.js"></script>
  <script src="../assets/js/plugins/bootstrap.min.js"></script>
  <script src="../assets/js/fonts/custom-font.js"></script>
  <script src="../assets/js/pcoded.js"></script>
  <script src="../assets/js/plugins/feather.min.js"></script>

  <script>
    let usuarioActivo = null;
    let intervaloCarga = null;
    let esChatbot = false;
    const esAdmin = <?php echo $es_admin ? 'true' : 'false'; ?>;

    // Funciones del chat
    function seleccionarUsuario(userId, userName) {
      usuarioActivo = userId;
      esChatbot = (userId === 'chatbot');
      
      // Actualizar UI
      document.getElementById('chat-user-name').textContent = userName;
      document.getElementById('pantalla-inicial').style.display = 'none';
      document.getElementById('chat-header').style.display = 'block';
      document.getElementById('chat-messages').style.display = 'block';
      document.getElementById('chat-input').style.display = 'block';
      
      // Actualizar avatar y estado
      if (esChatbot) {
        document.getElementById('chat-user-avatar').src = '../assets/images/user/avatar-10.jpg';
        document.getElementById('chat-user-avatar').style.cssText = 'background: linear-gradient(45deg, #4CAF50, #45a049); padding: 4px; border: 2px solid #4CAF50;';
        document.getElementById('chat-user-status').className = 'ti ti-robot chat-badge bg-primary';
        document.getElementById('chat-user-status-text').textContent = 'Asistente IA';
        mostrarMensajeChatbot();
        if (intervaloCarga) {
          clearInterval(intervaloCarga);
          intervaloCarga = null;
        }
      } else {
        document.getElementById('chat-user-avatar').src = '../assets/images/user/avatar-2.jpg';
        document.getElementById('chat-user-avatar').style.cssText = '';
        document.getElementById('chat-user-status').className = 'ti ti-circle-check chat-badge bg-success';
        document.getElementById('chat-user-status-text').textContent = 'En línea';
        cargarMensajes();
        if (intervaloCarga) {
          clearInterval(intervaloCarga);
        }
        intervaloCarga = setInterval(cargarMensajes, 3000);
      }
    }

    function mostrarMensajeChatbot() {
      const contenedor = document.querySelector('#chat-messages .card-body');
      const bienvenida = esAdmin ? 
        '🤖 ¡Hola Administrador! Soy el asistente de EnSEÑAme. Puedo ayudarte con información sobre sordera, LSC, gestión de usuarios y soporte técnico. ¿En qué te puedo ayudar?' :
        '🤖 ¡Hola! Soy el asistente de EnSEÑAme. Puedo ayudarte con información sobre sordera, LSC y la comunidad sorda. ¿En qué te puedo ayudar?';
      
      contenedor.innerHTML = `
        <div class="message-in">
          <div class="d-flex">
            <div class="flex-shrink-0">
              <div class="chat-avtar">
                <img class="rounded-circle img-fluid wid-40" src="../assets/images/user/avatar-10.jpg" alt="Chatbot" style="background: linear-gradient(45deg, #4CAF50, #45a049); padding: 4px; border: 2px solid #4CAF50;">
              </div>
            </div>
            <div class="flex-grow-1 mx-3">
              <div class="msg-content">
                <p class="mb-0">${bienvenida}</p>
              </div>
              <p class="mb-0 text-muted text-sm">${new Date().toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})}</p>
            </div>
          </div>
        </div>
        <div class="text-center my-3">
          <p class="text-muted mb-2">💡 <strong>Sugerencias:</strong></p>
          <div class="d-flex flex-wrap justify-content-center gap-2">
            <button class="btn btn-outline-primary btn-sm sugerencia-btn" onclick="enviarSugerencia('¿Qué es la sordera?')">¿Qué es la sordera?</button>
            <button class="btn btn-outline-primary btn-sm sugerencia-btn" onclick="enviarSugerencia('¿Qué es la LSC?')">¿Qué es la LSC?</button>
            <button class="btn btn-outline-primary btn-sm sugerencia-btn" onclick="enviarSugerencia('¿Cómo comunicarse con personas sordas?')">Cómo comunicarse</button>
            ${esAdmin ? '<button class="btn btn-outline-warning btn-sm sugerencia-btn" onclick="enviarSugerencia(\'Ayuda administrativa\')">Ayuda Admin</button>' : ''}
          </div>
        </div>
      `;
      
      const scrollArea = document.querySelector('#chat-messages');
      scrollArea.scrollTop = scrollArea.scrollHeight;
    }

    function enviarSugerencia(pregunta) {
      document.getElementById('mensaje-input').value = pregunta;
      document.getElementById('form-enviar-mensaje').dispatchEvent(new Event('submit'));
    }

    function cargarMensajes() {
      if (!usuarioActivo || esChatbot) return;
      
      fetch(`../chat_api.php?para=${usuarioActivo}`)
        .then(response => response.json())
        .then(mensajes => {
          mostrarMensajes(mensajes);
        })
        .catch(error => console.error('Error al cargar mensajes:', error));
    }

    function mostrarMensajes(mensajes) {
      const contenedor = document.querySelector('#chat-messages .card-body');
      contenedor.innerHTML = '';
      
      mensajes.forEach(mensaje => {
        const esMio = mensaje.de_usuario == <?php echo $_SESSION['txtdoc']; ?>;
        const messageDiv = document.createElement('div');
        messageDiv.className = esMio ? 'message-out' : 'message-in';
        
        const fecha = new Date(mensaje.fecha);
        const tiempo = fecha.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'});
        
        const avatarSrc = esMio ? '../assets/images/user/avatar-1.jpg' : '../assets/images/user/avatar-2.jpg';
        
        messageDiv.innerHTML = `
          <div class="d-flex">
            ${esMio ? `
            <div class="flex-shrink-0">
              <div class="msg-content bg-primary">
                <p class="mb-0">${mensaje.mensaje}</p>
              </div>
              <p class="mb-0 text-muted text-sm">${tiempo}</p>
            </div>
            <div class="flex-shrink-0">
              <div class="chat-avtar">
                <img class="rounded-circle img-fluid wid-40" src="${avatarSrc}" alt="User image">
              </div>
            </div>
            ` : `
            <div class="flex-shrink-0">
              <div class="chat-avtar">
                <img class="rounded-circle img-fluid wid-40" src="${avatarSrc}" alt="User image">
              </div>
            </div>
            <div class="flex-grow-1 mx-3">
              <div class="msg-content">
                <p class="mb-0">${mensaje.mensaje}</p>
              </div>
              <p class="mb-0 text-muted text-sm">${tiempo}</p>
            </div>
            `}
          </div>
        `;
        
        contenedor.appendChild(messageDiv);
      });
      
      const scrollArea = document.querySelector('#chat-messages');
      scrollArea.scrollTop = scrollArea.scrollHeight;
    }

    function enviarMensaje(mensaje) {
      if (!usuarioActivo || !mensaje.trim()) return;
      
      if (esChatbot) {
        enviarAChatbot(mensaje);
      } else {
        const formData = new FormData();
        formData.append('para', usuarioActivo);
        formData.append('mensaje', mensaje);
        
        fetch('../chat_api.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            document.getElementById('mensaje-input').value = '';
            cargarMensajes();
          } else {
            alert('Error al enviar mensaje: ' + (data.error || 'Error desconocido'));
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error de conexión al enviar mensaje');
        });
      }
    }

    function enviarAChatbot(mensaje) {
      agregarMensajeUsuario(mensaje);
      document.getElementById('mensaje-input').value = '';
      mostrarIndicadorEscritura();
      
  fetch('../chatbot_api_clean.php?ts=' + Date.now(), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          mensaje: mensaje,
          usuario_id: <?php echo json_encode($_SESSION['txtdoc'] ?? 0); ?>,
          es_admin: esAdmin
        })
      })
      .then(async response => {
        const text = await response.text();
        try { return JSON.parse(text); } catch (e) { console.error('Respuesta no JSON:', text); throw e; }
      })
      .then(data => {
        ocultarIndicadorEscritura();
        if (data.success) {
          agregarMensajeChatbot(data.respuesta, data.sugerencias);
        } else {
          agregarMensajeChatbot('🤖 Lo siento, no pude procesar tu mensaje. ¿Podrías intentarlo de nuevo?');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        ocultarIndicadorEscritura();
        agregarMensajeChatbot('🤖 Error de conexión. Por favor, inténtalo más tarde.');
      });
    }

    function mostrarIndicadorEscritura() {
      const contenedor = document.querySelector('#chat-messages .card-body');
      const indicador = document.createElement('div');
      indicador.id = 'typing-indicator';
      indicador.className = 'typing-indicator message-in mb-3';
      indicador.innerHTML = `
        <div class="d-flex">
          <div class="flex-shrink-0">
            <div class="chat-avtar">
              <img class="rounded-circle img-fluid wid-40" src="../assets/images/user/avatar-10.jpg" alt="Chatbot" style="background: linear-gradient(45deg, #4CAF50, #45a049); padding: 4px; border: 2px solid #4CAF50;">
            </div>
          </div>
          <div class="flex-grow-1 mx-3">
            <div class="msg-content">
              <p class="mb-0">🤖 Escribiendo<span class="dots"></span></p>
            </div>
          </div>
        </div>
      `;
      contenedor.appendChild(indicador);
      
      const scrollArea = document.querySelector('#chat-messages');
      scrollArea.scrollTop = scrollArea.scrollHeight;
    }

    function ocultarIndicadorEscritura() {
      const indicador = document.getElementById('typing-indicator');
      if (indicador) {
        indicador.remove();
      }
    }

    function agregarMensajeUsuario(mensaje) {
      const contenedor = document.querySelector('#chat-messages .card-body');
      const tiempo = new Date().toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'});
      
      const messageDiv = document.createElement('div');
      messageDiv.className = 'message-out mb-3';
      messageDiv.innerHTML = `
        <div class="d-flex">
          <div class="flex-shrink-0">
            <div class="msg-content bg-primary">
              <p class="mb-0">${mensaje}</p>
            </div>
            <p class="mb-0 text-muted text-sm">${tiempo}</p>
          </div>
          <div class="flex-shrink-0">
            <div class="chat-avtar">
              <img class="rounded-circle img-fluid wid-40" src="../assets/images/user/avatar-1.jpg" alt="User image">
            </div>
          </div>
        </div>
      `;
      
      contenedor.appendChild(messageDiv);
      
      const scrollArea = document.querySelector('#chat-messages');
      scrollArea.scrollTop = scrollArea.scrollHeight;
    }

    function agregarMensajeChatbot(respuesta, sugerencias = null) {
      const contenedor = document.querySelector('#chat-messages .card-body');
      const tiempo = new Date().toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'});
      
      const messageDiv = document.createElement('div');
      messageDiv.className = 'message-in mb-3';
      
      let sugerenciasHtml = '';
      if (sugerencias && sugerencias.length > 0) {
        sugerenciasHtml = `
          <div class="mt-2">
            <p class="text-muted mb-1 text-sm">💡 Preguntas sugeridas:</p>
            <div class="d-flex flex-wrap gap-1">
              ${sugerencias.slice(0, 3).map(sugerencia => 
                `<button class="btn btn-outline-primary btn-sm sugerencia-btn" onclick="enviarSugerencia('${sugerencia.replace(/'/g, "\\'")}')">${sugerencia}</button>`
              ).join('')}
            </div>
          </div>
        `;
      }
      
      messageDiv.innerHTML = `
        <div class="d-flex">
          <div class="flex-shrink-0">
            <div class="chat-avtar">
              <img class="rounded-circle img-fluid wid-40" src="../assets/images/user/avatar-10.jpg" alt="Chatbot" style="background: linear-gradient(45deg, #4CAF50, #45a049); padding: 4px; border: 2px solid #4CAF50;">
            </div>
          </div>
          <div class="flex-grow-1 mx-3">
            <div class="msg-content">
              <div class="mb-0">${respuesta.replace(/\n/g, '<br>')}</div>
              ${sugerenciasHtml}
            </div>
            <p class="mb-0 text-muted text-sm">${tiempo}</p>
          </div>
        </div>
      `;
      
      contenedor.appendChild(messageDiv);
      
      const scrollArea = document.querySelector('#chat-messages');
      scrollArea.scrollTop = scrollArea.scrollHeight;
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.usuario-item').forEach(item => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          const userId = this.dataset.userId;
          const userName = this.dataset.userName;
          seleccionarUsuario(userId, userName);
          
          document.querySelectorAll('.usuario-item').forEach(u => u.classList.remove('active'));
          this.classList.add('active');
        });
      });
      
      document.getElementById('form-enviar-mensaje').addEventListener('submit', function(e) {
        e.preventDefault();
        const mensaje = document.getElementById('mensaje-input').value;
        enviarMensaje(mensaje);
      });

      // Botón LSC
      const btnLsc = document.getElementById('btn-lsc');
      if (btnLsc) {
        btnLsc.addEventListener('click', async () => {
          try {
            const texto = await reconocerLSC();
            if (texto) {
              const input = document.getElementById('mensaje-input');
              input.value = (input.value ? input.value + ' ' : '') + texto;
            } else {
              alert('No se pudo reconocer texto a partir de LSC. Intenta de nuevo.');
            }
          } catch (err) {
            console.error(err);
            alert('Error al usar el servicio LSC. ¿Está ejecutándose en http://127.0.0.1:5001?');
          }
        });
      }
      
      document.getElementById('buscarUsuarios').addEventListener('input', function() {
        const filtro = this.value.toLowerCase();
        document.querySelectorAll('.usuario-item').forEach(item => {
          const nombre = item.dataset.userName.toLowerCase();
          item.style.display = nombre.includes(filtro) ? 'block' : 'none';
        });
      });
      
      document.getElementById('mensaje-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
          e.preventDefault();
          document.getElementById('form-enviar-mensaje').dispatchEvent(new Event('submit'));
        }
      });
    });

    window.addEventListener('beforeunload', function() {
      if (intervaloCarga) {
        clearInterval(intervaloCarga);
      }
    });
  </script>

  <script>
    async function reconocerLSC() {
      const video = document.getElementById('lsc-video');
      const canvas = document.getElementById('lsc-canvas');
      if (!video.srcObject) {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
        video.srcObject = stream;
        await new Promise(res => { if (video.readyState >= 2) return res(); video.onloadeddata = () => res(); });
      }
      const w = video.videoWidth || 640;
      const h = video.videoHeight || 480;
      canvas.width = w;
      canvas.height = h;
      const ctx = canvas.getContext('2d');
      ctx.drawImage(video, 0, 0, w, h);
      const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
      const resp = await fetch('http://127.0.0.1:5001/recognize', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ image: dataUrl })
      });
      const json = await resp.json();
      if (json && json.success && json.texto) return json.texto;
      return '';
    }
  </script>

  <script>
    // scroll-block
    var tc = document.querySelectorAll('.scroll-block');
    for (var t = 0; t < tc.length; t++) {
      new SimpleBar(tc[t]);
    }
  </script>
</body>
</html>