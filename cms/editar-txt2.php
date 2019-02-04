<?php


	require_once("includes/requeridos.php");
	
	$mensaje = "";
	$mensaje2 = "";
	$imagen = "";
		
	if( intval( $_GET['contenido_id'] ) == 0){
		header("Location: content.php");	
		exit;
	}else{
		
		$id = $_GET['contenido_id'];
		$idioma = $_GET['idioma'];
		
		
		require_once("edicion/act-txt2.php");	
		
		
		$q_txt = "SELECT * FROM textos_contenidos WHERE contenido_id =" . $id ." AND idioma =". $idioma;
		$r_txt = mysql_query($q_txt, $connection);


		$tabla = "textos_contenidos";
		
		while($texto = mysql_fetch_array($r_txt)){
			
			$id        = $texto['id'];
			$fecha     = $texto['fecha'];
			$titulo    = $texto['titulo']; 
			$seccion   = $texto['seccion_id'];
			
			$contenido     = $texto['contenido'];
			$contenido_id  = $texto['contenido_id'];
	
		}

	}

	
	$tituloboton = "Eliminar";
	$archivo_eliminar = 'edicion/eliminar-contenidos.php';
	
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">


	<head>

		<?php include_once('includes/tags.php'); ?>

	</head>
	
	
	<body>
		
		
		<div id="col2">
			
			<div id="cnt_edicion">

				<a href="editar-proyecto.php?contenido_id=<?php echo $parent; ?>">Volver al Proyecto</a>
				/
				<a href="editar-contenido.php?contenido_id=<?php echo $contenido_id; ?>&parent=<?php echo $parent;?>">
					Volver al contenido en español
				</a>
				<br>
				<br>
				<br>
				<!--  
				MENSAJE
				-->
				<div class="mensaje" style="color:#F00"> <?php echo $mensaje; ?></div>  
				
				
				<!--  
				BOTONES
				IMAGEN E IDIOMA +
				-->
				<div id="cnt_botones">	
					
					<div class="botones fondo_gris2 espacio_derecha"  >
						<a href="editar-txt2.php?contenido_id=<?php echo $contenido_id; ?>&idioma=1"> 
							Editar Ingles
						</a> 
					</div>
					
					<div class="botones fondo_gris2"  >
						<a href="editar-txt2.php?contenido_id=<?php echo $contenido_id; ?>&idioma=2">  
							Editar Francés
						</a> 
					</div>
		
				</div>	
				<?php require_once("edicion/frm-edicion-txt2.php"); ?>
	

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
