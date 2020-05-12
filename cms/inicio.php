<?php 
	require_once("includes/sesion.php");
	require_once("includes/connection.php");
	require_once("utils/phpfunctions.php");
	require_once("includes/functions.php");

	encontrar_seccion_y_contenido_seleccionados();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head><?php require_once('includes/tags.php'); ?></head>
	<body>
		<div id="cnt_edicion">
			<div id="col2">
				<h3>
					Hola!
					<br>

					Para editar las secciones utiliza el menú ubicado a la izquierda.<br>
					Haz click en el título de alguna de las secciones.
				</h3>
			</div>
		</div>

		<script src="js/general.js" type="text/javascript"></script>
		<br />
		<br />

		<div id="footer"></div>
		<?php include_once('includes/cabezote.php'); ?>
		<?php include_once('includes/navegacion.php'); ?>
	</body>
</html>
<?php if(isset($connection)){ phpMethods('close', $connection); } ?>
