<?php 
require('includes/config.php'); 

//Si no ha iniciado sesión, redirija a la página de inicio de sesión
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

//define page title
$title = 'Resultados';

//Incluir plantilla de encabezado
require('layout/header.php'); 
?>


<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			
				<h2>Resultados de busqueda </h2>
				
				<div class="row mt-5">
					<div class="col-xs-6 col-md-6"><a class="btn btn-light btn-block btn-lg" tabindex="5" href="paginausuarios.php" >Volver</a></div>
				</div>
				
				<div id="respuesta"></div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-sm-offset-12 col-md-offset-12 mt-5">
			<div class="row">
				<div  class="col-md-12">
					<div style="padding:30px;border:3px solid white; text-align:center;background:rgba(255,255,255,0.4)">
						<?php
						//Recogemos los datos y mostramos la imagen que se ha buscado por descripcion. 
						$buscar=$_GET['buscar'];
						$cont = 0;
						$stmt = $db->query("SELECT * FROM imagen WHERE descripcion LIKE '%" .$buscar. "%'");
						//var_dump($buscar);
						while ($row = $stmt->fetch()) {
							//echo $row['nombre']."<br />\n";
							echo '<img style="width:100%;height:auto;padding:5px;border:1px solid black;" src="imagenes/'.$row['nombre'].'">'."\n";	
							

							//header("Content-type: image/png");
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
						//Si no hay imagenes se muestra el siguiente mensaje
						if($cont == 0)
						{
							echo '<span>NO HAY RESULTADOS</span>';	
						}
						?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>	

<?php 
//Incluir plantilla de encabezado
require('layout/footer.php'); 
?>
