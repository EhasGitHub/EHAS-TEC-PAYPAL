$(document).ready(function() {
    var profileOptions = $('#profileOptions'); // Guardamos la referencia al elemento
    
    // Mostrar las opciones al pasar el cursor sobre el icono de perfil
    $('#profileIcon').hover(function() {
        profileOptions.addClass('show'); // Mostrar opciones
    });
    
    // Mantener las opciones visibles al pasar el cursor sobre ellas
    profileOptions.hover(function() {
        profileOptions.addClass('show'); // Mantener opciones visibles
    }, function() {
        profileOptions.removeClass('show'); // Ocultar opciones al salir
    });

    // Ocultar las opciones al hacer clic fuera de ellas
    $(document).mouseup(function(e) {
        var container = $(".profile-menu");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            profileOptions.removeClass('show'); // Ocultar opciones de perfil
        }
    });

    // Mostrar cuadro de login al hacer clic en "Iniciar sesión"
    $('#loginLink').on('click', function(e) {
        e.preventDefault();
        $('#profileOptions').removeClass('show'); // Ocultar opciones de perfil
        $('.login-container').fadeIn(); // Mostrar cuadro de login
        darkenMain(); // Oscurecer el contenido principal
    });

    // Mostrar cuadro de registro al hacer clic en "Registrarse"
    $('#registerLink').on('click', function(e) {
        e.preventDefault();
        $('#profileOptions').removeClass('show'); // Ocultar opciones de perfil
        $('.register-container').fadeIn(); // Mostrar cuadro de registro
        darkenMain(); // Oscurecer el contenido principal
    });

    // Cerrar el cuadro de login si se hace clic fuera de él
    $(document).mouseup(function(e) {
        var container = $(".login-box");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('.login-container').fadeOut(); // Ocultar el contenedor de login
            lightenMain(); // Aclarar el contenido principal
        }
    });

    // Cerrar el cuadro de registro si se hace clic fuera de él
    $(document).mouseup(function(e) {
        var container = $(".register-box");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('.register-container').fadeOut(); // Ocultar el contenedor de registro
            lightenMain(); // Aclarar el contenido principal
        }
    });

    // Función para oscurecer el contenido principal
    function darkenMain() {
        $('.main-content').addClass('darken'); // Añadir clase para oscurecer
    }

    // Función para aclarar el contenido principal
    function lightenMain() {
        $('.main-content').removeClass('darken'); // Quitar clase para oscurecer
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.querySelector(".menu-toggle");
    const menu = document.querySelector(".menu");

    menuToggle.addEventListener("click", function() {
        menu.classList.toggle("active");
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.querySelector(".menu-toggle");
    const menu = document.querySelector(".menu");

    menuToggle.addEventListener("click", function() {
        menu.classList.toggle("active");
    });
});
