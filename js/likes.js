var botonPulsado;
$(document).ready(function () {
    $('.like').click(function () {
        botonPulsado = this;
        var idImagen = $(botonPulsado).attr('id');
        var idUsuario = $('#idusuario').html();


        var nombrePerfil = $('#idNombre').html();
        var idPerfil = $('#idPerfil').html();

        $.ajax({
            type: "POST",
            url: "likes.php?id=" + idImagen + "&accion=annadirlikes",
        }).done(function (resultado) {
            cargarLikes(idImagen);

        });
    })

    $('.likeVideo').click(function () {
        botonPulsado = this;
        var idVideo = $(botonPulsado).attr('id');
        var idUsuario = $('#idusuario').html();


        var nombrePerfil = $('#idNombre').html();
        var idPerfil = $('#idPerfil').html();

        $.ajax({
            type: "POST",
            url: "likesV.php?id=" + idVideo + "&accion=annadirlikes",
        }).done(function (resultado) {
            cargarLikesVideo(idVideo);

        });
    })

})

function cargarLikes(idImagen) {
    $.ajax({
        type: "POST",
        url: "likes.php?id=" + idImagen + "&accion=cargarLikes",
    }).done(function (resultado) {
        $(botonPulsado).children('div').html(resultado);
    });
}

function cargarLikesVideo(idVideo) {
    $.ajax({
        type: "POST",
        url: "likesV.php?id=" + idVideo + "&accion=cargarLikesV",
    }).done(function (resultado) {
        $(botonPulsado).children('div').html(resultado);
    });
}