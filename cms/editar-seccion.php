<?php 
	require_once("includes/sesion.php");
	require_once("includes/connection.php");
	require_once("includes/functions.php");
	require_once('edicion/campos1.php');

	$mensaje = "";

	date_default_timezone_set('America/Bogota');
	$fecha = date("Y-m-d");

	$imagen1 = '';
	$imagen2 = '';
	$imagen3 = '';

	//require_once('edicion/insertar_contenidos.php');
	
	// MOSTRAR MENSAJE DE INSERCION DE CONTENIDO
	if (isset($_GET['act'])) {
		$mensaje = '<div id="mensaje_positivo">Contenido creado correctamente</div>';
		unset($_GET['act']);
	}

	require_once('edicion/edc_imagenes/img_cambio.php');
	encontrar_seccion_y_contenido_seleccionados();

	$seccion_id = mysql_prep($_GET['seccion']);

	$q_contenido  = "SELECT * FROM contenidos ";
	$q_contenido .= "WHERE seccion_id = {$seccion_id} ";
	$q_contenido .= "AND contenido_id = 0 ";
	$q_contenido .= "ORDER BY fecha DESC";

	$contenidos = mysql_query($q_contenido, $connection);
	confirm_query($contenidos); 

	//========== PARAMETROS FORMULARIO ACTUALIZACION DE CONTENIDOS =================//
	
	$tabla   = "secciones";	
	$id = $seccion_seleccionada['id'];
	$seccion = $seccion_seleccionada['id'];
	$imagenprincipal = $seccion_seleccionada['imagen1'];
	$img = $seccion_seleccionada['imagen2'];

	$campos_arr = array(
		0 => array('id'=>1, 'meta-tags'=> true,  'img-pr'=>true,  'nvo-contenido' => false, 'editar-extras'=>false),
		1 => array('id'=>2, 'meta-tags'=> true,  'img-pr'=>false, 'nvo-contenido' => true,  'editar-extras'=>false),
		2 => array('id'=>3, 'meta-tags'=> false, 'img-pr'=>false, 'nvo-contenido' => true,  'editar-extras'=>false),
		3 => array('id'=>4, 'meta-tags'=> true,  'img-pr'=>false, 'nvo-contenido' => true,  'editar-extras'=>false),
		4 => array('id'=>6, 'meta-tags'=> true,  'img-pr'=>false, 'nvo-contenido' => false, 'editar-extras'=>false),
		5 => array('id'=>7, 'meta-tags'=> true,  'img-pr'=>false, 'nvo-contenido' => false, 'editar-extras'=>false),
		6 => array('id'=>8, 'meta-tags'=> true,  'img-pr'=>true,  'nvo-contenido' => true, 'editar-extras'=>false)
	);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include_once('includes/tags.php'); ?>
	</head>
	<body>
		<div id="col2">
			<div id="cnt_edicion">

				<h3>Seccion: <?php echo $seccion_seleccionada['titulo']; ?></h3>

				<!-- //// EDITAR METATAGS //// -->
				<?php 
					metaTags($campos_arr, $seccion_seleccionada['id'], $seccion_seleccionada['titulo']);
					echo $metatags;
				?>

				<br />
				<div class="mensaje"><?php echo $mensaje; ?></div>

				<!-- IMAGEN PRINCIPAL -->
				<?php 
					imgPrincipal($campos_arr, $seccion_seleccionada['id'], $tabla, $imagenprincipal);
				?>

				<!-- INSERTAR CONTENIDO -->
				<div style="clear:both">
					<?php
					insertarContenido($campos_arr, $seccion_seleccionada['id']);
					echo $nuevo_contenido;
					?>
				</div>
				
				<!-- //// MOSTRAR LOS CONTENIDOS //// -->
				<strong>Haz click sobre el titulo del contenido para editarlo.</strong>
				<br />
				<br />

				<ul>
					<?php 
						while($contenido = mysql_fetch_array($contenidos)){
							if ($contenido['indice'] == 0 && $contenido['seccion_id'] != 7){
								//SI LA SECCION NO ES REDES O CONTACTO SE MUESTRA LA FECHA
								$enlace = '<a href="editar-contenido.php?contenido_id='.$contenido['id'].'"> ';
								$titulo = ($contenido['seccion_id'] < 6 ? $contenido["fecha"] . ' / ' : '') . $contenido["titulo"]; 
							} elseif ( $contenido['indice'] == 0 && $contenido['seccion_id'] == 7){
								//	MANDAR A EDITAR ENLACES DE REDES SOCIALES 
								// SI ES SECCION "REDES"
								$enlace = '<a href="editar-enlaces.php?contenido_id='.$contenido['id'].'"> ';
								$titulo  = $contenido["titulo"]; 
							} else {
								$enlace = '<a href="editar-subcontenido.php?contenido_id='.$contenido['id'].'"> ';
								$titulo  = $contenido["titulo"]; 
							}

							$li  = '<li>';
							$li .= $enlace;
							// SI LA SECCION NO ES REDES O CONTACTO SE MUESTRA LA FECHA
							$li .= $titulo; 
							$li .= '</a>';
							$li .= '</li>';
							echo $li;
						}
					?>
				</ul>

				<?php
				extras($campos_arr, $seccion_seleccionada['id']);
				echo $extras;
				?>
			</div>
		</div>

		<div id="footer"></div>
		<?php include_once('includes/cabezote.php'); ?>
		<?php include_once('includes/navegacion.php'); ?>
	</body>
</html>
<?php if (isset($connection)) { mysql_close($connection); } ?>




