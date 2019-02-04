<?php 
	require_once("includes/sesion.php");
	require_once("includes/connection.php");
	require_once("includes/functions.php");
	
	$mensaje = "";
	
	date_default_timezone_set('America/Bogota');
	$fecha = date("Y-m-d");
	
	encontrar_seccion_y_contenido_seleccionados();
	
	$contenido_id = $contenido_seleccionado['id'];
	$seccion_id   = $contenido_seleccionado['seccion_id'];
	$borrable     = $contenido_seleccionado['borrable'];
	
	echo $contenido_id;

	$tituloboton = "Eliminar";
	$archivo_eliminar = 'edicion/eliminar-contenidos.php';

	$idm = 0;
	$q_texto = "SELECT * FROM contenidos WHERE contenido_id =" . $contenido_id ;	
	$r_texto = mysql_query($q_texto, $connection);
	
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">


	<head>
		<?php include_once('includes/tags.php'); ?>
	</head>
	
	
	<body>
		
		
		
		<div id="col2">

			<div id="cnt_edicion">
		
				<h3><?php echo $contenido_seleccionado['titulo']; ?></h3>
				
				
				<br>
				<br>
				<!-- EDITAR METATAGS ================-->
				
				<div class="titulo-rojo">
					<a href="puente_metatags.php?seccion_id=<?php echo $seccion_id; ?>&sec=<?php echo $titulo; ?>">
						> Editar Meta Tags de esta Sección
					</a>
				</div>
			
				<br />
				
				
				<strong>Haz click sobre el titulo del contenido para editarlo.</strong>
				
				<br />
				<br />
			

				
				
					<ul>
						<li>
							<a href="editar-contenido.php?contenido_id=<?php echo $contenido_id; ?>&parent=<?php echo $contenido_id?>&nivel=proyecto">
								Editar  Imagen, Título y Texto principal
							</a>
						</li>
					</ul>
					
					<?php while($texto = mysql_fetch_array($r_texto)): ?>
					<ul>
						<li>
							<a href="editar-contenido.php?contenido_id=<?php echo $texto['id']; ?>&parent=<?php echo $contenido_id?>&nivel=proyecto">
								Editar Texto Secundario 
							</a>
						</li>
					</ul>	
					<?php endwhile; ?>
					
					
					<ul>	
						<li>
							<a href="editar-extras.php?contenido_id=<?php echo $contenido_id; ?>">
								Editar Video y Pista de Audio
							</a>
						</li>
					</ul>
					<ul>
						<li><a href="editar-algo.php?contenido_id=<?php echo $contenido_id; ?>">Editar Galería </a></li>
					</ul>
				
					<!--  
					FORMULARIO ELIMINAR
					DEL CONTENIDO 
					-->
					<?php 
					
						if( $borrable == 1){
							echo '<div id="col4" >';
							require_once("edicion/formularioeliminar1.php"); 
							echo '</div>';
						}else{
						
						}

					?> 

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




