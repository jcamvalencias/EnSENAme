<?php
require_once __DIR__ . '/../../includes/session.php';
require_once '../../conexion.php';
if (!isset($_SESSION['id_usuario'])) {
  header('Location: ../../login.php');
  exit();
}
$id_usuario = $_SESSION['id_usuario'];
// Obtener datos del usuario activo (tabla y campo correctos)
$sql = "SELECT * FROM tb_usuarios WHERE ID='$id_usuario'";
$res = mysqli_query($conexion, $sql);
$usuario = mysqli_fetch_assoc($res);

// Determinar la ruta de la imagen de perfil
$foto_perfil = $usuario['foto_perfil'] ?? '';
$imagen_perfil = !empty($foto_perfil) && file_exists("../../uploads/profile_images/" . $foto_perfil) 
  ? "../../uploads/profile_images/" . $foto_perfil 
  : "../assets/images/user/avatar-2.jpg";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil Usuario</title>
  <link rel="icon" href="../assets/images/favisena.png" type="image/x-icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="../assets/fonts/feather.css" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="../assets/fonts/fontawesome.css" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="../assets/fonts/material.css" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="../assets/css/style.css" id="main-style-link" >
<link rel="stylesheet" href="../assets/css/style-preset.css" >
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fb;
      margin: 0;
      padding: 0;
    }

    .profile-container {
      display: flex;
      max-width: 1000px;
      margin: 40px auto;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    }

    /* Lado izquierdo */
    .profile-sidebar {
      background: #eaf6ff;
      text-align: center;
      padding: 30px 20px;
      width: 300px;
    }

    .profile-sidebar img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      margin-bottom: 15px;
    }

    .profile-sidebar h2 {
      margin: 10px 0 5px;
    }

    .profile-sidebar p {
      color: #666;
      margin: 5px 0 20px;
    }

    .btn-change {
      background: #00bcd4;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 25px;
      cursor: pointer;
    }

    /* Lado derecho */
    .profile-form {
      flex: 1;
      padding: 30px;
    }

    .profile-form h3 {
      margin-bottom: 20px;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
      color: #444;
    }

    .form-group input, 
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    #fileInput {
  display: none;
}

  .btn-ir {
      background: #00bcd4;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 25px;
      cursor: pointer;
    }


  </style>
</head>
<body>

  <a href="index.php" style="
    position: absolute;
    top: 24px;
    left: 24px;
    text-decoration: none;
    color: #528bca;
    font-size: 2rem;
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: bold;
  " title="Volver al inicio">
    <span style="font-size:2.2rem;line-height:1;">&#8592;</span> <span style="font-size:1.1rem;">Inicio</span>
  </a>
  <div class="profile-container">
    <!-- Perfil -->
    <div class="profile-sidebar">
      <img id="profileImage" src="<?php echo htmlspecialchars($imagen_perfil); ?>" alt="user-image">
  <?php
    // Determine display name: prefer session display_name, else build from DB fields
    $displayName = '';
    if (!empty($_SESSION['display_name'])) {
      $displayName = $_SESSION['display_name'];
    } else {
      $parts = array_filter([$usuario['p_nombre'] ?? '', $usuario['s_nombre'] ?? '', $usuario['p_apellido'] ?? '', $usuario['s_apellido'] ?? '']);
      $displayName = implode(' ', $parts);
    }
  ?>
  <h2><?php echo htmlspecialchars($displayName); ?></h2>
  <p><?php echo htmlspecialchars($displayName); ?></p>
      <button class="btn-change" onclick="document.getElementById('fileInput').click();">Cambiar Imagen</button>
      <input type="file" id="fileInput" name="foto_perfil" accept="image/*" onchange="previewImage(event)">
    </div>

    <!-- Formulario -->
    <div class="profile-form">
      <h3>Información Personal</h3>
      
      <form method="post" action="editarperfil.php" enctype="multipart/form-data">
        <input type="hidden" name="foto_actual" value="<?php echo htmlspecialchars($usuario['foto_perfil'] ?? ''); ?>">
        <div class="form-group">
          <label for="tipo-doc">Tipo de Documento:</label>
          <select id="tipo-doc" name="tipo_doc" style="pointer-events: none; background: #f1f1f1; cursor: not-allowed;">
            <option value="1" <?php if($usuario['Tipo_Documento']==1) echo 'selected'; ?>>C.C</option>
            <option value="2" <?php if($usuario['Tipo_Documento']==2) echo 'selected'; ?>>T.I</option>
            <option value="3" <?php if($usuario['Tipo_Documento']==3) echo 'selected'; ?>>N.N</option>
          </select>
        </div>
        <div class="form-group">
          <label for="num-doc">Número de Documento:</label>
          <input type="text" id="num-doc" name="num_doc" value="<?php echo htmlspecialchars($usuario['ID']); ?>">
        </div>
        <div class="form-group">
          <label for="primer-nombre">Primer Nombre:</label>
          <input type="text" id="primer-nombre" name="primer_nombre" value="<?php echo htmlspecialchars($usuario['p_nombre']); ?>">
        </div>
        <div class="form-group">
          <label for="segundo-nombre">Segundo Nombre:</label>
          <input type="text" id="segundo-nombre" name="segundo_nombre" value="<?php echo htmlspecialchars($usuario['s_nombre']); ?>">
        </div>
        <div class="form-group">
          <label for="primer-apellido">Primer Apellido:</label>
          <input type="text" id="primer-apellido" name="primer_apellido" value="<?php echo htmlspecialchars($usuario['p_apellido']); ?>">
        </div>
        <div class="form-group">
          <label for="segundo-apellido">Segundo Apellido:</label>
          <input type="text" id="segundo-apellido" name="segundo_apellido" value="<?php echo htmlspecialchars($usuario['s_apellido']); ?>">
        </div>
        <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
        <br>
        <button type="submit" class="btn-ir">Guardar cambios</button>
      </form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usuario']) && $_POST['id_usuario'] == $id_usuario) {
  $tipo_doc = mysqli_real_escape_string($conexion, $_POST['tipo_doc']);
  $num_doc = mysqli_real_escape_string($conexion, $_POST['num_doc']);
  $primer_nombre = mysqli_real_escape_string($conexion, $_POST['primer_nombre']);
  $segundo_nombre = mysqli_real_escape_string($conexion, $_POST['segundo_nombre']);
  $primer_apellido = mysqli_real_escape_string($conexion, $_POST['primer_apellido']);
  $segundo_apellido = mysqli_real_escape_string($conexion, $_POST['segundo_apellido']);

  $foto_actual = $_POST['foto_actual'] ?? '';
  $nueva_foto = $foto_actual; // Por defecto mantener la foto actual
  
  // Procesar subida de imagen si se seleccionó una
  if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
    $archivo = $_FILES['foto_perfil'];
    $nombre_original = $archivo['name'];
    $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));
    
    // Validar tipo de archivo
    $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (in_array($extension, $extensiones_permitidas)) {
      // Validar tamaño (máximo 5MB)
      if ($archivo['size'] <= 5 * 1024 * 1024) {
        // Generar nombre único para el archivo
        $nombre_nuevo = $id_usuario . '_' . time() . '.' . $extension;
        $ruta_destino = '../../uploads/profile_images/' . $nombre_nuevo;
        
        // Crear directorio si no existe
        if (!file_exists('../../uploads/profile_images/')) {
          mkdir('../../uploads/profile_images/', 0755, true);
        }
        
        // Mover archivo subido
        if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
          // Eliminar foto anterior si existe
          if (!empty($foto_actual) && file_exists('../../uploads/profile_images/' . $foto_actual)) {
            unlink('../../uploads/profile_images/' . $foto_actual);
          }
          $nueva_foto = $nombre_nuevo;
        } else {
          echo '<script>alert("Error al subir la imagen");</script>';
        }
      } else {
        echo '<script>alert("La imagen es demasiado grande. Máximo 5MB.");</script>';
      }
    } else {
      echo '<script>alert("Formato de imagen no válido. Solo se permiten: JPG, JPEG, PNG, GIF, WEBP");</script>';
    }
  }

  // Comprobar si hay cambios reales
  $hay_cambios = (
    $tipo_doc != $usuario['Tipo_Documento'] ||
    $num_doc != $usuario['ID'] ||
    $primer_nombre != $usuario['p_nombre'] ||
    $segundo_nombre != $usuario['s_nombre'] ||
    $primer_apellido != $usuario['p_apellido'] ||
    $segundo_apellido != $usuario['s_apellido'] ||
    $nueva_foto != $foto_actual
  );

  if ($hay_cambios) {
    $sql_update = "UPDATE tb_usuarios SET Tipo_Documento='$tipo_doc', ID='$num_doc', p_nombre='$primer_nombre', s_nombre='$segundo_nombre', p_apellido='$primer_apellido', s_apellido='$segundo_apellido', foto_perfil='$nueva_foto' WHERE ID='$id_usuario'";
    if (mysqli_query($conexion, $sql_update)) {
      // Update session vars in multiple keys for compatibility
      $_SESSION['p_nombre'] = $primer_nombre;
      $_SESSION['primer_nombre'] = $primer_nombre;
      $_SESSION['s_nombre'] = $segundo_nombre;
      $_SESSION['segundo_nombre'] = $segundo_nombre;
      $_SESSION['p_apellido'] = $primer_apellido;
      $_SESSION['primer_apellido'] = $primer_apellido;
      $_SESSION['s_apellido'] = $segundo_apellido;
      $_SESSION['segundo_apellido'] = $segundo_apellido;
      // Refresh display_name
      $parts = array_filter([$primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido]);
      $_SESSION['display_name'] = implode(' ', $parts);
      echo '<script>alert("Datos actualizados correctamente");window.location.reload();</script>';
    } else {
      echo '<script>alert("Error al actualizar los datos");</script>';
    }
  } else {
    echo '<script>alert("No se detectaron cambios en los datos.");</script>';
  }
}
?>
    </div>
    <div style="text-align:center; margin-top:20px;">
      <a href="logout.php" class="btn-ir" style="background:#dc3545;">Cerrar sesión</a>
    </div>
  </div>

</body>
</html>

<script>
    function previewImage(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profileImage').src = e.target.result;
        }
        reader.readAsDataURL(file);
      }
    }
  </script>