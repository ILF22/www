
<?php
session_start();

?>
<!DOCTYPE html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <title>WebSocket Chat</title>
    <link type="text/css" rel="stylesheet" href="style.css" />
    <script src="websocket_client.js"></script>
    <script src="scroll.js"></script>


</head>

<body onload="javascript:WebSocketSupport()">
    <div id="wrapper" class="col-md-8 chat">
        <div id="menu" class="card">
            <div class="card-header msg_head">
                <div class="d-flex bd-highlight">
                    <div class="img_cont">
                        <span class="online_icon"></span>
                    </div>
                    <div class="user_info">
                        <span>Live your dreams Chat</span>
                    </div>
                </div>

                <div class="card-body msg_card_body">
                    <div class="d-flex justify-content-start mb-4">
                        <div class="msg_cotainer">
                            <div id="chatbox">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="controls" class="card-footer">
                    <div class="input-group">
                        <input name="chatname" type="text" id="chatname" size="67" value="<?php echo $_SESSION['username']?>" readonly>
                        <input class="form-control type_msg" maxlength="32" name="msg" type="text" id="msg" size="63" placeholder="Escribe tu mensaje" />
                        <div class="input-group-append">
                            <input class="input-group-text send_btn" name="sendmsg" type="submit" id="sendmsg" value="Enviar" onclick="doSend(document.getElementById('msg').value)">
                        </div>
                    </div>
                    <div class="input-group-append">
                        <a href="../../paginausuarios.php"><button type="button" value="Volver" class="btn float-left send_btn">Volver</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</body>

</html>