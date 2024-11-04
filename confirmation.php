<?php
session_start();

// Verificar si hay información del carrito y del total en la sesión
if (!isset($_SESSION['cart_items']) || !isset($_SESSION['total_amount'])) {
    header('Location: index.php');
    exit;
}

$cart_items = $_SESSION['cart_items'] ?? array();
$total_amount = $_SESSION['total_amount'];

// Limpiar las variables de sesión después de usar
unset($_SESSION['cart_items']);
unset($_SESSION['total_amount']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="dropdown.css"> <!-- Estilos para el dropdown -->
    <link rel="stylesheet" href="login-box.css"> <!-- Estilos para el cuadro de login -->
    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="scripts.js" defer></script> <!-- Archivo de scripts para las interacciones -->
    <script src="scripts2.js" defer></script>
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
                        <i class="fas fa-user" id="profileIcon"></i> <!-- Icono de perfil -->
                        <div class="profile-options" id="profileOptions">
                            <ul>
                                <?php if (isset($_SESSION['username'])): ?>
                                    <li><a href="profile.php">Perfil</a></li>
                                    <li><a href="logout.php">Cerrar Sesión</a></li>
                                <?php else: ?>
                                    <li><a href="#" id="loginLink">Iniciar sesión</a></li>
                                    <li><a href="#" id="registerLink">Registrarse</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>

<main>
    <section class="confirmation">
        <div class="container">
            <div class="voucher">
                <h2>¡Gracias por tu compra!</h2>
                <p>Tu pedido ha sido procesado exitosamente. A continuación, puedes revisar el resumen de tu compra.</p>
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                                <td>$<?php echo htmlspecialchars($item['total_price']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="total">Total a Pagar: $<?php echo htmlspecialchars($total_amount); ?></p>
                <a href="index.php" class="btn-return">Volver al Inicio</a>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
		<div class="container container-footer">
			<div class="menu-footer">
				<div class="contact-info">
					<p class="title-footer">Información de Contacto</p>
					<ul>
						<li>
							Cerro de Pasco - 2024
						</li>
						<li>Teléfono: 981347023</li>
						<li>EmaiL: ehas212121@support.com</li>
					</ul>
					<div class="social-icons">
						<span class="facebook">
							<i class="fa-brands fa-facebook-f"></i>
						</span>
						<span class="twitter">
							<i class="fa-brands fa-twitter"></i>
						</span>
						<span class="youtube">
							<i class="fa-brands fa-youtube"></i>
						</span>
						<span class="pinterest">
							<i class="fa-brands fa-pinterest-p"></i>
						</span>
						<span class="instagram">
							<i class="fa-brands fa-instagram"></i>
						</span>
					</div>
				</div>

				<div class="information">
					<p class="title-footer">Información</p>
					<ul>
						<li><a href="about.php">Acerca de Nosotros</a></li>
						<li><a href="#">Información Delivery</a></li>
						<li><a href="#">Politicas de Privacidad</a></li>
						<li><a href="#">Términos y condiciones</a></li>
						<li><a href="#">Contactános</a></li>
					</ul>
				</div>

			<div class="copyright">
				<p>
					Elias Hassier Argandoña Sandoval &copy; 2024
				</p>
			</div>
		</div>
	</footer>
    <script src="scripts2.js" defer></script>
</body>
</html>
