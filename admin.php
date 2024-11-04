<?php
include('config.php');
session_start();


// Verificar si el usuario es administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Administrador') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_id = $_POST['role_id']; // Cambiado a role_id
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $hashed_password, $role_id); // Cambiado a role_id

    if ($stmt->execute()) {
        echo "<p class='success-message'>Usuario creado con éxito.</p>";
    } else {
        echo "<p class='error-message'>Error al crear el usuario: " . $conn->error . "</p>";
    }
}


// Manejar la actualización de usuarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role_id = $_POST['role_id']; // Cambiado a role_id

    $sql = "UPDATE users SET username = ?, email = ?, role_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $username, $email, $role_id, $user_id);

    if ($stmt->execute()) {
        echo "<p class='success-message'>Usuario actualizado con éxito.</p>";
    } else {
        echo "<p class='error-message'>Error al actualizar el usuario: " . $conn->error . "</p>";
    }
}


// Manejar la eliminación de usuarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<p class='success-message'>Usuario eliminado con éxito.</p>";
    } else {
        echo "<p class='error-message'>Error al eliminar el usuario: " . $conn->error . "</p>";
    }
}


// Manejar la creación de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];

    // Manejar la carga de la imagen
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $upload_dir = 'images/'; // Directorio donde se guardarán las imágenes

        // Mover el archivo subido a la carpeta deseada
        if (move_uploaded_file($image_tmp_name, $upload_dir . $image_name)) {
            $image_url = $image_name; // Guardar el nombre del archivo en la base de datos

            $sql = "INSERT INTO products (name, description, price, stock, category, image_url) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdiis", $name, $description, $price, $stock, $category, $image_url);

            if ($stmt->execute()) {
                echo "<p class='success-message'>Producto creado con éxito.</p>";
            } else {
                echo "<p class='error-message'>Error al crear el producto: " . $conn->error . "</p>";
            }
        } else {
            echo "<p class='error-message'>Error al subir la imagen.</p>";
        }
    } else {
        echo "<p class='error-message'>No se ha subido ninguna imagen.</p>";
    }
}

// Manejar la eliminación de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];

    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        echo "<p class='success-message'>Producto eliminado con éxito.</p>";
    } else {
        echo "<p class='error-message'>Error al eliminar el producto: " . $conn->error . "</p>";
    }
}

// Manejar la actualización de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];

    // Manejar la carga de la imagen si se proporciona
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $upload_dir = 'images/'; // Directorio donde se guardarán las imágenes

        // Mover el archivo subido a la carpeta deseada
        if (move_uploaded_file($image_tmp_name, $upload_dir . $image_name)) {
            $image_url = $image_name;
        } else {
            echo "<p class='error-message'>Error al subir la imagen.</p>";
            $image_url = null; // Evitar actualizar el campo si la imagen no se subió
        }
    } else {
        $image_url = $_POST['image_url']; // Mantener la URL de la imagen actual si no se subió una nueva
    }

    $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, category = ?, image_url = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdiisi", $name, $description, $price, $stock, $category, $image_url, $product_id);

    if ($stmt->execute()) {
        echo "<p class='success-message'>Producto actualizado con éxito.</p>";
    } else {
        echo "<p class='error-message'>Error al actualizar el producto: " . $conn->error . "</p>";
    }
}

// Obtener usuarios y productos para mostrar en la lista
$users = $conn->query("SELECT * FROM users");
$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="login-box.css">
    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="scripts.js" defer></script>
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
                            <i class="fas fa-user" id="profileIcon"></i>
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

    <section class="admin-section">
    <h2 class="heading-1">Panel de Administración</h2>
    <div class="container2">
        <div class="admin-actions">
            <div class="admin-form-row">
                <div class="admin-form-item">
                <form action="admin.php" method="POST" class="admin-form">
                    <h3>Crear Usuario</h3>
                    <input type="text" name="username" placeholder="Nombre de Usuario" required>
                    <input type="email" name="email" placeholder="Correo Electrónico" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <select name="role_id" required>
                        <option value="1">Administrador</option>
                        <option value="2">Cliente</option>
                    </select>

                    <button type="submit" name="create_user" class="btn">Crear Usuario</button>
                </form>
                </div>

                <div class="admin-form-item">
                    <form action="admin.php" method="POST" enctype="multipart/form-data" class="admin-form">
                        <h3>Crear Producto</h3>
                        <input type="text" name="name" placeholder="Nombre del Producto" required>
                        <textarea name="description" placeholder="Descripción" required></textarea>
                        <input type="number" name="price" placeholder="Precio" step="0.01" required>
                        <input type="number" name="stock" placeholder="Stock" required>
                        <input type="text" name="category" placeholder="Categoría" required>
                        <input type="file" name="image" accept="image/*" required>
                        <button type="submit" name="create_product" class="btn">Crear Producto</button>
                    </form>
                </div>
            </div>

            <div class="data-tables2">
            <h3>Usuarios</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $users->fetch_assoc()): ?>
                            <tr>
                                <form action="admin.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <td><?php echo $user['id']; ?></td>
                                    <td><input type="text" name="username" value="<?php echo $user['username']; ?>" required></td>
                                    <td><input type="email" name="email" value="<?php echo $user['email']; ?>" required></td>
                                    <td>
                                        <select name="role_id" required>
                                            <option value="1" <?php echo ($user['role_id'] === 1) ? 'selected' : ''; ?>>Administrador</option>
                                            <option value="2" <?php echo ($user['role_id'] === 2) ? 'selected' : ''; ?>>Cliente</option>
                                        </select>
                                    </td>

                                    <td>
                                        <button type="submit" name="update_user" class="btn btn-update">Actualizar</button>
                                        <button type="submit" name="delete_user" class="btn btn-delete">Eliminar</button>
                                    </td>
                                </form>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>


            <div class="data-tables3">
            <h3>Productos</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Categoría</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($product = $products->fetch_assoc()): ?>
                            <tr>
                                <form action="admin.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <td><?php echo $product['id']; ?></td>
                                    <td><input type="text" name="name" value="<?php echo $product['name']; ?>" required></td>
                                    <td><textarea name="description" required><?php echo $product['description']; ?></textarea></td>
                                    <td><input type="number" name="price" value="<?php echo $product['price']; ?>" step="0.01" required></td>
                                    <td><input type="number" name="stock" value="<?php echo $product['stock']; ?>" required></td>
                                    <td><input type="text" name="category" value="<?php echo $product['category']; ?>" required></td>
                                    <td>
                                        <img src="images/<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" class="product-image-small">
                                        <input type="file" name="image" accept="image/*">
                                        <input type="hidden" name="image_url" value="<?php echo $product['image_url']; ?>">
                                    </td>
                                    <td>
                                        <button type="submit" name="update_product" class="btn btn-update">Actualizar</button>
                                        <button type="submit" name="delete_product" class="btn btn-delete">Eliminar</button>
                                    </td>
                                </form>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script src="scripts2.js" defer></script>
</body>
</html>
