<?php
require_once __DIR__ . '/../includes/session.php';

// Si hay sesión activa, obtener datos del usuario
$nombre = 'Usuario';
if (!empty($_SESSION['txtdoc'])) {
    include '../conexion.php';
    $doc = mysqli_real_escape_string($conexion, $_SESSION['txtdoc']);
    $res = mysqli_query($conexion, "SELECT p_nombre FROM tb_usuarios WHERE ID = '$doc' LIMIT 1");
    if ($row = mysqli_fetch_assoc($res)) {
        $nombre = $row['p_nombre'] ?: 'Usuario';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>EnSEÑAme - Error</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Error en EnSEÑAme - Sistema de aprendizaje de Lengua de Señas Colombiana">
  <meta name="keywords" content="EnSEÑAme, Error, LSC, Lengua de Señas Colombiana">
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

  <!-- [ Main Content ] start -->
  <div class="maintenance-block">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="card error-card">
            <div class="card-body">
              <div class="error-image-block">
                <div class="row justify-content-center">
                  <div class="col-10">
                    <div class="text-center">
                      <i class="ti ti-alert-triangle text-warning" style="font-size: 8rem;"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="text-center">
                <h1 class="mt-4"><b>¡Ups! Algo salió mal</b></h1>
                <p class="mt-2 mb-4 text-sm text-muted">
                  <?php
                  // Mostrar mensaje específico según el parámetro
                  $tipo_error = $_GET['tipo'] ?? 'general';
                  switch($tipo_error) {
                      case 'registro':
                          echo 'Hubo un problema con el registro. Por favor verifica los datos e intenta nuevamente.';
                          break;
                      case 'acceso':
                          echo 'No tienes permisos para acceder a esta página. Inicia sesión para continuar.';
                          break;
                      case 'sesion':
                          echo 'Tu sesión ha expirado. Por favor inicia sesión nuevamente.';
                          break;
                      case 'datos':
                          echo 'Los datos proporcionados no son válidos. Verifica la información e intenta nuevamente.';
                          break;
                      case 'servidor':
                          echo 'Error interno del servidor. Estamos trabajando para solucionarlo.';
                          break;
                      default:
                          echo 'Se ha producido un error inesperado. Por favor intenta nuevamente.';
                          break;
                  }
                  ?>
                </p>
                
                <div class="d-flex justify-content-center gap-3">
                  <button type="button" onclick="window.history.back()" class="btn btn-outline-primary">
                    <i class="ti ti-arrow-left"></i> Volver Atrás
                  </button>
                  
                  <?php if (!empty($_SESSION['txtdoc'])): ?>
                  <button type="button" onclick="window.location.href='index.php'" class="btn btn-primary">
                    <i class="ti ti-home"></i> Ir al Dashboard
                  </button>
                  <?php else: ?>
                  <button type="button" onclick="window.location.href='../login.php'" class="btn btn-primary">
                    <i class="ti ti-login"></i> Iniciar Sesión
                  </button>
                  <?php endif; ?>
                </div>
                
                <?php if (!empty($_SESSION['txtdoc'])): ?>
                <div class="mt-4">
                  <p class="text-muted">
                    <i class="ti ti-user-circle"></i> 
                    Conectado como: <strong><?php echo htmlspecialchars($nombre); ?></strong>
                  </p>
                </div>
                <?php endif; ?>
                
                <div class="mt-4">
                  <small class="text-muted">
                    Si el problema persiste, contacta al administrador del sistema.
                  </small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->
  
  <!-- Required Js -->
  <script src="../admin/assets/js/plugins/popper.min.js"></script>
  <script src="../admin/assets/js/plugins/simplebar.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../admin/assets/js/fonts/custom-font.js"></script>
  <script src="../admin/assets/js/pcoded.js"></script>
  <script src="../admin/assets/js/plugins/feather.min.js"></script>

  <script>layout_change('light');</script>
  <script>change_box_container('false');</script>
  <script>layout_rtl_change('false');</script>
  <script>preset_change("preset-1");</script>
  <script>font_change("Public-Sans");</script>
</body>
</html>