<?php 
require('includes/config.php'); 

//Si no ha iniciado sesión, redirija a la página de inicio de sesión
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

//define titulo de la pagina
$title = 'Vista Usuario';

//Incluir plantilla de encabezado
require('layout/header.php'); 
?>


<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		
				<!--LLama al nombre de usuario para mostrarlo cuando entra en una de ellos-->	
				<h2>Perfil de  
					<?php 
					$nombreusuario=$_GET['nombreusuario'];
					echo htmlspecialchars($nombreusuario, ENT_QUOTES); 
					?>
				</h2>
				<hr>
				<!--Boton volver para ir a la pagina anterior-->	
				<div class="row mt-5">
					<div class="col-xs-6 col-md-6"><a class="btn btn-light btn-block btn-lg" tabindex="5" href="paginausuarios.php" >Volver</a></div>
				</div>
				
				<div id="respuesta"></div>
		</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-sm-offset-12 col-md-offset-12 mt-5">
				<div class="row">
					<div  class="col-md-10">
					<!--Definimos el color y la opacidad de este -->	
						<div style="padding:30px;border:3px solid white; text-align:center;background:rgba(255,255,255,0.4)">
						<!--Hacemos la consulta para mostrar todo las imagenes del usuario seleccionado-->	
							<?php
							$id=$_GET['id'];
							$cont = 0;
							$stmt = $db->query("SELECT * FROM imagen WHERE usuarioID = ".$id);
							while ($row = $stmt->fetch()) {
								//Definimos el diseño de las imagenes
								echo '<img style="width:100%;height:auto;padding:5px;border:1px solid black;" src="imagenes/'.$row['nombre'].'">'."\n";	
								

								//header("Content-type: image/png");
								//Definimos el nombre
								$foto= $row['nombre'];
								//Decodificamos $Base64Img codificada en base64.
								//$Base64Img = base64_decode($foto);
								//escribimos la información obtenida en un archivo llamado
								//imagen.png para que se cree la imagen correctamente
								//file_put_contents('imagenes/'.$row['nombre'], $Base64Img);   
								//echo "<img src='imagenes/".$row['nombre']."' alt='imagen' width='100' heigth='100'/><br/>";

								
								//Mostramos la descripcion de la foto
								echo '<br/><br/>'.$row['descripcion'].'<br/><br/>';	
								$cont++;					
							}		
							//Si el usuario no tiene fotos se muestra el siguiente mensaje
							if($cont == 0)
							{
								echo '<span>ESTE USUARIO NO TIENE IMAGENES</span>';	
							}
							?>
							<?php
							//Visitas Contador
							if($_SESSION['usuarioID']!= $id){
								$stmt = $db->query("UPDATE usuarios SET visitas = visitas +1 WHERE usuarioID = " . $id . ";");
								echo "$id";
								echo $_SESSION['usuarioID'];
							}else{
								echo 'Estoy  aqui';
							}
							?>

						</div>
					</div>
					
				</div>
			</div>
	</div>
</div>	
<script>
     /*$(function(){
        $("input[name='file']").on("change", function(){
		
     });*/

	/*$('#uploadimage').submit(function (e) {
			var formData = new FormData($("#uploadimage")[0]);
            var ruta = "imagen-ajax.php";
            $.ajax({
                url: ruta,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(datos)
                {
					$("#respuesta").html(datos);
                },
				error: function(result) {
                    console.log("Error "+result);
                }
            });
	  });*/

</script>

<?php 
//Incluir plantilla de encabezado
require('layout/footer.php'); 
?>
