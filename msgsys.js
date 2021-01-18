/* JS frontend for msgsys backend */

var pollTimeout;

function sendJson(user, channel, jsonObject, fnsuccess) {
    var xhr;
    
    if (channel === undefined || channel === null || channel.trim() == '') return false;
    if (user === undefined || user === null || user.trim() == '') return false;

    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            fnsuccess(jsonObject);
        }
    };

    xhr.open('POST', 'msgsys.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('user=' + user + '&channel=' + channel + '&jsondata=' + encodeURIComponent(JSON.stringify(jsonObject)) + '&method=sent');

    return true;
}
  
function recvJson(user, channel, fnsuccess) {
    var xhr;

    if (channel === undefined || channel === null || channel.trim() == '') return false;
    if (user === undefined || user === null || user.trim() == '') return false;

    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var jsons = xhr.responseText;
            var jsonStrs = jsons.split("\r\n\r\n");
            for (var i = 1 ; i < jsonStrs.length; ++i) fnsuccess(JSON.parse(jsonStrs[i]));
            clearTimeout(pollTimeout);
            pollJson(user,channel);
        }
        else if (xhr.readyState == 4 && xhr.status == 404) {
            clearTimeout(pollTimeout);
            pollJson(user,channel);
        }
    };

    xhr.open('POST', 'msgsys.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('user=' + user + '&channel=' + channel + '&method=get');

    return true;
}

function pollJson(user,channel) {
    pollTimeout = setTimeout(function() { recvJson(user,channel, recvjson) }, 2000);
}
  
function deleteJson(user, channel, fnsuccess) {
    var xhr;

    if (channel === undefined || channel === null || channel.trim() == '') return false;
    if (user === undefined || user === null || user.trim() == '') return false;

    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            fnsuccess();
        }
    };

    clearTimeout(pollTimeout);

    xhr.open('POST', 'msgsys.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('user=' + user + '&channel=' + channel + '&method=delete');

    return true;
}