// Añade esto a tu archivo scripts.js

window.addEventListener('scroll', function() {
    var header = document.querySelector('header');
    var sticky = header.offsetTop;

    if (window.pageYOffset > sticky) {
        header.classList.add('sticky');
    } else {
        header.classList.remove('sticky');
    }
});