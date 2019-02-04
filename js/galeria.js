var foto = document.getElementsByClassName('foto');

function setStyles() {
    var margen = $('.foto').first().css('margin-left'),
    margenF = margen.replace('px', '');

    for( f = 0; f < foto.length; f++ ){
        foto[f].style.height = foto[0].offsetWidth + 'px';
    }

    $('.foto').each(function(){
        $(this).css({ marginTop : margenF *2 +'px'})
    });
}

window.addEventListener('resize', setStyles ,false);
setStyles();
