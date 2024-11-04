<?php
session_start();
include('config.php');

// Recuperar información del usuario
$user_role = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT r.role_name FROM users u INNER JOIN roles r ON u.role_id = r.id WHERE u.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user_role = $result->fetch_assoc()['role_name'];
    }
    $stmt->close();
}

// Calcula el total del carrito utilizando los productos de la sesión
$total_amount = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Obtenemos los IDs de los productos en el carrito
    $product_ids = array_keys($_SESSION['cart']);
    $ids = implode(',', array_map('intval', $product_ids));

    // Consulta para obtener los precios de los productos en el carrito
    $sql = "SELECT id, price FROM products WHERE id IN ($ids)";
    $result = $conn->query($sql);

    // Calculamos el total del carrito
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['id'];
        $quantity = $_SESSION['cart'][$product_id];
        $total_amount += $row['price'] * $quantity;
    }
}

// Contar los productos en el carrito
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    $cart_count = array_sum($_SESSION['cart']);
}

// URL de PayPal
$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
$paypal_business = "ehas212121@gmail.com"; // Reemplaza con tu correo de PayPal
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="dropdown.css"> <!-- Estilos para el dropdown -->
    <link rel="stylesheet" href="login-box.css"> <!-- Estilos para el cuadro de login -->
    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="scripts.js" defer></script> <!-- Archivo de scripts para las interacciones -->
    <script src="scripts2.js" defer></script> <!-- Archivo de scripts para las interacciones -->
</head>
<body>
    <header>
        <div class="container-hero">
            <div class="container hero">
                <div class="container-logo">
                    <h1 class="logo"><a href="index.php">Ehas Tec</a></h1>
                </div>
                <nav class="navbar container">
                    <ul class="menu">
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="about.php">Sobre Nosotros</a></li>
                    </ul>
                    <div class="container-user">
                        <div class="profile-menu">
                            <i class="fas fa-user" id="profileIcon"></i>
                            <div class="profile-options" id="profileOptions">
                                <ul>
                                    <?php if (isset($_SESSION['username'])): ?>
                                        <li><a href="profile.php">Perfil</a></li>
                                    <?php if ($user_role === 'Administrador'): ?>
                                        <li><a href="admin.php">Administrador</a></li>
                                    <?php endif; ?>
                                        <li><a href="logout.php">Cerrar Sesión</a></li>
                                    <?php else: ?>
                                        <li><a href="#" id="loginLink">Iniciar sesión</a></li>
                                    <li><a href="#" id="registerLink">Registrarse</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="cart-icon-container">
                            <i class="fa-solid fa-basket-shopping" onclick="window.location.href='cart.php'"></i>
                            <?php if ($cart_count > 0): ?>
                                <div class="cart-count"><?php echo $cart_count; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>

<main>
    <section class="confirmation">
        <div class="container">
            <h1 class="voucher-title">Resumen de tu compra</h1>
            <p class="voucher-total">Total a pagar: $<?php echo number_format($total_amount, 2); ?></p>

            <!-- Formulario de pago de PayPal -->
            <form action="<?php echo $paypal_url; ?>" method="post" class="voucher-form">
                <!-- Campos de PayPal requeridos -->
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="business" value="<?php echo $paypal_business; ?>">
                <input type="hidden" name="item_name" value="Compra en Ehas Tec">
                <input type="hidden" name="amount" value="<?php echo number_format($total_amount, 2); ?>">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="return" value="confirmation.php"> <!-- URL de confirmación -->
                <input type="hidden" name="cancel_return" value="checkout.php"> <!-- URL de cancelación -->

                <!-- Botón para proceder al pago -->
                <button type="submit" class="btn btn-primary add-to-cart">Proceder al Pago con PayPal</button>
            </form>
        </div>
    </section>
</main>

</body>
</html>
