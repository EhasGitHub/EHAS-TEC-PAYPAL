<?php
session_start();

// Verificar la sesión de usuario
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Incluir archivo de configuración de la base de datos
include 'config.php';

$successMessage = '';
$errorMessage = '';
$profileImageURL = '';

// Procesar formulario si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cambio de nombre de usuario
    if (isset($_POST['changeUsername'])) {
        $newUsername = $_POST['newUsername'];
        $userId = $_SESSION['user_id'];

        $sql = "UPDATE users SET username='$newUsername' WHERE id='$userId'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['username'] = $newUsername;
            $successMessage = "Nombre de usuario actualizado correctamente.";
        } else {
            $errorMessage = "Error al actualizar el nombre de usuario: " . $conn->error;
        }
    }

    // Cambio de contraseña
    if (isset($_POST['changePassword'])) {
        $currentPassword = $_POST['currentPassword'];
        $newPassword = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
        $userId = $_SESSION['user_id'];

        $sql = "SELECT * FROM users WHERE id='$userId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($currentPassword, $user['password'])) {
                $sql_update = "UPDATE users SET password='$newPassword' WHERE id='$userId'";
                if ($conn->query($sql_update) === TRUE) {
                    $successMessage = "Contraseña actualizada correctamente.";
                } else {
                    $errorMessage = "Error al actualizar la contraseña: " . $conn->error;
                }
            } else {
                $errorMessage = "La contraseña actual es incorrecta.";
            }
        } else {
            $errorMessage = "Usuario no encontrado.";
        }
    }

    // Cambio de imagen de perfil
    if (isset($_POST['changeImage'])) {
        $file = $_FILES['profileImage'];

        // Verificar si se seleccionó un archivo
        if ($file['size'] > 0) {
            $uploadDir = 'images/'; // Directorio donde se guardarán las imágenes
            $uploadFile = $uploadDir . basename($file['name']);

            // Guardar el archivo en el directorio de uploads
            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                $profileImageURL = $uploadFile;
                $successMessage = "Imagen de perfil actualizada correctamente.";
                // Aquí deberías tener lógica para guardar la URL de la imagen en la base de datos si es necesario
                // Ejemplo: $sql_update_image = "UPDATE users SET profile_image='$profileImageURL' WHERE id='$userId'";
            } else {
                $errorMessage = "Error al cargar la imagen.";
            }
        } else {
            $errorMessage = "Por favor selecciona una imagen.";
        }
    }
}

// Obtener la URL de la imagen de perfil actual desde la base de datos o donde sea que la guardes
// Ejemplo: $profileImageURL = obtener_url_de_imagen_desde_la_base_de_datos();

$sql = "SELECT * FROM users WHERE username='{$_SESSION['username']}'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['user_id'] = $user['id'];
    // Asignar la URL de la imagen de perfil si está guardada en la base de datos
    // Ejemplo: $profileImageURL = $user['profile_image'];
}
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    $cart_count = array_sum($_SESSION['cart']);
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="dropdown.css"> <!-- Estilos para el dropdown -->
    <link rel="stylesheet" href="login-box.css"> <!-- Estilos para el cuadro de login -->
    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="scripts.js" defer></script> <!-- Archivo de scripts para las interacciones -->
    <script src="scripts.js2" defer></script>
</head>

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
                                <li><a href="#">Perfil</a></li>
                                <li><a href="logout.php">Cerrar Sesión</a></li>
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
    <section class="profile-section">
        <div class="content-profile">
            <div class="profile-info">
                <h2>Bienvenido, <?php echo $_SESSION['username']; ?></h2>
                <?php if ($successMessage) : ?>
                    <div class="success-message"><?php echo $successMessage; ?></div>
                <?php endif; ?>
                <?php if ($errorMessage) : ?>
                    <div class="error-message"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
                <div class="profile-actions">
                    <form class="profile-form" action="profile.php" method="post" enctype="multipart/form-data">
                        <label for="profileImage">Cambiar Imagen de Perfil:</label>
                        <input type="file" id="profileImage" name="profileImage" accept="image/*">
                        <button class="btn" type="submit" name="changeImage">Guardar Imagen</button>
                    </form>
                    <form class="profile-form" action="profile.php" method="post">
                        <label for="newUsername">Nuevo Nombre de Usuario:</label>
                        <input type="text" id="newUsername" name="newUsername" required>
                        <button class="btn" type="submit" name="changeUsername">Cambiar Nombre de Usuario</button>
                    </form>
                    <form class="profile-form" action="profile.php" method="post">
                        <label for="currentPassword">Contraseña Actual:</label>
                        <input type="password" id="currentPassword" name="currentPassword" required>
                        <label for="newPassword">Nueva Contraseña:</label>
                        <input type="password" id="newPassword" name="newPassword" required>
                        <button class="btn" type="submit" name="changePassword">Cambiar Contraseña</button>
                    </form>
                </div>
            </div>
            <div class="profile-image">
                <?php if (!empty($profileImageURL)) : ?>
                    <img src="<?php echo $profileImageURL; ?>" alt="Imagen de Perfil">
                <?php else : ?>
                    <img src="images/default-profile-image.jpg" alt="Imagen de Perfil por Defecto">
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="scripts.js"></script>
<script src="scripts2.js" defer></script>
</body>
</html>
