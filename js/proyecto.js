var cntp = document.getElementById('cntp'),
    video = document.getElementsByClassName('video'),
    tarjeta_prg = document.getElementsByClassName('tarjeta_prg'),
    cnt_txt_prg = document.getElementsByClassName('cnt_txt_prg'),
    txt_prg = document.getElementsByClassName('txt_prg'),
    img_prg = document.getElementsByClassName('img_prg'),
    video = document.getElementsByClassName('video'),
    ratioV = 1.77;

function ajusteCntTituloEImagen() {
    // ALTURA DEL CONTENEDOR DE LA IMAGEN, TITLO Y SINOPSIS DE LA OBRA

    var laImagen = document.getElementById('prg-img'),
        ratio = laImagen.naturalWidth / laImagen.naturalHeight,
        nuevoalto = img_prg[0].offsetWidth / ratio;

    if (window.innerWidth > 800) {
        //tarjeta_prg[0].style.height = nuevoalto + 'px';
        img_prg[0].style.height = nuevoalto + 'px';
        txt_prg[0].style.height = nuevoalto + 'px';
    } else {
        img_prg[0].style.height = nuevoalto + 'px';
        txt_prg[0].style.height = 'auto';
        //tarjeta_prg[0].style.height = (img_prg[0].offsetHeight + txt_prg[0].offsetHeight + 50) + 'px';
    }
}

function ajustarEstilosDelVideo() {
    if (video.length) {
        video[0].style.height = video[0].offsetWidth / ratioV + 'px';
	}
}

function asignarEstilosAimagenes() {
    var $foto = $('.foto'),
        margen,
        margenF;

    if ($foto.length) {
        margen = $foto.first().css('margin-left');
        margenF = margen.replace('px', ''),
        altura = $foto.first().width();

        $('.foto').each(function(i, val){
            $(this).css({
                "marginTop": Math.floor(margenF * 2) + 'px',
                "height": Math.floor(altura) + 'px'
            })
        });
    }

    ajusteCntTituloEImagen();
    ajustarEstilosDelVideo();
}

function loadGallery() {
    var target = event.target;

    if (!target.classList.contains('load-gallery-btn')) {
        return;
    }

    window.location = target.dataset.href;
}

function init() {
    document.querySelector('#cnt_galeria').addEventListener('click', loadGallery);
}

(function setPageTitle() {
    document.querySelectorAll('title')[0].innerHTML = document.getElementsByClassName('txt_prg')[0].children[0].innerText + document.querySelectorAll('title')[0].innerHTML;
})();

window.addEventListener('load', function() {
    asignarEstilosAimagenes();
    init();
});

function reordenar() {
    asignarEstilosAimagenes();
}

window.addEventListener('resize', reordenar, false);
