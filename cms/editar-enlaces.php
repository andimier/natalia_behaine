<?php


	require_once("includes/requeridos.php");
	
	$mensaje = "";
	
		
	if( intval( $_GET['contenido_id'] ) == 0){
		header("Location: inicio.php");	
		exit;
	}else{
		$id = $_GET['contenido_id'];
		
		if(isset($_POST['benlace'])){
		
			$enlace = $_POST['enlace'];
			$id = $_POST['id'];
			
			
			$q_enlace = "UPDATE contenidos SET contenido = '{$enlace}'  WHERE id = $id";
			
			if( mysql_query($q_enlace, $connection)){

				$mensaje = '<div id="mensaje_positivo"> Listo! </div>';
			}else{
				$mensaje = '<div id="mensaje_negativo">No hiciste cambios.</div>';
				mysql_error();
			}
		}
		
	}
	

	
	encontrar_seccion_y_contenido_seleccionados();
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">


	<head>

		<?php include_once('includes/tags.php'); ?>

	</head>
	
	
	<body>
		
		
		
		<div id="col2">
			<div id="cnt_edicion">
				
				<a href="editar-seccion.php?seccion=<?php echo $contenido_seleccionado['seccion_id']; ?>">Volver a la seccion</a>
				<br>
				<br>
				
				<?php echo $mensaje; ?>
				
				
				
				<div class="cnt-generico">
	
					Enlace a <?php echo $contenido_seleccionado['titulo']; ?>
					<br>
					<br>
					<form enctype="multipart/form-data" method="post">
						<input type="hidden" name="id" value="<?php echo $id;?>"/>
						<input type="text"   name="enlace" 		 value="<?php echo $contenido_seleccionado['contenido']; ?>" size="70" maxlength="70"/>
						<br>
						<input type="submit" name="benlace"       value="Guardar" class="boton1"/>
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
