<?php
// Incluye el archivo de conexión a la base de datos
require_once 'conexion.php';

// Verifica si el formulario ha sido enviado
if (isset($_POST['btn_registrar'])) {
    // Recoge y sanea los datos del formulario
    $tipoDocumento = filter_input(INPUT_POST, 'tipoDocumento', FILTER_SANITIZE_NUMBER_INT);
    $numeroDocumento = filter_input(INPUT_POST, 'numeroDocumento', FILTER_SANITIZE_STRING);
    $primerNombre = filter_input(INPUT_POST, 'primerNombre', FILTER_SANITIZE_STRING);
    $segundoNombre = filter_input(INPUT_POST, 'segundoNombre', FILTER_SANITIZE_STRING);
    $primerApellido = filter_input(INPUT_POST, 'primerApellido', FILTER_SANITIZE_STRING);
    $segundoApellido = filter_input(INPUT_POST, 'segundoApellido', FILTER_SANITIZE_STRING);
    $clave = $_POST['clave']; // La contraseña se hashea, no se sanea directamente
    $confirmarClave = $_POST['confirmarClave'];
    $idrol = filter_input(INPUT_POST, 'idrol', FILTER_SANITIZE_NUMBER_INT);

    // Validación básica del lado del servidor
    if (empty($tipoDocumento) || empty($numeroDocumento) || empty($primerNombre) || empty($primerApellido) || empty($clave) || empty($confirmarClave) || empty($idrol)) {
        die("Por favor, complete todos los campos requeridos.");
    }

    if ($clave !== $confirmarClave) {
        die("Las claves no coinciden.");
    }

    // Hashear la contraseña antes de almacenarla
    $clave_hasheada = password_hash($clave, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar los datos de forma segura
    // Asegúrate de que los nombres de las columnas coincidan con los de tu base de datos
    $sql = "INSERT INTO usuarios (tipoDocumento, numeroDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, clave, idrol) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia
    if ($stmt = $conn->prepare($sql)) {
        // Vincular parámetros (s = string, i = integer)
        $stmt->bind_param("issssssi", $tipoDocumento, $numeroDocumento, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $clave_hasheada, $idrol);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            // Redirigir a una página de éxito o mostrar un mensaje
            header("Location: registro_exitoso.html"); // Puedes crear un HTML simple o una página PHP
            exit();
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

} else {
    // Si se intenta acceder al script directamente sin enviar el formulario
    echo "Acceso no permitido.";
}
?>