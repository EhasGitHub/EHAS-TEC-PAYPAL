<?php
session_start();
// Incluir la conexión a la base de datos
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
                <div class="container-user">
                    <div class="profile-menu">
                        <i class="fas fa-user" id="profileIcon"></i> <!-- Icono de perfil -->
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

    <main class="main-content">
        <section class="about-section">
            <div class="content-about">
                <div class="about-info">
                    <h2>Sobre Nosotros</h2>
                    <div class="about-text">
                        <p>Bienvenidos a Ehas Tec, tu tienda online de confianza para productos tecnológicos. Nos especializamos en ofrecer una amplia gama de productos como laptops, celulares, televisores y más, todos de las mejores marcas y a precios competitivos.</p>
                        <p>Nuestra misión es proporcionarte la mejor experiencia de compra con productos de calidad y un servicio al cliente excepcional. Fundada en 2021 por Elias Hassier Argandoña Sandoval, Ehas Tec se compromete a ser tu socio confiable en el mundo tecnológico.</p>
                        <p>Explora nuestra tienda y descubre por qué somos la elección preferida de muchos clientes apasionados por la tecnología.</p>
                    </div>
                    <div class="about-author">
                        <p>Autor: Elias Hassier Argandoña Sandoval</p>
                        <p>© 2024 Ehas Tec. Todos los derechos reservados.</p>
                    </div>
                </div>
                <div class="about-image">
                    <img src="images/aboutimg2.jpg" alt="Imagen de Sobre Nosotros">
                </div>
            </div>
        </section>
    </main>

    
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
    <script src="scripts2.js" defer></script>
</body>
</html>

