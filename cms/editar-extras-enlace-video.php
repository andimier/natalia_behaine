<?php


	require_once("includes/requeridos.php");
	
	$mensaje = "";
	$mensaje2 = "";
	$imagen = "";
		
	if( intval( $_GET['seccion'] ) == 0){
		header("Location: inicio.php");	
		exit;
		
	}else{
		
		
		if(isset($_POST['bvideo'])){
			
			if($_POST['video'] != 0){
				$video = $_POST['video'];
				
			}else{
				$video = 0;
				
			}

			$q_video = "UPDATE " . $_POST['tabla'] . " SET video = " . $video . " WHERE id = " . $_POST['contenido_id'];
			if( mysql_query($q_video, $connection)){
				$mensaje = '<div id="mensaje_positivo">{ El contenido fue actualizada correctamente! }</div>';
			}else{
				$mensaje = '<div id="mensaje_negativo">{ El contenido no fue actualizada. No hiciste ningún cambio. }</div>';
			}
			
		}
		
		encontrar_seccion_y_contenido_seleccionados();
	}
	
	
	
	
	
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">


	<head>

		<?php include_once('includes/tags.php'); ?>

	</head>
	
	
	<body>
		

		<div id="col2">
			<div id="cnt_edicion">
				
				<a href="editar-contenido.php?contenido_id=<?php echo $_GET['contenido_id']; ?>">Volver al contenido</a>
				<br>
				<br>
				
				<?php echo $mensaje; ?>
				
				
				<div class="cnt-generico">
				
					Enlace Video
					<br>
					<br>
					<form enctype="multipart/form-data" method="post">
						<input type="text"   name="video"        value="<?php echo $seccion_seleccionada['video']; ?>">
						<input type="hidden" name="contenido_id" value="<?php echo $seccion_seleccionada['id']; ?>"/>
						<input type="hidden" name="tabla" 		 value="secciones" />
						<br>
						<input type="submit" name="bvideo"       value="Guardar" class="boton1"	/>
					</form>
					
				</div>
	
			</div>
		</div>
	
		
		<div id="footer"></div>
		
		<?php include_once('includes/cabezote.php'); ?>
		<?php include_once('includes/navegacion.php'); ?>
		

	</body>
	
</html>


<?php 
if(isset($connection)){
	mysql_close($connection);
}
?>
