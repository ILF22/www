var output;

var websocket;

function WebSocketSupport()
{
    if (browserSupportsWebSockets() === false) {
        document.getElementById("ws_support").innerHTML = "<h2>Losiento! Tu navegador no soporta web sockets</h2>";

        var element = document.getElementById("wrapper");
        element.parentNode.removeChild(element);

        return;
    }

    output = document.getElementById("chatbox");

    websocket = new WebSocket('ws:localhost:999');

    websocket.onopen = function(e) {
        writeToScreen("Conectado satisfactoriamente");
    };


    websocket.onmessage = function(e) {
        onMessage(e)
    };

    websocket.onerror = function(e) {
        onError(e)
    };
}

function onMessage(e) {
    writeToScreen('<span style="color: yellow;"> ' + e.data + '</span>');
}

function onError(e) {
    writeToScreen('<span style="color: red;">ERROR:</span> ' + e.data);
}

function doSend(message) {
    var validationMsg = userInputSupplied();
    if (validationMsg !== '') {
        alert(validationMsg);
        return;
    }
    var chatname = document.getElementById('chatname').value;

    document.getElementById('msg').value = "";

    document.getElementById('msg').focus();

    var msg = '@<b>' + chatname + '</b>: ' + message;

    websocket.send(msg);

    writeToScreen(msg);

    $("#chatbox > p").css({
        "background-color" : "transparent",
    });

    $("#chatbox > p:last-child").css({
        "background-color" : "rgb(250,128,114,0.5)",
    });
}

function writeToScreen(message) {
    var pre = document.createElement("p");
    pre.style.wordWrap = "break-word";
    pre.innerHTML = message;
    output.appendChild(pre);
}

function userInputSupplied() {
    var chatname = document.getElementById('chatname').value;
    var msg = document.getElementById('msg').value;
    if (chatname === '') {
        return '';
    } else if (msg === '') {
        return 'Escribe un mensaje';
    } else {
        return '';
    }
}

function browserSupportsWebSockets() {
    if ("WebSocket" in window)
    {
        return true;
    }
    else
    {
        return false;
    }
}