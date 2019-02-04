if (!Array.prototype.filter)
    Array.prototype.filter = function(func, thisArg) {
    'use strict';

    if ( ! ((typeof func === 'Function') && this) )
        throw new TypeError();

    var len = this.length >>> 0,
        res = new Array(len), // preallocate array
        c = 0, i = -1;
    if (thisArg === undefined)
      while (++i !== len)
        // checks to see if the key was set
        if (i in this)
          if (func(t[i], i, t))
            res[c++] = t[i];
    else
      while (++i !== len)
        // checks to see if the key was set
        if (i in this)
          if (func.call(thisArg, t[i], i, t))
            res[c++] = t[i];

    res.length = c; // shrink down array to proper size
    return res;
};

function getDescriptionTextArray(descriptionText) {
    var BREAK_LINE_EXPRESSION = /<br \/><br \/>/g,
        REPLACEMENT_STRING = '<br><br>',
        hasBRTagSafeCheck = descriptionText.match(BREAK_LINE_EXPRESSION) !== null,
        formattedString;

    if (hasBRTagSafeCheck) {
        formattedString = descriptionText.replace(BREAK_LINE_EXPRESSION, REPLACEMENT_STRING);

        return formattedString.split(REPLACEMENT_STRING);
    }

    return descriptionText.split(REPLACEMENT_STRING);
}

function getDefaultText(descriptionTextArray) {
    return descriptionTextArray.filter(function(string, i) {
        return i < 3;
    }).join('<br><br>');
}

function getExtraText(descriptionTextArray) {
    return descriptionTextArray.filter(function(string, i) {
        return i > 2;
    });
}

function getExtratextInsideInitialString (descriptionText, extraTextList) {
    var extraText;

    if (extraTextList.length > 1) {
        extraText = extraTextList.join('<br><br>');
    } else {
        extraText = extraTextList[0];
    }

    return descriptionText.substr(descriptionText.indexOf(extraText), descriptionText.length -1);
}

function setTextsInDocument(descriptionTextArray) {
    var defaultText = getDefaultText(descriptionTextArray),
        extraTextList = getExtraText(descriptionTextArray),
        extraText = getExtratextInsideInitialString(descriptionText, extraTextList),
        extraTextContainer;

    document.getElementById('txt-fragmento1').innerHTML = defaultText;
    document.getElementById('extra-text-container').innerHTML = '<br>' + extraText;
}

(function() {
    var descriptionTextArray = getDescriptionTextArray(descriptionText),
        extraTextButton;

    if (descriptionTextArray.length > 3) {
        setTextsInDocument(descriptionTextArray);
        extraTextButton = document.getElementById('extra-text-button');
        extraTextButton.style.display = 'block';

    } else {
        document.getElementById('txt-fragmento1').innerHTML = descriptionText;
    }
})();

$extraTextButton = $('#extra-text-button')
if ($extraTextButton.css('display') === 'block') {
    $extraTextButton.click(function() {
        $('#extra-text-container').stop().toggle(250, function() {
            buttonText = ($(this).css('display') === 'none') ? buttonTextClosed : buttonTextOpened;
            $extraTextButton.text(buttonText);
        });
    });
}

