<?php
include('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'client'; // Por defecto, todos los usuarios registrados desde aquí son clientes

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header('Location: index.php');
        exit;
    } else {
        echo "Error al registrar el usuario: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css">
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

                    <form class="search-form">
                        <input type="search" placeholder="Buscar..." />
                        <button class="btn-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>

                    <div class="container-user">
                        <i class="fa-solid fa-user" onclick="window.location.href='login.php'"></i>
                        <i class="fa-solid fa-basket-shopping"></i>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <section class="register-section">
    <div class="container">
        <div class="form-container">
            <h2 class="form-heading">Registro</h2>
            <form action="register.php" method="POST" class="form">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" required class="input-field" />
                
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required class="input-field" />
                
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required class="input-field" />
                
                <button type="submit" class="btn">Registrarse</button>
                <p class="form-footer">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
            </form>
        </div>
    </div>
</section>

    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
</body>
</html>
