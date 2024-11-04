// register-box.js

// Captura el elemento del icono de perfil
const profileIcon = document.querySelector('.fa-user');

// Captura el contenedor del cuadro de registro
const registerContainer = document.getElementById('registerContainer');

// Añade un evento de clic al icono de perfil
profileIcon.addEventListener('click', function() {
    // Muestra el cuadro de registro
    registerContainer.style.display = 'block';
});

// Opcional: Cierra el cuadro de registro si se hace clic fuera de él
window.addEventListener('click', function(event) {
    if (event.target === registerContainer) {
        registerContainer.style.display = 'none';
    }
});
