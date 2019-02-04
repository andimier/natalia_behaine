<?php


	require_once("includes/requeridos.php");
	
	$mensaje = "";
	$mensaje2 = "";
	$imagen = "";
	
	/*
	if( intval( $_GET['contenido_id'] ) == 0){
		header("Location: inicio.php");	
		exit;
	}
	*/
	


	
	

	
	require_once("edicion/act-textos.php");

	
	// poner luego de la actualizaciondecontenidos
	// para ver los cambios	
	encontrar_seccion_y_contenido_seleccionados();
	

	// PARAMETROS ACTUALIZACION
	// Y ELIMINACION DE CONTENIDOS
	
	$idioma = $_GET['idm'];
	$num =  $_GET['texto_id'];
	$idm = $_GET['idm'];

	$q_textos  = "SELECT * FROM textos_contenidos ";
	$q_textos .= "WHERE texto_id = $num ";
	$q_textos .= "AND idioma = $idm";
	
	if( mysql_query($q_textos, $connection)){
		
		$r_textos = mysql_query($q_textos, $connection);
		
		while($texto = mysql_fetch_array($r_textos)){

			$txt_id = $texto['id'];
			$txt_texto_id = $texto['texto_id'];
			
			$txt_titulo =  $texto['titulo'];
			$txt_fecha  =  $texto['fecha'];
			$txt_idioma  =  $texto['idioma'];

			$txt_seccion  =  $texto['seccion_id'];
			$txt_contenido    =  $texto['contenido'];
			$txt_contenido_id =  $texto['contenido_id'];
		}
		
	
	}else{
		
		mysql_error();
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
				
			
				<?php if(isset($_GET['sub-contenido'])): ?>
					<a href="editar-subcontenido.php?contenido_id=<?php echo $txt_contenido_id; ?>">Volver al Contenido</a>
				<?php else: ?>
					<a href="editar-contenido.php?contenido_id=<?php echo $txt_contenido_id; ?>">Volver al Contenido</a>
				<?php endif; ?>

				<br>
				<br>
				
				
				Editar Contenido: <?php echo $txt_titulo; ?>
				<br />
				<br />
				
				<div class="mensaje" style="color:#F00"> <?php echo $mensaje; ?></div>
				
				
				<!--  
				BOTONES
				IMAGEN E IDIOMA +
				-->
			
				<div id="cnt_botones">	
				
					<?php 
					
						$idiomas_arr = array('Español', 'Inglés', 'Francés');
						
						for($i=0; $i<count($idiomas_arr); $i++){
							
							$linkidiomas =  '<div class="botones fondo_gris2 espacio_derecha">';
							if($i==0){
								if(isset($_GET['sub-contenido'])){
									$linkidiomas.= '<a href="editar-textos.php?sub-contenido='.$_GET['sub-contenido'].'contenido_id='.$txt_contenido_id.'&idm='.$i.'&contenido='.$txt_contenido_id.'">';
								}else{
									$linkidiomas.= '<a href="editar-textos.php?contenido_id='.$txt_contenido_id.'&idm='.$i.'&contenido='.$txt_contenido_id.'">';
								}
							}else{
								if(isset($_GET['sub-contenido'])){
									$linkidiomas.= '<a href="editar-textos2.php?sub-contenido='.$_GET['sub-contenido'].'&texto_id='.$txt_id.'&idm='.$i.'&contenido='.$txt_contenido_id.'">'; 
								}else{
									$linkidiomas.= '<a href="editar-textos2.php?texto_id='.$txt_id.'&idm='.$i.'&contenido='.$txt_contenido_id.'">'; 
								}
								
							}
							
							
							$linkidiomas .=  'Editar en ' . $idiomas_arr[$i];
							$linkidiomas .= '</a>'; 
							$linkidiomas .= '</div>';
							echo $linkidiomas;
						}
					?>
					
					<div class="botones fondo_gris2 espacio_derecha"  >
						<a href="editar-textos.php?contenido_id=<?php echo $txt_texto_id; ?>&idm=0&contenido=<?php echo $txt_contenido_id; ?>"> 
							Editar Español
						</a> 
					</div>
					
					<div class="botones fondo_gris2 espacio_derecha"  >
						<a href="editar-textos2.php?texto_id=<?php echo $txt_texto_id; ?>&idm=1&contenido=<?php echo $txt_contenido_id; ?>"> 
							Editar Inglés
						</a> 
					</div>
					
					<div class="botones fondo_gris2"  >
						<a href="editar-textos2.php?texto_id=<?php echo $txt_texto_id; ?>&idm=2&contenido=<?php echo $txt_contenido_id; ?>"> 
							Editar Francés
						</a> 
					</div>
		
				</div>
				

				  
					
				<?php require_once("edicion/frm-edicion-textos.php"); ?>
				
	

				
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
