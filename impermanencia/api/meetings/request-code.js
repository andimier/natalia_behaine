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

    this.redirectCrateMeetingUrl = "http://www.nataliabehaine.com/impermanencia/api/meetings/request-auth.php";
    this.testRedirectCrateMeetingUrl = "http://www.andimier.com/apitests/meetings/request-auth.html";

    this.clientId = "YBHIWwITTjKnvjQrHcl9Rw";
}

Meeting.prototype.getSlotEntry = function() {
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
    
        xhr.open("POST", "crud/rw-slot-data.php");
        xhr.send(formatData);
    }
}

Meeting.prototype.tryCreateMeeting = function() {
    var redirectUri = this.testRedirectCrateMeetingUrl + "&state=slot-id':" + this.slotId;
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
    
    if (data.state === 'blocked') {
        console.warn('Meeting is blocked');
        return;
    }

    this.tryCreateMeeting();
}

var initiMettingFlow = (function () {
    var meeting = new Meeting();
    meeting.getSlotEntry();
})();

