<?php
include('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar la consulta para obtener el usuario
    $sql = "SELECT id, username, password, role_id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Obtener el nombre del rol usando role_id
            $sql_role = "SELECT role_name FROM roles WHERE id = ?";
            $stmt_role = $conn->prepare($sql_role);
            $stmt_role->bind_param("i", $row['role_id']);
            $stmt_role->execute();
            $role_result = $stmt_role->get_result();
            $role = $role_result->fetch_assoc()['role_name'];

            // Configurar variables de sesión
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $role;

            // Redirigir a la página principal o según el rol
            if ($role === 'Administrador') {
                header('Location: index.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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

    <section class="login-section">
        <div class="container">
            <div class="form-container">
                <h2 class="form-heading">Iniciar Sesión</h2>
                <form action="login.php" method="POST" class="form">
                    <label for="username">Nombre de Usuario:</label>
                    <input type="text" id="username" name="username" required class="input-field" />
                    
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required class="input-field" />
                    
                    <?php if (isset($error)) { echo '<p class="error-message">' . $error . '</p>'; } ?>
                    
                    <button type="submit" class="btn">Iniciar Sesión</button>
                    <p class="form-footer">¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
                </form>
            </div>
        </div>
    </section>

    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
</body>
</html>
