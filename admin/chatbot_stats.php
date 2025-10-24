<?php
require_once __DIR__ . '/../includes/session.php';

// Verificar si el usuario está logueado y es admin
if (empty($_SESSION['txtdoc'])) {
    header('Location: ../login.php');
    exit();
}

include '../conexion.php';

// Verificar que sea administrador
$doc = mysqli_real_escape_string($conexion, $_SESSION['txtdoc']);
$res = mysqli_query($conexion, "SELECT p_nombre, s_nombre, p_apellido, s_apellido, id_rol FROM tb_usuarios WHERE ID = '$doc' LIMIT 1");
if ($row = mysqli_fetch_assoc($res)) {
    $nombre = $row['p_nombre'];
    $nombre_completo = trim($row['p_nombre'] . ' ' . $row['s_nombre'] . ' ' . $row['p_apellido'] . ' ' . $row['s_apellido']);
    $es_admin = ($row['id_rol'] == 1);
} else {
    header('Location: ../login.php');
    exit();
}

if (!$es_admin) {
    header('Location: ../user/index.php');
    exit();
}

// Obtener estadísticas del chatbot
$stats = [];

// Verificar si existe la tabla de logs
$logs_table_exists = mysqli_query($conexion, "SHOW TABLES LIKE 'tb_chatbot_logs'");
if (mysqli_num_rows($logs_table_exists) > 0) {
    // Total de interacciones
    $total_logs = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_chatbot_logs"))['total'];
    
    // Interacciones por tipo de usuario
    $logs_admin = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM tb_chatbot_logs WHERE es_admin = 1"))['total'];
    $logs_usuarios = $total_logs - $logs_admin;
    
    // Interacciones por día (últimos 7 días)
    $stats_por_dia = mysqli_query($conexion, "
        SELECT DATE(fecha) as dia, COUNT(*) as total 
        FROM tb_chatbot_logs 
        WHERE fecha >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
        GROUP BY DATE(fecha) 
        ORDER BY dia DESC
    ");
    
    // Preguntas más frecuentes
    $preguntas_frecuentes = mysqli_query($conexion, "
        SELECT pregunta, COUNT(*) as veces 
        FROM tb_chatbot_logs 
        GROUP BY pregunta 
        ORDER BY veces DESC 
        LIMIT 10
    ");
    
    // Usuarios más activos
    $usuarios_activos = mysqli_query($conexion, "
        SELECT l.usuario_id, u.p_nombre, u.p_apellido, COUNT(*) as interacciones
        FROM tb_chatbot_logs l
        LEFT JOIN tb_usuarios u ON l.usuario_id = u.ID
        GROUP BY l.usuario_id
        ORDER BY interacciones DESC
        LIMIT 10
    ");
    
    $stats = [
        'total' => $total_logs,
        'admin' => $logs_admin,
        'usuarios' => $logs_usuarios,
        'existe_tabla' => true
    ];
} else {
    $stats = [
        'total' => 0,
        'admin' => 0,
        'usuarios' => 0,
        'existe_tabla' => false
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>EnSEÑAme Admin - Estadísticas del Chatbot</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Estadísticas y análisis del chatbot de EnSEÑAme">
  <meta name="keywords" content="Estadísticas, Chatbot, EnSEÑAme, Administración">
  <meta name="author" content="EnSEÑAme Team">

  <link rel="icon" href="../assets/images/favisena.png" type="image/x-icon"> 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css">
  <link rel="stylesheet" href="../assets/fonts/feather.css">
  <link rel="stylesheet" href="../assets/fonts/fontawesome.css">
  <link rel="stylesheet" href="../assets/fonts/material.css">
  <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link">
  <link rel="stylesheet" href="../assets/css/style-preset.css">
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
          <img src="../assets/images/logo-dark.svg" class="img-fluid logo-lg" alt="logo">
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
            <a href="usuarios.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-users"></i></span>
              <span class="pc-mtext">Usuarios</span>
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
              <li class="pc-item"><a class="pc-link active" href="chatbot_stats.php">Estadísticas Bot</a></li>
            </ul>
          </li>
          <li class="pc-item">
            <a href="gestion.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-settings"></i></span>
              <span class="pc-mtext">Gestión</span>
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
              <span class="badge bg-warning">ADMIN</span>
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
              <div class="dropdown-header">
                <div class="d-flex mb-1">
                  <div class="flex-shrink-0">
                    <img src="../assets/images/user/avatar-1.jpg" alt="user-image" class="user-avtar wid-35">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1"><?php echo htmlspecialchars($nombre_completo); ?></h6>
                    <span>Administrador</span>
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
                <h2 class="mb-0">🤖 Estadísticas del Chatbot</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <?php if (!$stats['existe_tabla']): ?>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body text-center py-5">
              <i class="ti ti-robot f-48 text-muted mb-3"></i>
              <h4>Sin datos disponibles</h4>
              <p class="text-muted mb-4">Aún no hay interacciones registradas con el chatbot. Los datos aparecerán aquí cuando los usuarios comiencen a usar el asistente.</p>
              <a href="chat.php" class="btn btn-primary">
                <i class="ti ti-message-circle me-2"></i>
                Ir al Chat
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php else: ?>
      
      <!-- [ Stats Cards ] start -->
      <div class="row">
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-s bg-light-primary">
                    <i class="ti ti-messages f-20"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-0">Total Interacciones</h6>
                  <h4 class="mb-0"><?php echo number_format($stats['total']); ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-s bg-light-warning">
                    <i class="ti ti-crown f-20"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-0">Consultas Admin</h6>
                  <h4 class="mb-0"><?php echo number_format($stats['admin']); ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-s bg-light-success">
                    <i class="ti ti-users f-20"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-0">Consultas Usuarios</h6>
                  <h4 class="mb-0"><?php echo number_format($stats['usuarios']); ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <div class="avtar avtar-s bg-light-info">
                    <i class="ti ti-percentage f-20"></i>
                  </div>
                </div>
                <div class="flex-grow-1 ms-3">
                  <h6 class="mb-0">% Admin</h6>
                  <h4 class="mb-0"><?php echo $stats['total'] > 0 ? round(($stats['admin'] / $stats['total']) * 100, 1) : 0; ?>%</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- [ Activity Chart ] start -->
      <div class="row">
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header">
              <h5>Actividad de los Últimos 7 Días</h5>
            </div>
            <div class="card-body">
              <?php if (isset($stats_por_dia) && mysqli_num_rows($stats_por_dia) > 0): ?>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Fecha</th>
                      <th>Interacciones</th>
                      <th>Gráfico</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $max_dia = 0;
                    $datos_dias = [];
                    while ($dia = mysqli_fetch_assoc($stats_por_dia)) {
                      $datos_dias[] = $dia;
                      if ($dia['total'] > $max_dia) $max_dia = $dia['total'];
                    }
                    
                    foreach ($datos_dias as $dia): 
                      $porcentaje = $max_dia > 0 ? ($dia['total'] / $max_dia) * 100 : 0;
                    ?>
                    <tr>
                      <td><?php echo date('d/m/Y', strtotime($dia['dia'])); ?></td>
                      <td><strong><?php echo $dia['total']; ?></strong></td>
                      <td>
                        <div class="progress" style="height: 8px;">
                          <div class="progress-bar bg-primary" style="width: <?php echo $porcentaje; ?>%"></div>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <?php else: ?>
              <p class="text-muted text-center py-4">No hay actividad en los últimos 7 días</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4">
          <div class="card">
            <div class="card-header">
              <h5>Usuarios Más Activos</h5>
            </div>
            <div class="card-body">
              <?php if (isset($usuarios_activos) && mysqli_num_rows($usuarios_activos) > 0): ?>
              <div class="list-group list-group-flush">
                <?php while ($usuario = mysqli_fetch_assoc($usuarios_activos)): ?>
                <div class="list-group-item px-0">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                      <div class="avtar avtar-s bg-light-primary">
                        <i class="ti ti-user f-16"></i>
                      </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <h6 class="mb-0"><?php echo htmlspecialchars($usuario['p_nombre'] . ' ' . $usuario['p_apellido']); ?></h6>
                      <small class="text-muted">ID: <?php echo $usuario['usuario_id']; ?></small>
                    </div>
                    <div class="flex-shrink-0">
                      <span class="badge bg-primary"><?php echo $usuario['interacciones']; ?></span>
                    </div>
                  </div>
                </div>
                <?php endwhile; ?>
              </div>
              <?php else: ?>
              <p class="text-muted text-center py-4">No hay datos de usuarios</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- [ Frequent Questions ] start -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h5>Preguntas Más Frecuentes</h5>
            </div>
            <div class="card-body">
              <?php if (isset($preguntas_frecuentes) && mysqli_num_rows($preguntas_frecuentes) > 0): ?>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Pregunta</th>
                      <th>Frecuencia</th>
                      <th>Popularidad</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $max_freq = 0;
                    $preguntas_array = [];
                    while ($pregunta = mysqli_fetch_assoc($preguntas_frecuentes)) {
                      $preguntas_array[] = $pregunta;
                      if ($pregunta['veces'] > $max_freq) $max_freq = $pregunta['veces'];
                    }
                    
                    foreach ($preguntas_array as $pregunta): 
                      $porcentaje = $max_freq > 0 ? ($pregunta['veces'] / $max_freq) * 100 : 0;
                    ?>
                    <tr>
                      <td>
                        <div style="max-width: 400px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                          <?php echo htmlspecialchars($pregunta['pregunta']); ?>
                        </div>
                      </td>
                      <td><strong><?php echo $pregunta['veces']; ?></strong></td>
                      <td style="width: 200px;">
                        <div class="progress" style="height: 8px;">
                          <div class="progress-bar bg-success" style="width: <?php echo $porcentaje; ?>%"></div>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <?php else: ?>
              <p class="text-muted text-center py-4">No hay preguntas registradas</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      
      <?php endif; ?>
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
    // Auto-refresh cada 30 segundos
    setInterval(function() {
      location.reload();
    }, 30000);
  </script>
</body>
</html>