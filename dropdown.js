$(document).ready(function() {
    // Mostrar las opciones al pasar el cursor sobre el icono de perfil
    $('#profileIcon').hover(function() {
        $('#profileOptions').addClass('show'); // Mostrar opciones
    }, function() {
        // No hacer nada al salir del icono de perfil para mantener las opciones visibles
    });

    // Ocultar las opciones al hacer clic fuera de ellas
    $(document).mouseup(function(e) {
        var container = $(".profile-menu");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('#profileOptions').removeClass('show'); // Ocultar opciones de perfil
        }
    });
});
