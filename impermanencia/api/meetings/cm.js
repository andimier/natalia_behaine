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

    this.encodedBearer = "WUJISVd3SVRUaktudmpRckhjbDlSdzpEbFh3SEJSREdFWW1ucnNDQUVSSjJ3dTlHNEhCbTIyQQ=="
}

TokenAuth.prototype.getToken = function() {
    var _this = this;
    var code = getParamVal('code');

    params = [
        "grant_type=authorization_code",
        "code=" + code,
        "redirect_uri=" + this.testRedirectCrateMeetingUrl
    ].join('&');

    var url = this.urlHost + params;

    var xhr = new XMLHttpRequest();
    var apiTokenCallbak = this.apiTokenCallbak;
    xhr.withCredentials = true;
    xhr.addEventListener("readystatechange", apiTokenCallbak.bind(_this));
    xhr.open("POST", url);
    xhr.setRequestHeader("authorization", "Basic " + this.encodedBearer);

    xhr.send();
}

TokenAuth.prototype.apiTokenCallbak = function() {
    if (this.readyState === this.DONE) {
        debugger
        console.log(this.responseText);
    }
}

var initApiToken = (function() {
    var tokenAuth = new TokenAuth();
    var toke = tokenAuth.getToken();
})();




