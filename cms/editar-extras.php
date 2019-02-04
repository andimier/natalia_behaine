<?php require_once("headers/hdr-editar-extras.php"); ?>

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
				<div id="col3">
					Archivo de Audio
					<br>
					<br>
					<?php echo $archivo; ?>
					<br>
					<br>

					<div class="cnt_nuevo_archivo2">
						<form enctype="multipart/form-data" method="post">
							<input type="hidden" name="contenido_id" value="<?php echo $id;    ?>" />
							<input type="hidden" name="tabla"        value="<?php echo $tabla; ?>" />
							<input type="hidden" name="ruta"         value="<?php echo $archivo; ?>" />

							<div id="fileUpload">
								<input id="btn_foto" type="button" value="escoge un audio" class="mascara">
								<input id="foto"  type="file" name="nombre_archivo"  class="upload" onchange="myFunction(this.value)" >
							</div>

							<p id='nm_imagen'></p>
							<input id="bsubirimg" type="submit" name="bsubirarchivo" value="" class="fondo_negro"/>
							<!--<input type="submit" name="btn_subirarchivo" value="Subir Archivo" class="fondo_negro"/>-->
						</form>

						<form enctype="multipart/form-data" method="post">
							<input type="hidden" name="contenido_id"  value="<?php echo $id;    ?>" />
							<input type="hidden" name="ruta"          value="<?php echo $archivo; ?>" />
							<input type="submit" name="borrararchivo" value="eliminar archivo" class="fondo_negro"/>
						</form>
					</div>

					<script>
						function myFunction(val) {
							//document.getElementById("uploadFile").value = this.value;
							$("#nm_imagen").text(val);
							$("#bsubirimg").css('display', 'block');
						};
					</script>
				</div>

				<div class="cnt-generico">
					NÚMERO DEL VIDEO
					<br>
					<br>
					<form enctype="multipart/form-data" method="post">
						<label>Español</label>
						<?php
							$listaDeVideos = explode(',', $video);
							$listadoDeGalerias = explode(',', $videos_gl);
						?>
						<input type="text"   name="video1" value="<?php echo $listaDeVideos[0]; ?>">

						<label>Iinglés</label>
						<input type="text"   name="video2" value="<?php echo $listaDeVideos[1]; ?>">

						<label>Francés</label>
						<input type="text"   name="video3" value="<?php echo $listaDeVideos[2]; ?>">
						<br />

						<label>Numero del la galería de videos</label>
						<br />
						<br />
						<label>Español</label>
						<input type="text"   name="galeria_videos1"   value="<?php echo $listadoDeGalerias[0]; ?>">

						<label>Inglés</label>
						<input type="text"   name="galeria_videos2"   value="<?php echo $listadoDeGalerias[1]; ?>">

						<label>Francés</label>
						<input type="text"   name="galeria_videos3"   value="<?php echo $listadoDeGalerias[2]; ?>">

						<input type="hidden" name="contenido_id" value="<?php echo $id; ?>"/>
						<input type="hidden" name="tabla" 		 value="<?php echo $tabla; ?>"/>
						<input type="hidden" name="ruta" 		 value="<?php echo $archivo; ?>"/>
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
<?php if (isset($connection)){ mysql_close($connection); } ?>
