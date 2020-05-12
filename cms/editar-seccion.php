<?php 
	require_once("includes/sesion.php");
	require_once("includes/connection.php");
	require_once("utils/phpfunctions.php");
	require_once("includes/functions.php");
	require_once('edicion/campos1.php');
	require_once('headers/hdr-editar-seccion.php');
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
						while ($contenido = phpMethods('fetch', $contenidos)) {
							if ($contenido['indice'] == 0 && $contenido['seccion_id'] != 7) {
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
<?php if (isset($connection)) { phpMethods('close', $connection); } ?>




