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

// Función para manejar la eliminación de productos del carrito
if (isset($_POST['remove_product'])) {
    $remove_id = $_POST['product_id'];
    unset($_SESSION['cart'][$remove_id]);
    header('Location: cart.php');
    exit;
}

// Contar los productos en el carrito
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    $cart_count = array_sum($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="login-box.css">
    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
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

<section class="cart-section">
    <div class="container">
        <h2 class="heading-1">Carrito de Compras</h2>
        <?php
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $product_ids = array_keys($_SESSION['cart']);
            $ids = implode(',', $product_ids);
            $sql = "SELECT id, name, price, image_url FROM products WHERE id IN ($ids)";
            $result = $conn->query($sql);

            echo '<table class="cart-table">';
            echo '<thead><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th><th>Acción</th></tr></thead>';
            echo '<tbody>';

            $total = 0;
            while ($row = $result->fetch_assoc()) {
                $quantity = $_SESSION['cart'][$row['id']];
                $subtotal = $row['price'] * $quantity;
                $total += $subtotal;

                echo '<tr>';
                echo '<td><img src="images/' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '" class="cart-image"> ' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>$' . htmlspecialchars($row['price']) . '</td>';
                echo '<td>' . htmlspecialchars($quantity) . '</td>';
                echo '<td>$' . htmlspecialchars($subtotal) . '</td>';
                echo '<td>
                        <form action="cart.php" method="post" style="display:inline;">
                            <input type="hidden" name="product_id" value="' . htmlspecialchars($row['id']) . '">
                            <button type="submit" name="remove_product" class="btn btn-delete">Quitar de Lista</button>
                        </form>
                      </td>';
                echo '</tr>';
            }

            echo '<tr><td colspan="4" class="text-right">Total:</td><td>$' . htmlspecialchars($total) . '</td></tr>';
            echo '</tbody>';
            echo '</table>';
            echo '<form action="checkout.php" method="post">';
            echo '<input type="hidden" name="total_amount" value="' . htmlspecialchars($total) . '">';
            echo '<button type="submit" class="btn btn-cart">Proceder al Pago</button>';
            echo '</form>';
        } else {
            echo '<p>Tu carrito está vacío.</p>';
        }
        ?>
    </div>
</section>
</body>
</html>
