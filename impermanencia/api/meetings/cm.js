/**
 * Obtengo el código
 * 
 */

function getParamVal(param) {
    var search = window.location.search && window.location.search.replace(/\?/, '');

    if (search && search.includes(param)) {
        var param = search.split('=');

        return param[1];
    }

    return;
}

var TokenAuth = function() {
    this.urlHost = "https://zoom.us/oauth/token?";
    this.clientID = "YBHIWwITTjKnvjQrHcl9Rw";
    this.clientSecret = "DlXwHBRDGEYmnrsCAERJ2wu9G4HBm22A";

    this.redirectCrateMeetingUrl = "http://www.nataliabehaine.com/impermanencia/api/meetings/cm.html";
    this.redirectIncludeInMeetingUrl = "http://www.nataliabehaine.com/impermanencia/api/meetings/im.html";

    this.testRedirectCrateMeetingUrl = "http://www.andimier.com/apitests/meetings/cm.html";
    this.testRedirectIncludeInMeetingUrl = "http://www.andimier.com/apitests/meetings/im.html";

    this.encodedBearer = "Basic WUJISVd3SVRUaktudmpRckhjbDlSdzpEbFh3SEJSREdFWW1ucnNDQUVSSjJ3dTlHNEhCbTIyQQ=="
}

TokenAuth.prototype.getToken = function() {
    var _this = this;
    // var code = getParamVal('code');
    var code = "SU7udLm5ql_q2jGIzNcQoW4kJIsBRhOOQ";

    params = [
        "grant_type=authorization_code",
        "code=" + code,
        "redirect_uri=" + this.testRedirectIncludeInMeetingUrl
    ].join('&');


    var url = this.urlHost + params;

    var xhr = new XMLHttpRequest();
    var apiTokenCallbak = this.apiTokenCallbak;
    // xhr.withCredentials = true;
    // xhr.addEventListener("readystatechange", apiTokenCallbak);
    xhr.addEventListener("readystatechange", function() {
        if (this.readyState === this.DONE) {
            debugger
            console.log(this.responseText);
        }
    });
    xhr.open("POST", "https://zoom.us/oauth/token?grant_type=authorization_code&code=2xm7gFp2tx_q2jGIzNcQoW4kJIsBRhOOQ&redirect_uri=http://www.andimier.com/apitests/meetings/cm.html");
    // xhr.open("POST", url);
    xhr.setRequestHeader("content-type", "application/json");
    xhr.setRequestHeader("Authorization", "Basic WUJISVd3SVRUaktudmpRckhjbDlSdzpEbFh3SEJSREdFWW1ucnNDQUVSSjJ3dTlHNEhCbTIyQQ==");
    // xhr.setRequestHeader("Access-Control-Allow-Origin", this.testRedirectIncludeInMeetingUrl);

    xhr.send('token');
}

TokenAuth.prototype.apiTokenCallbak = function(response) {
    if (this.readyState === this.DONE) {
        debugger
        console.log(this.responseText);
    }
}

var initApiToken = (function() {debugger
    var dataContainer = document.querySelector('#data-container');

    if (dataContainer) {
        var data = dataContainer.dataset.requestData && data.length > 0;

        if ($data === 'invalid_request') {
            console.warn('invalid_request');
            return 
        } else {
            // make request
        }
    }
    
})();




