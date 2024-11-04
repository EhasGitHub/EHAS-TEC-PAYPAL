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

// Recuperar productos de la base de datos
$sql = "SELECT id, name, description, price, stock, category, image_url FROM products";
$result = $conn->query($sql);

// Contar los productos en el carrito
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    $cart_count = array_sum($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ehas Tec</title>
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
                    <form class="search-form" action="search.php" method="get">
                        <input type="search" name="query" placeholder="Buscar..." required />
                        <button class="btn-search" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
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
                        <i class="fa-solid fa-basket-shopping" onclick="window.location.href='cart.php'"></i> <!-- Redirigir a cart.php -->
                        <?php if ($cart_count > 0): ?>
                            <div class="cart-count"><?php echo $cart_count; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>

<section class="banner">
    <div class="content-banner">
        <p>Productos en oferta</p>
        <h2>Descubre la <br />tecnología del futuro</h2>
        <a href="#">Comprar ahora</a>
    </div>
</section>

<main>
    <section class="products">
        <h2 class="heading-1 prodh">Productos</h2>
        <div class="container">
            <div class="product-grid">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="product-card">';
                        echo '<img src="images/' . $row['image_url'] . '" alt="' . $row['name'] . '" class="product-image">';
                        echo '<h3 class="product-title">' . $row['name'] . '</h3>';
                        echo '<p class="product-description">' . $row['description'] . '</p>';
                        echo '<p class="product-price">Precio: $' . $row['price'] . '</p>';
                        echo '<p class="product-stock">Stock: ' . $row['stock'] . '</p>';
                        echo '<form method="post" action="add_to_cart.php">';
                        echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                        if (isset($_SESSION['user_id'])) {
                            echo '<button type="submit" class="btn btn-primary add-to-cart">Añadir al carrito</button>';
                        } else {
                            echo '<button type="button" class="btn btn-primary add-to-cart" onclick="alert(\'Debes iniciar sesión para añadir productos al carrito\')">Añadir al carrito</button>';
                        }
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No hay productos disponibles.</p>';
                }
                ?>
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

<!-- Cuadro de login -->
<div class="login-container" id="loginContainer">
    <div class="login-box">
        <h2>Iniciar sesión</h2>
        <form action="login.php" method="post">
            <label for="username">Nombre de usuario</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Iniciar sesión</button>
            <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
        </form>
    </div>
</div>

<!-- Cuadro de registro -->
<div class="register-container" id="registerContainer">
    <div class="register-box">
        <h2>Registrarse</h2>
        <form action="register.php" method="post">
            <label for="username">Nombre de usuario</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Registrarse</button>
            <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </form>
    </div>
</div>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="scripts.js"></script>
<!-- Asegúrate de que este script esté al final del body -->
<script src="scriptsscroll.js"></script>

</body>
</html>
