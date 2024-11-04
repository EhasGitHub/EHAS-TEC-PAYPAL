<?php
$password = 'EliasAdmin'; // Reemplaza 'tu_contraseña_aqui' con la contraseña que deseas hashear
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password;
?>
