<?php
session_start(); // Inicia la sesión

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

// Redirige al usuario a alguna página después de cerrar sesión
header('Location: index.php'); // Puedes ajustar la redirección según tu aplicación
exit;
?>
