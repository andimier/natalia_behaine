<?php 
	require_once('requeridos/conexion/connection.php');
	$seccion = 4;
	$idioma = isset($_GET['lang']) ? $_GET['lang'] : 0;
	$hijo = false;

	require_once('requeridos/qs.php');
	require_once('requeridos/elementos-arr.php');
	require_once('requeridos/phpcontacto.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include('requeridos/tags.php'); ?>
		<link href="estilos/contacto-gr.css" rel="stylesheet" type="text/css"  media="screen"   />
		<link href="estilos/contacto-pq.css" rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:480px)"   />
	</head>

	<body>
		<?php include('requeridos/cabezote1.php'); ?>
		<div id="cuerpo">
			<div id="cnt_contacto">
				<h2><?php echo $gn_arr['ubicacion'][0][$idioma]; ?></h2>
				<h2><?php echo $info; ?></h2>

				<div id="cnt_formulario">
					<form id="formulario" autocomplete="on" name="formulario" enctype="multipart/form-data" method="POST" onsubmit="return validateForm()">
						<input class="campo" type="text"  name="nombre" placeholder="<?php echo $gn_arr['titulos']['nombre'][$idioma]; ?>"><br>
						<textarea class="campo" name="mensaje" rows="4" cols="50" placeholder="<?php echo $gn_arr['titulos']['mensaje'][$idioma]; ?>"></textarea>
						<input id="btn_enviar" type="submit" name="enviar" value="<?php echo $gn_arr['titulos']['enviar'][$idioma]; ?>">
					</form>
				</div>
			</div>
			<script>
				function validateForm(){
					var email = document.forms["formulario"]["email"].value,
						atpos  = email.indexOf("@"),
						dotpos = email.lastIndexOf("."),
						x = document.forms["formulario"]["nombre"].value,
						y = document.forms["formulario"]["email"].value,
						z = document.forms["formulario"]["mensaje"].value;

					if (atpos <1 || dotpos < atpos+2 || dotpos+2 >= email.length) {
						alert( '<?php echo $gn_arr['titulos']['correo-invalido'][$idioma]; ?>' );
						return false;
					} else if ( z == null || z == "") {
						alert('<?php echo $gn_arr['titulos']['escribir-mensaje'][$idioma]; ?>');
						return false;
					}

					if ( x == null || x == "" ){
						alert('<?php echo $gn_arr['titulos']['escribir-nombre'][$idioma]; ?>');
						return false;
					} else if ( y == null || y == "") {
						alert('<?php echo $gn_arr['titulos']['escribir-correo'][$idioma]; ?>');
						return false;
					}
				}
			</script>
		</div>
		<?php require_once('requeridos/footer.php'); ?>
	</body>
</html>

