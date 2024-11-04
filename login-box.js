// login-box.js

// Captura el elemento del icono de perfil
const profileIcon = document.querySelector('.fa-user');

// Captura el contenedor del cuadro de login
const loginContainer = document.getElementById('loginContainer');

// Añade un evento de clic al icono de perfil
profileIcon.addEventListener('click', function() {
    // Muestra el cuadro de login
    loginContainer.style.display = 'block';
});

// Opcional: Cierra el cuadro de login si se hace clic fuera de él
window.addEventListener('click', function(event) {
    if (event.target === loginContainer) {
        loginContainer.style.display = 'none';
    }
});

