<?php require_once("headers/hdr-editar-album.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include_once('includes/tags.php'); ?>
	</head>

	<body>
		<div id="col2">
			<div id="cnt_edicion">
				<a href="albumes.php">ALBUMES</a> > ALBUM > <?php echo $album_seleccionado['titulo']; ?>
				<br />
				<br />

				<div class="mensaje" style="color:#F00"> <?php echo $mensaje; ?></div>

				<!-- //// IMAGEN PRINCIPAL	DEL CONTENIDO //// -->
				<?php
					if(!empty($imagenprincipal)){
						echo '<div id="col3" >';
						require_once('edicion/edc_imagenes/img_principal.php');
						echo '</div>';
					}
				?>

				<!-- //// FORMULARIO DE EDICION DE CONTENIDOS //// -->
				<div style="clear:both">
					<form enctype="multipart/form-data" name="formularioedicion1" id="formularioedicion1" method="post">
						<input type="hidden" name="id"     value="<?php echo $id;?>"/>
						<input type="hidden" name="txt_id" value="<?php echo $txt_id;?>"/>
						<input type="hidden" name="tabla"  value="<?php echo $tabla;?>"/>

						<input type="text" name="titulo" id="titulo" value="<?php echo $titulo; ?>" size="50" maxlength="50" />
						<input type="text" name="fecha"  id="fecha"  value="<?php echo $fecha; ?>"  size="50" maxlength="50" />

						<!-- //// ASIGNACION DEL ALBUM A CONTENIDO //// -->
						<br />
						<br />

						>> ALBUM ASIGNADO A: <?php echo $selectedParentContent ?>
						<br />
						<br />
						<br />

						<input type="hidden" name="tt_contenido"  value="<?php echo $selectedParentContent; ?>" />

						<select name="contenido_id" id="escoger2">
							<option value="0">ninguno</option>

							<?php while($conte = mysql_fetch_array($r_contenido)): ?>
								<option value="<?php echo $conte['id']; ?>" <?php echo $conte['titulo'] == $selectedParentContent ? 'selected': ""; ?>>
									<?php echo $conte['titulo']; ?>
								</option>
							<?php endwhile; ?>
						</select>
						<br>
						<br>

						<input type="submit" name="boton1" class="boton1" value="Guardar" />
					</form>
				</div>

				<script src="js/formulario_edicion.js" type="text/javascript"></script>

				<div id="imagenes_album">
					<ul>
						<li>
							<a href="<?php echo $galleryUrlLink; ?>">
								>> EDITAR IMAGENES EN ESTE ALBUM
							</a>
						</li>
					</ul>
				</div>

				<!-- //// FORMULARIO ELIMINAR DEL CONTENIDO ////	-->
				<?php if( $album_seleccionado['borrable'] == 1): ?>
					<div id="cnt_formularioEliminar">
						<form action="<?php echo $archivo_eliminar; ?>" enctype="multipart/form-data" method="post">
							<input type="hidden" name="id"        value="<?php echo $id; ?>"/>
							<input type="hidden" name="seccion"   value="<?php echo $seccion; ?>"/>

							<input type="hidden" name="imagenprincipal" value="<?php echo $imagenprincipal; ?>"/>
							<input type="hidden" name="video"   value="<?php echo $video; ?>"/>
							<input type="hidden" name="archivo" value="<?php echo $archivo; ?>"/>

							<input type="submit" name="eliminaralbum" id="btn_eliminar1" value="<?php echo $tituloboton; ?>" onClick="return confirm('Esta acci�n eliminar� definitivamente este contenido., quieres continuar?')"/>
						</form>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div id="footer"></div>
		<?php include_once('includes/cabezote.php'); ?>
		<?php include_once('includes/navegacion.php'); ?>
	</body>
</html>
<?php
	if (isset($connection)) {
		mysql_close($connection);
	}
?>
