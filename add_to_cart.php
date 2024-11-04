<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar el ID del producto
    if (isset($_POST['product_id']) && filter_var($_POST['product_id'], FILTER_VALIDATE_INT)) {
        $product_id = (int)$_POST['product_id'];

        // Inicializar el carrito si no está establecido
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Añadir el producto al carrito o incrementar la cantidad si ya existe
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = 1;
        } else {
            $_SESSION['cart'][$product_id]++;
        }

        // Redirigir con un mensaje de éxito opcional
        header('Location: index.php?added=1');
        exit;
    } else {
        // Redirigir con un mensaje de error opcional si el ID del producto es inválido
        header('Location: index.php?error=1');
        exit;
    }
}
?>
