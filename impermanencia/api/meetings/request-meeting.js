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

var APIUsers = function(data) {
    this.url = "https://api.zoom.us/v2/users/";
    this.access_token = data;
}

APIUsers.prototype.getUserId = function() {
    var _this = this;

    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();

        // xhr.addEventListener("readystatechange", _this.sendUserId);
        xhr.addEventListener("readystatechange", function() {
            if (this.readyState === this.DONE) {debugger
                resolve(this.responseText);
            } else {
                reject('no users data');
            }
        });

        xhr.open("POST", _this.url);
        xhr.setRequestHeader("content-type", "application/json");
        xhr.setRequestHeader("Authorization", "Bearer " + _this.access_token);
        xhr.send(null);
    
        // setTimeout(function() {
        //     _this.sendUserId(resolve);
        // }, 3000);
    });
}

APIUsers.prototype.sendUserId = function(resolve) {
    if (this.readyState === this.DONE) {
        console.log(this.responseText);
        resolve('completada');
    }
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
    var code = "SU7udLm5ql_q2jGIzNcQoW4kJIsBRhOOQ";

    params = [
        "grant_type=authorization_code",
        "code=" + code,
        "redirect_uri=" + this.testRedirectIncludeInMeetingUrl
    ].join('&');

    var url = this.urlHost + params;

    var xhr = new XMLHttpRequest();

    xhr.withCredentials = true;
    xhr.addEventListener("readystatechange", function() {
        if (this.readyState === this.DONE) {
            debugger
            console.log(this.responseText);
        }
    });
    xhr.open("POST", "https://zoom.us/oauth/token?grant_type=authorization_code&code=2xm7gFp2tx_q2jGIzNcQoW4kJIsBRhOOQ&redirect_uri=http://www.andimier.com/apitests/meetings/cm.html");
    xhr.setRequestHeader("content-type", "application/json");
    xhr.setRequestHeader("Authorization", "Basic WUJISVd3SVRUaktudmpRckhjbDlSdzpEbFh3SEJSREdFWW1ucnNDQUVSSjJ3dTlHNEhCbTIyQQ==");

    xhr.send('token');
}

TokenAuth.prototype.apiTokenCallbak = function(response) {
    if (this.readyState === this.DONE) {
        console.log(this.responseText);
    }
}

var initApiToken = (function() {
    var dataContainer = document.querySelector('#data-container');
    var data = dataContainer && dataContainer.dataset.requestData;

    if (data.length) {
         if (data === 'invalid_request') {
            console.warn('invalid_request');

            return;
        }

        var users = new APIUsers(data);
        var userId = users.getUserId();
        
        userId.then(function(val) {debugger
            document.write(val);
            // si ya está creada, insertar usuario en reunión
            console.log('Petición a usuarios completada: ' + val);

            // si no está creada
        })
        
        userId.catch(function(reason) {debugger
            console.warn(reason);
        });
    }
})();




