<?php
require_once __DIR__ . '/../includes/session.php';

// Verificar si el usuario está logueado
if (empty($_SESSION['txtdoc'])) {
    header('Location: ../login.php');
    exit();
}

include '../conexion.php';
include '../codigo.php';

// Obtener información del usuario desde la base de datos
$doc = mysqli_real_escape_string($conexion, $_SESSION['txtdoc']);
$res = mysqli_query($conexion, "SELECT p_nombre, s_nombre, p_apellido, s_apellido FROM tb_usuarios WHERE ID = '$doc' LIMIT 1");
if ($row = mysqli_fetch_assoc($res)) {
    $nombre = $row['p_nombre'];
    $nombre_completo = trim($row['p_nombre'] . ' ' . $row['s_nombre'] . ' ' . $row['p_apellido'] . ' ' . $row['s_apellido']);
} else {
    $nombre = 'Usuario';
    $nombre_completo = 'Usuario';
}

if (empty($nombre)) {
    $nombre = 'Usuario';
}
if (empty($nombre_completo)) {
    $nombre_completo = 'Usuario';
}

// Obtener lista de usuarios para el chat
$usuarios = obtenerUsuarios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>EnSEÑAme - Chat</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Chat de EnSEÑAme - Comunícate con otros usuarios y recibe ayuda del sistema.">
  <meta name="keywords" content="Chat, EnSEÑAme, Comunicación, LSC, Lenguaje de Señas">
  <meta name="author" content="EnSEÑAme Team">

  <link rel="icon" href="../admin/assets/images/favisena.png" type="image/x-icon"> 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  <link rel="stylesheet" href="../admin/assets/fonts/tabler-icons.min.css">
  <link rel="stylesheet" href="../admin/assets/fonts/feather.css">
  <link rel="stylesheet" href="../admin/assets/fonts/fontawesome.css">
  <link rel="stylesheet" href="../admin/assets/fonts/material.css">
  <link rel="stylesheet" href="../admin/assets/css/style.css" id="main-style-link">
  <link rel="stylesheet" href="../admin/assets/css/style-preset.css">
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
        <a href="index.php" class="b-brand text-primary">
          <img src="../admin/assets/images/logo-dark.svg" class="img-fluid logo-lg" alt="logo">
        </a>
      </div>
      <div class="navbar-content">
        <ul class="pc-navbar">
          <li class="pc-item">
            <a href="index.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
              <span class="pc-mtext">Dashboard</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="producto.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-book"></i></span>
              <span class="pc-mtext">Guías LSC</span>
            </a>
          </li>
          <li class="pc-item pc-hasmenu">
            <a href="#!" class="pc-link">
              <span class="pc-micon"><i class="ti ti-brand-hipchat"></i></span>
              <span class="pc-mtext">Chat</span>
              <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
            </a>
            <ul class="pc-submenu">
              <li class="pc-item"><a class="pc-link" href="chat.php">Mensajería</a></li>
              <li class="pc-item"><a class="pc-link" href="#!">Ayuda</a></li>
            </ul>
          </li>
          <li class="pc-item">
            <a href="servicio.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-headset"></i></span>
              <span class="pc-mtext">Servicios</span>
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
              <img src="../admin/assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
              <span><?php echo htmlspecialchars($nombre); ?></span>
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
              <div class="dropdown-header">
                <div class="d-flex mb-1">
                  <div class="flex-shrink-0">
                    <img src="../admin/assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1"><?php echo htmlspecialchars($nombre_completo); ?></h6>
                    <span>Usuario</span>
                  </div>
                </div>
              </div>
              <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="drp-t1" data-bs-toggle="tab" data-bs-target="#drp-tab-1" type="button" role="tab" aria-controls="drp-tab-1" aria-selected="true">
                    <i class="ti ti-user"></i> Perfil
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="drp-t2" data-bs-toggle="tab" data-bs-target="#drp-tab-2" type="button" role="tab" aria-controls="drp-tab-2" aria-selected="false">
                    <i class="ti ti-settings"></i> Configuración
                  </button>
                </li>
              </ul>
              <div class="tab-content" id="mysrpTabContent">
                <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel" aria-labelledby="drp-t1" tabindex="0">
                  <a href="editarperfil.php" class="dropdown-item">
                    <i class="ti ti-edit-circle"></i>
                    <span>Editar Perfil</span>
                  </a>
                  <a href="user-profile.php" class="dropdown-item">
                    <i class="ti ti-user"></i>
                    <span>Ver Perfil</span>
                  </a>
                  <a href="logout.php" class="dropdown-item">
                    <i class="ti ti-power"></i>
                    <span>Cerrar Sesión</span>
                  </a>
                </div>
                <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2" tabindex="0">
                  <a href="editarperfil.php" class="dropdown-item">
                    <i class="ti ti-user"></i>
                    <span>Configuración de Cuenta</span>
                  </a>
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-help"></i>
                    <span>Soporte</span>
                  </a>
                  <a href="#!" class="dropdown-item">
                    <i class="ti ti-messages"></i>
                    <span>Feedback</span>
                  </a>
                </div>
              </div>
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
                <h2 class="mb-0">Chat de EnSEÑAme</h2>
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
                        <h5 class="mb-4">Usuarios Disponibles <span class="badge bg-secondary rounded-circle"><?php echo count($usuarios); ?></span></h5>
                        <div class="form-search">
                          <i class="ti ti-search"></i>
                          <input type="search" class="form-control" id="buscarUsuarios" placeholder="Buscar usuarios">
                        </div>
                      </div>
                      <div class="scroll-block">
                        <div class="card-body py-0">
                          <div class="list-group list-group-flush" id="listaUsuarios">
                            <?php foreach($usuarios as $usuario): ?>
                            <?php if($usuario['ID'] != $_SESSION['txtdoc']): // No mostrar el usuario actual ?>
                            <a href="#" class="list-group-item list-group-item-action p-3 usuario-item" data-user-id="<?php echo $usuario['ID']; ?>" data-user-name="<?php echo htmlspecialchars($usuario['p_nombre'] . ' ' . $usuario['p_apellido']); ?>">
                              <div class="media align-items-center">
                                <div class="chat-avtar">
                                  <img class="rounded-circle img-fluid wid-40" src="../admin/assets/images/user/avatar-1.jpg" alt="User image">
                                  <i class="ti ti-circle-check chat-badge bg-success"></i>
                                </div>
                                <div class="media-body mx-2">
                                  <h5 class="mb-0"><?php echo htmlspecialchars($usuario['p_nombre'] . ' ' . $usuario['p_apellido']); ?></h5>
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
                            <img class="rounded-circle img-fluid wid-40" src="../admin/assets/images/user/avatar-1.jpg" alt="User image">
                            <i class="ti ti-circle-check chat-badge bg-success"></i>
                          </div>
                          <div class="media-body mx-3">
                            <h5 class="mb-0" id="chat-user-name">Selecciona un usuario</h5>
                            <span class="text-sm text-muted">En línea</span>
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
                      <button type="submit" class="btn btn-primary">
                        <i class="ti ti-send f-18"></i>
                      </button>
                    </div>
                  </form>
                </div>

                <!-- Pantalla inicial -->
                <div class="card-body text-center" id="pantalla-inicial">
                  <img src="../admin/assets/images/chat-bg.png" alt="Chat" class="img-fluid mb-4" style="max-width: 300px;">
                  <h4>¡Bienvenido al Chat de EnSEÑAme!</h4>
                  <p class="text-muted">Selecciona un usuario de la lista para comenzar a chatear.</p>
                  <p class="text-muted mb-0">Puedes comunicarte con otros estudiantes y obtener ayuda cuando lo necesites.</p>
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
  <script src="../admin/assets/js/plugins/popper.min.js"></script>
  <script src="../admin/assets/js/plugins/simplebar.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../admin/assets/js/fonts/custom-font.js"></script>
  <script src="../admin/assets/js/pcoded.js"></script>
  <script src="../admin/assets/js/plugins/feather.min.js"></script>

  <script>
    let usuarioActivo = null;
    let intervaloCarga = null;

    // Funciones del chat
    function seleccionarUsuario(userId, userName) {
      usuarioActivo = userId;
      
      // Actualizar UI
      document.getElementById('chat-user-name').textContent = userName;
      document.getElementById('pantalla-inicial').style.display = 'none';
      document.getElementById('chat-header').style.display = 'block';
      document.getElementById('chat-messages').style.display = 'block';
      document.getElementById('chat-input').style.display = 'block';
      
      // Cargar mensajes
      cargarMensajes();
      
      // Configurar recarga automática
      if (intervaloCarga) {
        clearInterval(intervaloCarga);
      }
      intervaloCarga = setInterval(cargarMensajes, 3000); // Cada 3 segundos
    }

    function cargarMensajes() {
      if (!usuarioActivo) return;
      
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
                <img class="rounded-circle img-fluid wid-40" src="../admin/assets/images/user/avatar-2.jpg" alt="User image">
              </div>
            </div>
            ` : `
            <div class="flex-shrink-0">
              <div class="chat-avtar">
                <img class="rounded-circle img-fluid wid-40" src="../admin/assets/images/user/avatar-1.jpg" alt="User image">
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
      
      // Scroll al final
      const scrollArea = document.querySelector('#chat-messages');
      scrollArea.scrollTop = scrollArea.scrollHeight;
    }

    function enviarMensaje(mensaje) {
      if (!usuarioActivo || !mensaje.trim()) return;
      
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
          cargarMensajes(); // Recargar mensajes
        } else {
          alert('Error al enviar mensaje: ' + (data.error || 'Error desconocido'));
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión al enviar mensaje');
      });
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
      // Selección de usuarios
      document.querySelectorAll('.usuario-item').forEach(item => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          const userId = this.dataset.userId;
          const userName = this.dataset.userName;
          seleccionarUsuario(userId, userName);
          
          // Resaltar usuario activo
          document.querySelectorAll('.usuario-item').forEach(u => u.classList.remove('active'));
          this.classList.add('active');
        });
      });
      
      // Envío de mensajes
      document.getElementById('form-enviar-mensaje').addEventListener('submit', function(e) {
        e.preventDefault();
        const mensaje = document.getElementById('mensaje-input').value;
        enviarMensaje(mensaje);
      });
      
      // Buscar usuarios
      document.getElementById('buscarUsuarios').addEventListener('input', function() {
        const filtro = this.value.toLowerCase();
        document.querySelectorAll('.usuario-item').forEach(item => {
          const nombre = item.dataset.userName.toLowerCase();
          item.style.display = nombre.includes(filtro) ? 'block' : 'none';
        });
      });
      
      // Enter para enviar mensaje
      document.getElementById('mensaje-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
          e.preventDefault();
          document.getElementById('form-enviar-mensaje').dispatchEvent(new Event('submit'));
        }
      });
    });

    // Limpiar intervalo al cerrar
    window.addEventListener('beforeunload', function() {
      if (intervaloCarga) {
        clearInterval(intervaloCarga);
      }
    });
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