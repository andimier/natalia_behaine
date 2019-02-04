<?php require_once("headers/hdr-editar-subcontenido.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include_once('includes/tags.php'); ?>
	</head>
	<body>

		<div id="col2">
			<div id="cnt_edicion">
				<a href="editar-contenido.php?contenido_id=<?php echo $contenido_seleccionado['contenido_id']; ?>">Volver al contenido</a>
				<br>

				<h3><?php echo $contenido_seleccionado['titulo']; ?></h3>

				<div class="mensaje"> <?php echo $mensaje; ?></div>

				<h4>Insertar nuevo texto</h4>
				
				Títluo:
				<form enctype="multipart/form-data" method="post">
					<input type="hidden" name="contenido_id"   value="<?php echo $contenido_seleccionado['id'];?>" />
					<input type="hidden" name="seccion_id"     value="<?php echo $contenido_seleccionado['seccion_id'];?>" />
					<input type="text"   name="titulo"         value="" size="50" maxlength="50" class="borde_puntos letra_roja"/>
					<br />
					<input type="submit" name="btn_texto" value="insertar texto" class="fondo_rojo"/>
				</form>
				<br />
				<br />

				<strong>Haz click sobre el título del contenido para editarlo.</strong>
				<br />
				<br />

				<ul>
					<?php while($texto = mysql_fetch_array($r_textos)): ?>
						<!--
						AL ENVIAR A EDITAR TEXTOS, SOLO SE MUESTRA LA FECHA PARA LOS TEXTOS DE 
						MENCIONES, PUBLICACIONES, EXPOSICIONES Y CONVOCATORIAS

						PARA IDENTIFICAR QUÉ TEXTO MUESTRA LA FECHA, SE ENVÍA EL TÍTULO DEL CONTENIDO
						PUBLOCACION, CONVOCATORIAS, ETC.
						-->
						<li>
							<a href="editar-textos.php?sub-contenido=<?php echo $contenido_seleccionado['id']; ?>&texto_id=<?php echo $texto['id']; ?>&contenido=<?php echo $contenido_seleccionado['titulo']; ?>" >
								<?php echo $texto['fecha'] . ' / ' . $texto['titulo']; ?>
							</a>
						</li>
						
					<?php endwhile; ?>
				</ul>
			</div>

		<!-- //// IMAGEN PRINCIPAL DE LA SECCION //// -->
		<?php 
			if (empty($imagenprincipal)) {

			} else {
				require_once('edicion/edc_imagenes/img_principal.php'); 
			}
		?>
		<div id="footer"></div>
		<?php include_once('includes/navegacion.php'); ?>
		<?php include_once('includes/cabezote.php'); ?>
		<script src="js/general.js" type="text/javascript"></script>
	</body>
</html>
<?php if (isset($connection)) {	mysql_close($connection); } ?>
