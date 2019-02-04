<?php require_once("headers/hdr-editar-metatags.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include_once('includes/tags.php'); ?>
	</head>
	<body>
		<div id="col2">
			<div id="cnt_edicion">
				<h3><?php echo $seccion; ?></h3>
				<?php echo $mensaje; ?>

				<form enctype="multipart/form-data" name="form_metatags" id="form_metatags" method="post">
					<br />
					<br />

					<input type="hidden" name="id" value="<?php echo $id; ?>">

					<label>PALABRAS CLAVE</label>
					<br />
					<br />

					<textarea name="palabras1" id="areadeficha" cols="70" rows="7"><?php echo $palabras1; ?></textarea>
					<br />
					<br />

					<label>DESCRIPCIÓN</label>
					<br />
					<br />

					<textarea name="descripcion1" id="areadeficha" cols="70" rows="7"><?php echo $descripcion1; ?></textarea>
					<br />
					<br />
					<br />

					<!-- //// INGLÉS //// -->
					<div class="mensaje">INGLÉS</div> 
					<br />

					<label>KEY WORDS
					<br />
					<br />

					<textarea name="palabras2" id="areadeficha" cols="70" rows="7"><?php echo $palabras2; ?></textarea>
					<br />
					<br />

					<label>DESCRIPTION
					<br />
					<br />

					<textarea name="descripcion2" id="areadeficha" cols="70" rows="7"><?php echo $descripcion2; ?></textarea>
					</label>
					<br />
					<br />
					<br />

					<!-- //// PORTUGUES ////-->
					<div class="mensaje1">FRANCÉS</div>
					<br />

					<label>MOTS CLÉS
					<br />
					<br />

					<textarea name="palabras3" id="areadeficha" cols="70" rows="7"><?php echo $palabras3; ?></textarea>
					</label>
					<br />
					<br />

					<label>DESCRIPTION
					<br />
					<br />

					<textarea name="descripcion3" id="areadeficha" cols="70" rows="7"><?php echo $descripcion3; ?></textarea>
					</label>
					<br />

					<input type="submit" name="guardar" class="boton1" value="Guardar" /> 
					<br />
					<br />
				</form>
			</div>
		</div>

		<div id="footer"></div>
		<?php include_once('includes/cabezote.php'); ?>
		<?php include_once('includes/navegacion.php'); ?>

		<script src="js/general.js" type="text/javascript"></script>
	</body>
</html>
