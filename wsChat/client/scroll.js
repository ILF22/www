$(document).ready(function() {
    var element = document.getElementById("chatbox");
    
   $('#sendmsg').click(function() {
       console.log(element);
       console.log('element');
    element.scrollTop = element.scrollHeight;
   })

   $('#msg').keypress(function(e) {
        if(e.keyCode==13){
            doSend($('#msg').val());
            element.scrollTop = element.scrollHeight;
        }
    });
});