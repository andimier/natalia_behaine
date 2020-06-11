function getParamVal(param) {
    var search = window.location.search && window.location.search.replace(/\?/, '');

    if (search && search.includes(param)) {
        var param = search.split('=');

        return param[1];
    }

    return;
}

var Meeting = function() {
    this.data = null;
    this.slotId = getParamVal('slot-id');

    this.redirectCrateMeetingUrl = "http://www.nataliabehaine.com/impermanencia/api/meetings/cm.html";
    this.redirectIncludeInMeetingUrl = "http://www.nataliabehaine.com/impermanencia/api/meetings/im.html";

    this.testRedirectCrateMeetingUrl = "http://www.andimier.com/apitests/meetings/cm.html";
    this.testRedirectIncludeInMeetingUrl = "http://www.andimier.com/apitests/meetings/im.html";

    this.clientId = "YBHIWwITTjKnvjQrHcl9Rw";
}

Meeting.prototype.getSlotEntry = function() {
    var _this = this;
    var xhr = new XMLHttpRequest();
    
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === this.DONE) {
            var response = this.responseText;

            if (response) {
                var data = JSON.parse(response);
                console.log('Esta es la respuesta: ', data);

            _this.requestAuth(data);

            } else {
                console.warn('invalid data');
            }
        }
    });

    if (this.slotId) {
        var formatData = new FormData();
        formatData.append('slot-id', this.slotId);
    
        xhr.open("POST", "test.php");
        // xhr.setRequestHeader("content-type", "application/json");
        xhr.send(formatData);
    }
}

Meeting.prototype.includeInMeeting = function() {
    var redirectUri = this.testRedirectIncludeInMeetingUrl + "&state=slot-id:" + this.slotId;
    var params = [
        "response_type=code",
        "client_id=" + this.clientId,
        "redirect_uri=" + redirectUri
    ];

    var url = "https://zoom.us/oauth/authorize?" + params.join('&');
    
    console.log('Redirigiendo a: ', url);
}

Meeting.prototype.createMeeting = function() {
    var redirectUri = this.testRedirectCrateMeetingUrl + "&state=" + JSON.stringify({'slot-id':this.slotId});
    var params = [
        "response_type=code",
        "client_id=" + this.clientId,
        "redirect_uri=" + redirectUri
    ].join('&');
    
    var url = "https://zoom.us/oauth/authorize?" + params;
    
    console.log('Redirigiendo a: ', url);
    window.location = url;
}

Meeting.prototype.requestAuth = function(data) {
    
    var utl;
    

    /**
     * Es grupal
     * consultar si ya existe el id de la reunión en la bd
     * si ya existe un id, enviar query param createMeeting = false o, redirigir a /meeting/cmf
     * si no existe un id, enviar query param createMeeting = true o, redirigir a /meeting/cmv
     * */

    if (data.state === 'blocked') {
        console.warn('Meeting is blocked');
        return;
    }

    if (data.type === 'group' && data.meeting_id.length) {
        this.includeInMeeting();
    } else {
        /**
         * Si no es grupal:
         * Crear la reunión: redirigir a z/auth/cmv
         */
        this.createMeeting();

    }
}

var initiMettingFlow = (function () {
    var meeting = new Meeting();
    meeting.getSlotEntry();
})();

