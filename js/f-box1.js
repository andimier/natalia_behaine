var fBoxCollection = {};

var FBox = function(imageElement) {
    var self = this;

    this.isVideo = imageElement.getAttribute('type') === 'video';
    this.imageElement = imageElement;
    this.setElements(imageElement);

    if (imageElement.getAttribute('type') !== 'video') {
        this.elements.fbox_img.addEventListener('load', function() {
            self.setImageDimensions();
        }, false);
    } else {
        self.setImageDimensions();
    }
};

FBox.prototype.setElements = function(imageElement) {
    var self = this,
        elementId = Number(imageElement.id);

    this["baseMobileDeviceHeight"] = 420;
    this["elementId"] = elementId;

    this.elements = {
        "fbox_img": !this.isVideo ? self.buildImageElement(imageElement.href, elementId) : self.buildVideoElement(imageElement.getAttribute('video-src'), elementId),
        "fbox_image_container": self.buildFotoElement(elementId),
        "pantalla": self.buildWindowScreen(),
        "fbox_cerrar": self.buidCloseElement(),
        "imageFootnoteText": imageElement.getAttribute('texto'),
        "animationDuration": 500,
        "callBack": function() {
            self.closeAndRemoveFBox(self.elements);
        }
    }

    
    self.attachControllers();
};

FBox.prototype.setImageDimensions = function() {
    var elements = this.elements,
        imageContainer = elements.fbox_image_container,
        image = elements.fbox_img;

    imageContainer.style.height = this.getElementDimension()['height'] + 'px';
    imageContainer.style.width = this.getElementDimension()['width'] + 'px';
    image.style.width = '100%';

    this.centerImage(imageContainer, this.getElementDimension()['width'], this.getElementDimension()['height']);

    if (elements.fbox_texto) {
        this.setTextDimensions();
    }

    this.appendFBoxElementsToDOM();
    this.openFBox();
};

FBox.prototype.getElementDimension = function() {
    var image = this.elements && this.elements.fbox_img || this.imageElement,
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
    var elements = this.elements

    document.body.appendChild(elements.pantalla);
    elements.fbox_image_container.appendChild(elements.fbox_cerrar);
    elements.fbox_image_container.appendChild(elements.fbox_img);
    document.body.appendChild(elements.fbox_image_container);

    if (elements.imageFootnoteText) {
        fbox_texto = this.buildFotoTextElementContainer(imageFootnoteText);
        fbox_image_container.appendChild(fbox_texto);
    }
};

FBox.prototype.openFBox = function() {
    var elements = this.elements,
        options = {opacity: 1},
        callBack = elements.callBack;

    $(this.elements.fbox_image_container).animate(options, elements.animationDuration, function(){
        elements.fbox_cerrar.addEventListener('click', callBack, false);
        elements.pantalla.addEventListener('click', callBack, false);
    });
};

FBox.prototype.closeAndRemoveFBox = function(elements) {
    var imageContainer = document.getElementById('fbox-element-container'),
        pantalla = document.getElementById('fbox-screen'),
        duration = elements.animationDuration;

    $(imageContainer).animate({opacity: 0}, duration, function() {
        document.body.removeChild(imageContainer);
        document.body.removeChild(pantalla);
    });
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

    screen.id = 'fbox-pantalla';
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

FBox.prototype.buildFotoElement = function(elementId) {
    var fbox_image_container = document.createElement("div");

    fbox_image_container.style.position = 'fixed';
    fbox_image_container.id = 'fbox-element-container';
    fbox_image_container.height = 'auto';
    fbox_image_container.style.opacity = 0;
    fbox_image_container.setAttribute('fbox-element-id', elementId);

    return fbox_image_container;
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

        self.elements.fbox_image_container.appendChild(controller);

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

FBox.prototype.changeElementSRC = function() {
    var clickedController = event.target.id,
        collectionLength = fBoxCollection.collection.length,
        nextElementId = this.elementId === 0 ? collectionLength -1 : this.elementId - 1;

    if (clickedController === 'fbox-right-controller') {
        nextElementId = this.elementId === collectionLength -1 ? 0 : this.elementId + 1;
    }

    this.elementId = nextElementId;
    document.getElementById('fbox-img').src = fBoxCollection.collection[nextElementId].getAttribute('video-src');
}

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
    var fbox_img = document.createElement("IFRAME");

    fbox_img.id = 'fbox-img';
    fbox_img.setAttribute('element-id', elementId);
    fbox_img.src = videoSRC;
    fbox_img.width = this.getElementDimension().width;
    fbox_img.height = this.getElementDimension().height;
    fbox_img.setAttribute('allow', 'autoplay; fullscreen');
    fbox_img.style.position = 'relative';
    fbox_img.style.border = 'none';

    return fbox_img;
    /*
    <iframe
        src="https://player.vimeo.com/video/95900092?app_id=122963"
        width="640"
        height="360"
        frameborder="0"
        title="CarroYa"
        allow="autoplay; fullscreen"
        allowfullscreen>
        */
};

FBox.prototype.buildImageElement = function(imageSource) {
    var fbox_img = document.createElement("img");

    fbox_img.id = 'fbox-img';
    fbox_img.src = imageSource;
    fbox_img.style.position = 'relative';

    return fbox_img;
};

FBox.prototype.buidCloseElement = function() {
    var fbox_cerrar = document.createElement("div"),
        isMobileDisplay = this.getIsMobileDisplay(),
        baseDimention = isMobileDisplay ? 35 : 50;

    fbox_cerrar.style.position = 'absolute';
    fbox_cerrar.style.width = baseDimention + 'px';
    fbox_cerrar.style.height = baseDimention + 'px';
    fbox_cerrar.style.top = -(baseDimention + 5) + 'px';
    fbox_cerrar.style.right = '0';
    fbox_cerrar.style.cursor = 'pointer';
    fbox_cerrar.style.backgroundImage = 'url("imagenes/cerrar.png")';
    fbox_cerrar.style.backgroundSize = '100%';

    return fbox_cerrar;
};

function buildFBox(event) {
    var fbox;

    event.preventDefault();
    fbox = new FBox(this);
}

(function loadFBox() {
    var fBoxGalleryCollection = document.getElementsByClassName("f-box");

    fBoxCollection.collection = fBoxGalleryCollection;

	for (i = 0; i < fBoxGalleryCollection.length; i++) {
		fBoxGalleryCollection[i].addEventListener('click', buildFBox, false);
	}
})();

window.addEventListener('resize', function(){
    var imageContainer = document.getElementById('fbox-element-container'),
        pantalla = document.getElementById('fbox-screen');

    if (imageContainer) {
        document.body.removeChild(imageContainer);
        document.body.removeChild(pantalla);
    }
}, false);


