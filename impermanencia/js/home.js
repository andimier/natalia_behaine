function toggleDescription(e) {
    var text = 'ver más';
    var description_container = e.target.previousElementSibling;

    description_container.classList.toggle('visible');

    if (description_container.classList.contains('visible')) {
        text = 'cerrar';
    }

    e.target.innerText = text;
}

var home_init = (function() {
    var service_buttons = document.querySelectorAll('button');

    service_buttons.forEach(function(item) {
        item.addEventListener('click', toggleDescription);
    });
})();