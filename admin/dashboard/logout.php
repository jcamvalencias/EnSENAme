session_start();
session_destroy();
header("Location: ../../login.php");
exit();

<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

// Limpiar todas las variables de sesión
$_SESSION = array();

// Si se usa una cookie de sesión, destruirla
if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]
	);
}

// Destruir la sesión
session_destroy();

// Redirigir al login
header("Location: ../../login.php");
exit();
