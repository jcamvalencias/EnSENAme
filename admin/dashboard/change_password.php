<?php
session_start();
include __DIR__ . '/../../conexion.php';

// Asegurarse de que el usuario está autenticado (mínimo tener txtdoc en sesión)
if (empty($_SESSION['txtdoc'])) {
    header('Location: ../../login.php');
    exit();
}

$usuario = $_SESSION['txtdoc'];
$message = '';

// Función para validar la política de contraseña
function password_meets_policy($pw) {
    if (!is_string($pw)) return false;
    if (strlen($pw) < 10) return false;
    if (!preg_match('/[A-Z]/', $pw)) return false;
    if (!preg_match('/[a-z]/', $pw)) return false;
    if (!preg_match('/[0-9]/', $pw)) return false;
    if (!preg_match('/[!@#\$%\^&\*\(\)_\+\-=\[\]{};:"\'|,.<>\/\?]/', $pw)) return false;
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $newpw = $_POST['new_password'] ?? '';
    $newpw2 = $_POST['new_password_confirm'] ?? '';

    if ($newpw !== $newpw2) {
        $message = 'Las nuevas contraseñas no coinciden.';
    } elseif (!password_meets_policy($newpw)) {
        $message = 'La nueva contraseña no cumple la política de seguridad.';
    } else {
        // Obtener hash actual
        $q = mysqli_prepare($conexion, "SELECT Clave FROM tb_usuarios WHERE ID = ? LIMIT 1");
        mysqli_stmt_bind_param($q, 's', $usuario);
        mysqli_stmt_execute($q);
        $res = mysqli_stmt_get_result($q);
        if ($row = mysqli_fetch_assoc($res)) {
            $stored = $row['Clave'];
            $verified = false;
            if (password_verify($current, $stored)) {
                $verified = true;
            } elseif ($stored === md5($current)) {
                $verified = true;
            }

            if (!$verified) {
                $message = 'La contraseña actual es incorrecta.';
            } else {
                // Hashear nueva contraseña
                $preferredAlgo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT;
                $options = [];
                if ($preferredAlgo === PASSWORD_ARGON2ID) {
                    $options = [
                        'memory_cost' => 1<<17,
                        'time_cost' => 4,
                        'threads' => 2,
                    ];
                }
                $newHash = password_hash($newpw, $preferredAlgo, $options);
                $u = mysqli_prepare($conexion, "UPDATE tb_usuarios SET Clave = ?, needs_pw_change = 0 WHERE ID = ?");
                mysqli_stmt_bind_param($u, 'ss', $newHash, $usuario);
        if (mysqli_stmt_execute($u)) {
          $_SESSION['pw_changed'] = true;
          // Eliminar flag forzado
          unset($_SESSION['force_pw_change']);
                    // Redirigir según rol: 1 => admin, 2 => user
                    if (!empty($_SESSION['id_rol']) && intval($_SESSION['id_rol']) === 2) {
                      header('Location: ../../user/index.php');
                    } else {
                      header('Location: index.php');
                    }
                    exit();
        } else {
                    $message = 'Error al actualizar la contraseña.';
                }
            }
        } else {
            $message = 'Usuario no encontrado.';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <title>Cambiar contraseña - EnSEÑAme</title>
  <link rel="icon" href="../assets/images/favisena.png" type="image/x-icon">
  <link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" >
  <link rel="stylesheet" href="../assets/fonts/feather.css" >
  <link rel="stylesheet" href="../assets/fonts/fontawesome.css" >
  <link rel="stylesheet" href="../assets/fonts/material.css" >
  <link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" >
  <link rel="stylesheet" href="../assets/css/style-preset.css" >
</head>
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <div class="pc-container">
    <div class="pc-content container py-4">
      <div class="card">
        <div class="card-body">
          <h2 class="mb-3">Cambiar contraseña</h2>
          <?php if (!empty($_SESSION['force_pw_change'])): ?>
            <div class="alert alert-warning">
              <i class="ti ti-alert-triangle me-2"></i>
              <strong>Cambio de contraseña requerido</strong><br>
              Tu contraseña actual no cumple con las políticas de seguridad actuales. 
              Debes cambiarla antes de continuar.
            </div>
          <?php else: ?>
            <p class="text-info">
              <i class="ti ti-info-circle me-2"></i>
              Cambio de contraseña voluntario
            </p>
          <?php endif; ?>
          
          <?php if (!empty($message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="ti ti-alert-circle me-2"></i>
              <?php echo htmlspecialchars($message); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
          <form method="post">
            <div class="mb-3">
              <label for="current_password">Contraseña actual</label>
              <div class="input-group">
                <input type="password" id="current_password" name="current_password" class="form-control" required>
                <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                  <i class="ti ti-eye" id="eyeIconCurrent"></i>
                </button>
              </div>
            </div>
            <div class="mb-3">
              <label for="new_password">Nueva contraseña</label>
              <div class="input-group">
                <input type="password" id="new_password" name="new_password" class="form-control" required>
                <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                  <i class="ti ti-eye" id="eyeIconNew"></i>
                </button>
              </div>
              <small class="form-text text-muted">La contraseña debe tener al menos 10 caracteres e incluir mayúsculas, minúsculas, números y un símbolo.</small>
              <ul id="pw-requirements" class="small mt-2">
                <li id="req-length" class="text-muted">Mínimo 10 caracteres</li>
                <li id="req-upper" class="text-muted">Al menos una letra mayúscula (A-Z)</li>
                <li id="req-lower" class="text-muted">Al menos una letra minúscula (a-z)</li>
                <li id="req-digit" class="text-muted">Al menos un número (0-9)</li>
                <li id="req-symbol" class="text-muted">Al menos un símbolo (!@#$%...)</li>
              </ul>
            </div>
            <div class="mb-3">
              <label for="new_password_confirm">Confirmar nueva contraseña</label>
              <div class="input-group">
                <input type="password" id="new_password_confirm" name="new_password_confirm" class="form-control" required>
                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                  <i class="ti ti-eye" id="eyeIconConfirm"></i>
                </button>
              </div>
              <small id="match-status" class="form-text text-muted">Las contraseñas deben coincidir.</small>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary" type="submit" id="submit-btn" disabled data-bs-toggle="tooltip" data-bs-placement="top" title="Requisitos: mínimo 10 caracteres, mayúscula, minúscula, número y símbolo. El botón se habilita cuando las contraseñas coinciden.">Actualizar contraseña</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/js/plugins/popper.min.js"></script>
  <script src="../assets/js/plugins/simplebar.min.js"></script>
  <script src="../assets/js/plugins/bootstrap.min.js"></script>
  <script src="../assets/js/fonts/custom-font.js"></script>
  <script src="../assets/js/pcoded.js"></script>
  <script src="../assets/js/plugins/feather.min.js"></script>
  <script>layout_change('light');</script>
  <script>change_box_container('false');</script>
  <script>
    // Funcionalidad para mostrar/ocultar contraseñas
    document.addEventListener('DOMContentLoaded', function() {
      // Toggle para contraseña actual
      const toggleCurrentPassword = document.getElementById('toggleCurrentPassword');
      const currentPasswordInput = document.getElementById('current_password');
      const eyeIconCurrent = document.getElementById('eyeIconCurrent');
      
      if (toggleCurrentPassword && currentPasswordInput && eyeIconCurrent) {
        toggleCurrentPassword.addEventListener('click', function() {
          const type = currentPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          currentPasswordInput.setAttribute('type', type);
          
          if (type === 'text') {
            eyeIconCurrent.className = 'ti ti-eye-off';
          } else {
            eyeIconCurrent.className = 'ti ti-eye';
          }
        });
      }
      
      // Toggle para nueva contraseña
      const toggleNewPassword = document.getElementById('toggleNewPassword');
      const newPasswordInput = document.getElementById('new_password');
      const eyeIconNew = document.getElementById('eyeIconNew');
      
      if (toggleNewPassword && newPasswordInput && eyeIconNew) {
        toggleNewPassword.addEventListener('click', function() {
          const type = newPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          newPasswordInput.setAttribute('type', type);
          
          if (type === 'text') {
            eyeIconNew.className = 'ti ti-eye-off';
          } else {
            eyeIconNew.className = 'ti ti-eye';
          }
        });
      }
      
      // Toggle para confirmar contraseña
      const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
      const confirmPasswordInput = document.getElementById('new_password_confirm');
      const eyeIconConfirm = document.getElementById('eyeIconConfirm');
      
      if (toggleConfirmPassword && confirmPasswordInput && eyeIconConfirm) {
        toggleConfirmPassword.addEventListener('click', function() {
          const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          confirmPasswordInput.setAttribute('type', type);
          
          if (type === 'text') {
            eyeIconConfirm.className = 'ti ti-eye-off';
          } else {
            eyeIconConfirm.className = 'ti ti-eye';
          }
        });
      }
    });
    
    (function(){
      const pw = document.getElementById('new_password');
      const pw2 = document.getElementById('new_password_confirm');
      const reqs = {
        length: document.getElementById('req-length'),
        upper: document.getElementById('req-upper'),
        lower: document.getElementById('req-lower'),
        digit: document.getElementById('req-digit'),
        symbol: document.getElementById('req-symbol')
      };
      const matchStatus = document.getElementById('match-status');

      function test(s){
        reqs.length.className = s.length >= 10 ? 'text-success' : 'text-muted';
        reqs.upper.className = /[A-Z]/.test(s) ? 'text-success' : 'text-muted';
        reqs.lower.className = /[a-z]/.test(s) ? 'text-success' : 'text-muted';
        reqs.digit.className = /[0-9]/.test(s) ? 'text-success' : 'text-muted';
        reqs.symbol.className = /[!@#\$%\^&\*\(\)_\+\-\=\[\]{};:\"'|,.<>\/\?]/.test(s) ? 'text-success' : 'text-muted';
        updateMatch();
      }

      function updateMatch(){
        if (pw2.value === '') {
          matchStatus.className = 'form-text text-muted';
          matchStatus.textContent = 'Las contraseñas deben coincidir.';
          return;
        }
        if (pw.value === pw2.value) {
          matchStatus.className = 'form-text text-success';
          matchStatus.textContent = 'Las contraseñas coinciden.';
        } else {
          matchStatus.className = 'form-text text-danger';
          matchStatus.textContent = 'Las contraseñas no coinciden.';
        }
        toggleSubmit();
      }

      const submitBtn = document.getElementById('submit-btn');

      function allRequirementsOk(){
        return (
          reqs.length.classList.contains('text-success') &&
          reqs.upper.classList.contains('text-success') &&
          reqs.lower.classList.contains('text-success') &&
          reqs.digit.classList.contains('text-success') &&
          reqs.symbol.classList.contains('text-success')
        );
      }

      function toggleSubmit(){
        if (allRequirementsOk() && pw.value !== '' && pw.value === pw2.value) {
          submitBtn.disabled = false;
        } else {
          submitBtn.disabled = true;
        }
      }

      pw.addEventListener('input', function(){ test(pw.value); });
      pw2.addEventListener('input', updateMatch);

      // Initialize button state on load
      test(pw.value);
      updateMatch();

      // Initialize Bootstrap tooltips for the disabled button
      document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
      });
    })();
  </script>
</body>
</html>
