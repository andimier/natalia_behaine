function getParamVal(param) {
    var search = window.location.search && window.location.search.replace(/\?/, '');

    if (search && search.includes(param)) {
        var params = search.split('=');
        var index = params.indexOf(param);

        return params[index];
    }

    return;
}

var RCode = function() {
    this.data = null;
    this.slotId = getParamVal('slot-id');
    this.clientId = "YBHIWwITTjKnvjQrHcl9Rw";
    this.redirectUri = "http://www.nataliabehaine.com/impermanencia/api/meetings/request-auth.php";

    /**
     * Test options!!!
     */
    this.isTest = true;
    this.testRedirectUri = "http://localhost/nataliabehaine/dev-nataliabehaine/impermanencia/api/meetings/request-auth.php";
    // this.testRedirectUri = "http://www.andimier.com/apitests/meetings/request-auth.php";
}

RCode.prototype.getSlotEntry = function() {
    var _this = this;
    var xhr = new XMLHttpRequest();
    
    xhr.addEventListener("readystatechange", function() {
        if (this.readyState === this.DONE) {
            var response = this.responseText;

            if (response) {
                console.log('Esta es la respuesta: ', response);

            _this.requestAuth(response);

            } else {
                console.warn('invalid data');
            }
        }
    });

    if (this.slotId) {
        var formatData = new FormData();
        formatData.append('slot-id', this.slotId);
        formatData.append('rq-type', 'client');
    
        xhr.open("POST", "crud/rw-slot-data.php");
        xhr.send(formatData);
    }
}

RCode.prototype.requestAuth = function(data) {
    
    if (data.state === 'blocked') {
        console.warn('Meeting is blocked');
        return;
    }

    this.tryCreateMeeting();
}

RCode.prototype.tryCreateMeeting = function() {

    var baseUri = this.redirectUri;

    if (this.isTest) {
        baseUri = this.testRedirectUri;
    }

    var redirectParams = [
        "slot-id:" + this.slotId,
        "payer-id:" + getParamVal('payer-id'),
        "meeting-id:" + getParamVal('meeting-id')
    ].join(',');

    var redirectUri =  baseUri + "&state=slot-id:" + redirectParams;

    var params = [
        "response_type=code",
        "client_id=" + this.clientId,
        "redirect_uri=" + redirectUri
    ].join('&');
    
    var url = "https://zoom.us/oauth/authorize?" + params;
    
    console.log('Redirigiendo a: ', url);
    window.location = url;
}

var initiCodeRequst = (function () {
    var rCode = new RCode();
    rCode.getSlotEntry();
})();

