var botonEliminarPulsado;

$(document).ready(function () {
    eliminarComentario();
    eliminarComentarioV(); 
})
function cargarComentarios(idFoto){
    $.ajax({
        type: "POST", 
        url:"comentario.php?idFoto=" + idFoto + "&accion=cargarComentarios",
    }).done(function(resultado){
        $('#ul'+ idFoto).html(resultado);
        eliminarComentario();
    })
}
function cargarComentariosV(idVideo){
    $.ajax({
        type: "POST",
        url:"comentarioV.php?idVideo=" 
        + idVideo + "&accion=cargarComentariosV",
    }).done(function(resultado){
        $('#ulV'+ idVideo).html(resultado);
        eliminarComentarioV();
    })
}

function eliminarComentario() {
    $('.eliminarComentario').click(function () {
        botonEliminarPulsado = this;
        var idComentario = $(botonEliminarPulsado).attr('id');
        var idFoto = $(botonEliminarPulsado).prev('p').attr('id');

        $.ajax({
            type: "POST",
            url: "comentario.php?idComentario=" + idComentario + "&accion=eliminarcomentario",
        }).done(function (resultado) {
            cargarComentarios(idFoto);            

        });
    })
}

function eliminarComentarioV(){
    $('.eliminarComentarioV').click(function () {
        botonEliminarPulsado = this;
        var idComentarioV = $(botonEliminarPulsado).attr('id');
        var idVideo = $(botonEliminarPulsado).prev('p').attr('id');
        
        $.ajax({
            type: "POST",
            url: "comentarioV.php?idComentarioV=" + idComentarioV + "&accion=eliminarcomentarioV",
        }).done(function (resultado) {
            cargarComentariosV(idVideo);

        });
    })
}