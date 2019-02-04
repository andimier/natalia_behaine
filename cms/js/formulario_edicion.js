var preEnteredTextContent,
    botonPegar,
    botonCompletar,
    preEnteredHTML,
    isEditBoxOpen,
    boton1,
    caja1,
    texto;

function removeCopyPaste() {
    $('#caja1').bind('copy paste', function(e) {
        e.preventDefault();

        return false;
    });
}

function createTextNodeForEditBox2() {
    if (!isEditBoxOpen) {
        preEnteredHTML = caja1.innerHTML;
        document.getElementById('caja2').innerHTML = preEnteredHTML;
        isEditBoxOpen = true;
    } else {
        isEditBoxOpen = false;
    }
}

function abrirCampoPegar(){
    botonPegar.removeEventListener('click', abrirCampoPegar, false);

    $('#caja1').animate( {marginTop:'-415px'}, function(){
        botonPegar.innerHTML = 'Cerrar';
        botonPegar.style.backgroundColor = '#000';
        botonPegar.style.color = '#fff';
        botonCompletar.style.display = 'block';
        boton1[0].style.display = 'none';

        botonPegar.addEventListener('click', closePasteEditField, false);
    });
}

function closePasteEditField(){
    $('#caja1').animate( {marginTop:'0px'}, function(){
        botonPegar.innerHTML = 'Pegar desde Word';
        botonPegar.style.backgroundColor = '#ccc';
        botonPegar.style.color = '#000';
        botonCompletar.style.display = 'none';
        boton1[0].style.display = 'block';

        botonPegar.addEventListener('click', abrirCampoPegar, false);
        botonPegar.removeEventListener('click', closePasteEditField, false);
    });
}

function replaceHTMHLTags(textBoxInnerText) {
    var output = textBoxInnerText,
        tagsReplacements,
        replaceText;

    tagsReplacements = {
        "generalHTMLTags": /<(?!a\shref|\/a>|br>|br\s\/>|u>|\/u>|b>|\/b>)[^><]*>/g, //seleccionar solo si < no está seguido de X o Y o Z o ....
        "spaces": /\b\s+/g,
        "target": /target="[\w]+"/g,
        "stylesInsideLinkTags": /style="[^"]+"/g,
        "multipleSpaces": /\s\s+/g
    };

    for (var prop in tagsReplacements) {
        switch (prop) {
            case "generalHTMLTags":
                output = textBoxInnerText.replace(tagsReplacements[prop], '');
                break
            case "spaces":
                output = output.replace(tagsReplacements[prop], ' ');
                break;
            case "target":
                output = output.replace(tagsReplacements[prop], 'target="_blank"');
                break;
            case "stylesInsideLinkTags":
                output = output.replace(tagsReplacements[prop], '');
                break;
            default:
                output = output.replace(tagsReplacements[prop], '<br>');
        }
    }

    return output;
}

function removeLineBreaks(formattedString) {
    var output = formattedString,
        newLinesReplacements = [/\n/g, /\r/g, /\v/];

    for (var i = 0; i < newLinesReplacements.length; i++){
        output = output.replace(newLinesReplacements[i], '<br>');
    }

    return output;
}

function stripTextFormat(){
    var newText = document.getElementById('caja2').innerHTML,
        formattedString,
        output;

    formattedString = replaceHTMHLTags(newText);
    output = removeLineBreaks(formattedString);

    caja2.innerHTML = output;
    caja1.innerHTML = output;
}

function submit_form(){
    var elFormulario = document.getElementById("formularioedicion1"),
        contenido = caja1.innerHTML;

    contenido = contenido.replace(/<div>/g, '<br>');
    contenido = contenido.replace(/<\/div>/g, '');
    contenido = contenido.replace(/<div>\s+/g, '');

    elFormulario.elements["areadetexto"].value = contenido;
    elFormulario.submit();
}

function getPreEnteredTextContent() {
    return document.getElementById('caja1').textContent;
}

(function() {
    caja1 = document.getElementById('caja1'),
    isEditBoxOpen = false;
    preEnteredTextContent = getPreEnteredTextContent();
    botonPegar = document.getElementById('btn_pegar');
    botonCompletar = document.getElementById('btn_completar');
    boton1 = document.getElementsByClassName('boton1');

    botonPegar.addEventListener('click', function() {
        createTextNodeForEditBox2();
        abrirCampoPegar();
    }, false);

    caja1.contentEditable = true;

    removeCopyPaste();
})();

