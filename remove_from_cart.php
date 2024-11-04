<?php
session_start();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);

        // Redirigir al carrito después de eliminar el producto
        header('Location: cart.php');
        exit;
    }
} else {
    // Redirigir al carrito si no se especifica ningún producto
    header('Location: cart.php');
    exit;
}
?>
