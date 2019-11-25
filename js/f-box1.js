/*
    1. The image or video elements must have the "f-box" class to properly launch the gallery.
    2. The main image of the project will not attach the controllers. (f-box-main-image)
*/


var fboxElHandlers = {
    "buildElementContainer": function(clickedElementID) {
        var elementContainer = document.getElementById('fbox-element-container')

        elementContainer.style.position = 'fixed';
        elementContainer.height = 'auto';
        elementContainer.style.opacity = 0;
        elementContainer.setAttribute('fbox-element-id', clickedElementID);
    },

    "manageListeners": function(removeListener) {
        if (!removeListener) {
            document.addEventListener('keydown', FBox.prototype.fBoxKeyControllerPress, false);
        } else {
            document.removeEventListener('keydown', FBox.prototype.fBoxKeyControllerPress, false);
        }
    },

    "galleryContainer": function() {
        return document.getElementById('footer1');
    },

    "elementContainer": function() {
        return document.getElementById('fbox-element-container');
    },

    "screen": function() {
        return document.getElementById('fbox-screen');
    },

    "animationDuration": 500
};

var FBox = function(fboxClickedElement) {
    var self = this;

    this.isVideo = fboxClickedElement.getAttribute('type') === 'video';
    this.fboxClickedElement = fboxClickedElement;
    this.setElements();

    if (!this.isVideo) {
        this.elements.fboxElement.addEventListener('load', function() {
            self.setImageDimensions();
        }, false);
    } else {
        self.setImageDimensions();
    }

    if (fboxClickedElement.classList.value.indexOf('f-box-main-image') === -1) {
        this.attachControllers();
    }

    this.appendFBoxElementsToDOM();
    this.openFBox();
};

FBox.prototype.setElements = function() {
    var self = this,
        clickedElement = this.fboxClickedElement,
        elementId = fboxElHandlers["elementId"];

    this["baseMobileDeviceHeight"] = 420;

    this.elements = {};
    this.elements["elementContainer"] = fboxElHandlers.elementContainer();
    this.elements["fboxElement"] = !this.isVideo ?
        self.buildfboxClickedElement(clickedElement.href, elementId) :
        self.buildVideoElement(clickedElement.getAttribute('video-src'), elementId);

    this.elements["bkScreen"] = self.buildWindowScreen();
    this.elements["closeButton"] = self.buidCloseElement();
    this.elements["imageFootnoteText"] = clickedElement.getAttribute('texto');
    this.elements["animationDuration"] = fboxElHandlers.animationDuration;
    this.elements["galleryContainer"] = fboxElHandlers.galleryContainer();
    this.elements["callBack"] = function() {
        self.closeAndRemoveFBox(self.elements);
    }
};

FBox.prototype.setImageDimensions = function() {
    var el = this.elements,
        imageContainer = el.elementContainer,
        image = el.fboxElement;

    imageContainer.style.height = this.getElementDimension()['height'] + 'px';
    imageContainer.style.width = this.getElementDimension()['width'] + 'px';
    image.style.width = '100%';

    this.centerImage(imageContainer, this.getElementDimension()['width'], this.getElementDimension()['height']);

    if (el.fbox_texto) {
        this.setTextDimensions();
    }
};

FBox.prototype.getElementDimension = function() {
    var image = this.elements && this.elements.fboxElement || this.fboxClickedElement,
        ratio = !this.isVideo ? (image.height / image.width) : (720 / 1280),
        height = this.getImageHeight(!this.isVideo ? image.height : 720),
        width = height / ratio,
        imageNewFittedWidth;

    imageNewFittedWidth = this.getImageWidth(width);

    return {
        "width": imageNewFittedWidth || width,
        "height": imageNewFittedWidth ? (imageNewFittedWidth * ratio) : height
    };
};

FBox.prototype.appendFBoxElementsToDOM = function() {
    var el = this.elements,
        closeButton = el.closeButton,
        elementContainer = el.elementContainer,
        screen = el.bkScreen,
        element = el.fboxElement,
        galleryContainer = el.galleryContainer;

    galleryContainer.appendChild(screen);
    elementContainer.appendChild(element);
    elementContainer.appendChild(closeButton);

    if (el.imageFootnoteText) {
        fbox_texto = this.buildFotoTextElementContainer(imageFootnoteText);
        elementContainer.appendChild(fbox_texto);
    }
};

FBox.prototype.openFBox = function() {
    var el = this.elements,
        options = {opacity: 1},
        callBack = el.callBack;

    $(el.elementContainer).animate(options, el.animationDuration, function(){
        el.closeButton.addEventListener('click', callBack, false);
        el.bkScreen.addEventListener('click', callBack, false);
    });
};

FBox.prototype.fBoxKeyControllerPress = function(event) {
    console.log('KEY PRESSED ', event.key);

    if (event.key === 'ArrowRight') {
        keyBoardClickedController = 'fbox-right-controller';
        FBox.prototype.changeElementSRC(event, keyBoardClickedController);
    }
    else if (event.key === 'ArrowLeft') {
        keyBoardClickedController = 'fbox-left-controller';
        FBox.prototype.changeElementSRC(event, keyBoardClickedController);
    }
    else if (event.key === 'Escape') {
        FBox.prototype.closeAndRemoveFBox();
    }
};

FBox.prototype.closeAndRemoveFBox = function() {
    var galleryContainer = fboxElHandlers.galleryContainer(),
        elementContainer = fboxElHandlers.elementContainer(),
        screen = fboxElHandlers.screen(),
        duration = fboxElHandlers.animationDuration;

    $(elementContainer).animate({opacity: 0}, duration, function() {
        elementContainer.innerHTML = '';
        elementContainer.removeAttribute('style');
        galleryContainer.removeChild(screen);
    });

    fboxElHandlers.manageListeners('removeListener');
};

FBox.prototype.getIsMobileDisplay = function() {
    return window.innerWidth < 500 || window.innerHeight < this.baseMobileDeviceHeight + 1;
};

FBox.prototype.getImageHeight = function (imageHeight) {
    var windowInnerHeight = window.innerHeight,
        imageHeight = imageHeight,
        height = imageHeight,
        heightDifference,
        topGap = this.getTopGap();

    if (imageHeight < windowInnerHeight) {
        heightDifference = windowInnerHeight - imageHeight;
    }

    if (imageHeight >= windowInnerHeight || heightDifference <= topGap) {
        height = windowInnerHeight - topGap;
    }

    return height;
};

FBox.prototype.getTopGap = function() {
    var isMobileDisplay = this.getIsMobileDisplay();

    if (isMobileDisplay && window.innerHeight < this.baseMobileDeviceHeight + 1) {
        return 75;
    } else if (isMobileDisplay && window.innerHeight > this.baseMobileDeviceHeight) {
        return 150;
    }

    return 200;
};

FBox.prototype.getImageWidth = function (elementWidth) {
    var windowInnerWidth = window.innerWidth,
        isMobileDisplay = this.getIsMobileDisplay(),
        widthDifference,
        widthGap;

    if (elementWidth < windowInnerWidth) {
        widthDifference = windowInnerWidth - elementWidth;
    }

    widthGap = isMobileDisplay ? 80 : 150;

    if (elementWidth >= window.innerWidth || widthDifference < widthGap){
        return windowInnerWidth - widthGap;;
    }
};

FBox.prototype.setTextDimensions = function() {
    var w_ventana = window.innerWidth,
        h_ventana = window.innerHeight;

    if (w_ventana < 700 && w_ventana > 500){
        fbox_texto.style.fontSize = '12px';
    } else if (w_ventana < 501){
        fbox_texto.style.fontSize = '11px';
    }

    if (h_ventana < 500){
        fbox_texto.style.fontSize = '11px';
    }
};

FBox.prototype.centerImage = function(imageContainer, width, height) {
    var windowInnerWidth = window.innerWidth,
        windowInnerHeight = window.innerHeight,
        bottomPosition,
        topPosition;

    topPosition = windowInnerHeight - height;
    bottomPosition = windowInnerWidth - width;

    imageContainer.style.top = Math.floor(topPosition) / 2 + 'px';
    imageContainer.style.left = Math.floor(bottomPosition) / 2 + 'px';
};

FBox.prototype.buildWindowScreen = function() {
    var screen = document.createElement('div');

    screen.id = 'fbox-bkScreen';
    screen.style.position = 'fixed';
    screen.style.top = 0;
    screen.id = 'fbox-screen';
    screen.style.width = '100%';
    screen.style.height = '100%';
    screen.style.backgroundColor = 'black';
    screen.style.opacity = .8;
    screen.style.cursor = 'pointer';

    return screen;
};

FBox.prototype.attachControllers = function() {
    var i = 0,
        self = this;

    while (i < 2) {
        var controller = document.createElement('DIV');

        controller.id = i === 0 ? 'fbox-right-controller' : 'fbox-left-controller';
        controller.style.backgroundColor = 'black';
        controller.style.cursor = 'pointer';
        controller.style.position = 'absolute';
        controller.style.left = i === 0 ? '100%' : 0;
        controller.style.backgroundImage = i === 0 ? 'url("imagenes/flecha-siguiente.png")' : 'url("imagenes/flecha-anterior.png")';
        controller.style.backgroundSize = '100%';
        controller.style.zIndex = i === 0 ? 2 : 3;
        controller.style.opacity = 0.8;

        self.setControllersDimensions(i, controller);
        controller.addEventListener('click', self.changeElementSRC.bind(self));

        self.elements.elementContainer.appendChild(controller);

        i++;
    }
};

FBox.prototype.setControllersDimensions = function(i, controller) {
    var widthHeight = window.innerWidth < 801 ? '30px' : '40px';

    controller.style.top = '50%';
    controller.style.width = widthHeight;
    controller.style.height = widthHeight;
    controller.style.marginTop = window.innerWidth < 801 ? '-15px' : '-20px';;
    controller.style.marginLeft = i === 0 ? '-55px' : '15px';

    if (window.innerWidth < 801) {
        controller.style.marginLeft = i === 0 ? '-35px' : '5px';
    }
};

FBox.prototype.changeElementSRC = function(event, controller) {
    var clickedController = controller || event.target.id,
        collectionLastElementID = fboxElHandlers.collection.length - 1,
        currentElemetID = fboxElHandlers['clickedElementID'],
        nextElementId;

    nextElementId = currentElemetID === 0 ? collectionLastElementID : currentElemetID - 1;

    if (clickedController === 'fbox-right-controller') {
        nextElementId = currentElemetID === collectionLastElementID ? 0 : currentElemetID + 1;
    }

    fboxElHandlers['clickedElementID'] = nextElementId;
    document.getElementById('fbox-img').src = fboxElHandlers.collection[nextElementId].getAttribute('video-src');
};

FBox.prototype.buildFotoTextElementContainer = function(textNode) {
    var fbox_texto = document.createElement("div"),
        eltexto = document.createTextNode(textNode);

    fbox_texto.id = 'fbox-texto';
    fbox_texto.style.width = '96%';
    fbox_texto.style.height = 'auto';
    fbox_texto.style.padding = '15px 2% 15px 2%';
    fbox_texto.style.textAlign = 'center';
    fbox_texto.style.fontFamily = 'Arial';
    fbox_texto.style.fontSize = '13px';
    fbox_texto.style.fontWeight = 100;
    fbox_texto.style.color = 'white';

    fbox_texto.appendChild(eltexto);

    return fbox_texto;
};

FBox.prototype.buildVideoElement = function(videoSRC, elementId) {
    var fboxElement = document.createElement("IFRAME");

    fboxElement.id = 'fbox-img';
    fboxElement.setAttribute('element-id', elementId);
    fboxElement.src = videoSRC;
    fboxElement.width = this.getElementDimension().width;
    fboxElement.height = this.getElementDimension().height;
    fboxElement.setAttribute('webkitallowfullscreen', '');
    fboxElement.setAttribute('mozallowfullscreen', '');
    fboxElement.setAttribute('allowfullscreen', '');
    fboxElement.setAttribute('frameborder', 0);

    return fboxElement;
};

FBox.prototype.buildfboxClickedElement = function(imageSource) {
    var fboxElement = document.createElement("img");

    fboxElement.id = 'fbox-img';
    fboxElement.src = imageSource;
    fboxElement.style.position = 'relative';

    return fboxElement;
};

FBox.prototype.buidCloseElement = function() {
    var closeButton = document.createElement("div"),
        isMobileDisplay = this.getIsMobileDisplay(),
        baseDimention = isMobileDisplay ? 35 : 50;

    closeButton.style.position = 'absolute';
    closeButton.style.width = baseDimention + 'px';
    closeButton.style.height = baseDimention + 'px';
    closeButton.style.top = -(baseDimention + 5) + 'px';
    closeButton.style.right = '0';
    closeButton.style.cursor = 'pointer';
    closeButton.style.backgroundImage = 'url("imagenes/cerrar.png")';
    closeButton.style.backgroundSize = '100%';

    return closeButton;
};

function buildFBox(event) {
    var fbox = event.target;

    if (fbox.nodeName == 'IMG') {
        fbox = fbox.parentElement;
    }

    var clickedElementID = Number(fbox.getAttribute('fbox-element-id'));

    fboxElHandlers.collection = event.currentTarget.querySelectorAll('.f-box');

    event.preventDefault();
    fboxElHandlers.buildElementContainer(clickedElementID);
    fboxElHandlers['clickedElementID'] = clickedElementID;
    fboxElHandlers.itemsLength = '';

    new FBox(fbox);
    fboxElHandlers.manageListeners();
}

(function loadFBox() {
    var fBoxGalleryCollection = document.getElementsByClassName("f-box-gallery");

	for (i = 0; i < fBoxGalleryCollection.length; i++) {
		fBoxGalleryCollection[i].addEventListener('click', buildFBox, false);
	}
})();

window.addEventListener('resize', function(){
    var elementContainer = document.getElementById('fbox-element-container'),
        screen = document.getElementById('fbox-screen'),
        galleryContainer = fboxElHandlers.galleryContainer();

    if (screen && elementContainer) {
        galleryContainer.removeChild(elementContainer);
        galleryContainer.removeChild(screen);
    }
}, false);


