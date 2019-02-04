<?php
	require_once("includes/requeridos.php");
	require_once("includes/idiomas-arr.php");

	$mensaje = "";
	$mensaje_img = "";

	if (intval( $_GET['texto_id'] ) == 0) {
		header("Location: inicio.php");	
		exit;
	} else {
		$id = $_GET['texto_id'];

		if (isset($_GET['idm'])) {
			$idioma = $_GET['idm'];
		} else {
			$idioma = 0;
		}

		require_once('includes/mensaje-reload.php');
		require_once('edicion/edc_imagenes/img_cambio.php');

		if ($idioma == 0) {
			$q_textos  = " SELECT * FROM textos_contenidos ";
			$q_textos .= " WHERE id = " . $id; 
			$q_textos .= " AND idioma = " . $idioma;
		} else {
			$q_textos  = " SELECT * FROM textos_contenidos ";
			$q_textos .= " WHERE texto_id = " . $id; 
			$q_textos .= " AND idioma = " . $idioma;
		}

		$r_textos = mysql_query($q_textos, $connection);

		while($texto = mysql_fetch_array($r_textos)){

			$txt_id = $texto['id'];
			$txt_contenido_id =  $texto['contenido_id'];

			$txt_idioma = $texto['idioma'];
			$txt_titulo =  $texto['titulo'];
			$txt_fecha  =  $texto['fecha'];
			$txt_contenido =  $texto['contenido'];

			$txt_texto_id = $texto['texto_id'];
			$txt_borrable = $texto['borrable'];
			$txt_seccion  = $texto['seccion_id'];

			$txt_img1  = $texto['imagen1'];
			$txt_img2  = $texto['imagen2'];
			$txt_img3  = $texto['imagen3'];
		}
		$tituloboton = "Eliminar texto";

		$url = $_SERVER['HTTP_REFERER'];
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

				<?php 
					$tt_contenido = (isset($_GET['contenido'])) ? $_GET['contenido'] : '';
				?>
				Editar Contenido: 
				<h3><?php echo $txt_titulo; ?></h3>
				<br />
				<br />

				<?php echo $mensaje; ?>

				<?php if(!empty($txt_img1)): ?>
					<div id="col3" >
						<?php require_once('edicion/edc_imagenes/img-principal-textos.php'); ?>
						<br>
						<br>
					</div>
				<?php endif; ?>

				<!--  //// BOTONES IMAGEN E IDIOMA + ////-->
				<div id="cnt_botones">	
					<?php 
						for ($i=0; $i<count($idiomas_arr); $i++) {
							$linkidiomas =  '<div class="botones fondo_gris2 espacio_derecha">';

							if (isset($_GET['sub-contenido'])) {
								$linkidiomas.= '<a href="editar-textos.php?sub-contenido='.$_GET['sub-contenido'].'&texto_id='.$id.'&idm='.$i.'&contenido='.$txt_contenido_id.'">';
							} else {
								$linkidiomas.= '<a href="editar-textos.php?texto_id='.$id.'&idm='.$i.'&contenido='.$txt_contenido_id.'">';
							}

							$linkidiomas .=  'Editar en ' . $idiomas_arr[$i][$idioma];
							$linkidiomas .= '</a>'; 
							$linkidiomas .= '</div>';
							echo $linkidiomas;
						}
					?>
				</div>

				<?php require_once("edicion/frm-edicion-textos.php"); ?>
				<br>
				<br>
				<br>

				<!-- //// FORMULARIO ELIMINAR DEL CONTENIDO //// -->
				<?php 
					if ( $txt_borrable == 1) {
						echo '<div id="col4" >';
						require_once("edicion/frm-eliminar3.php"); 
						echo '</div>';
					}
				?> 
			</div>
		</div>

		<div id="footer"></div>
		<?php include_once('includes/cabezote.php'); ?>
		<?php include_once('includes/navegacion.php'); ?>
	</body>
</html>
<?php if(isset($connection)){ mysql_close($connection); } ?>
