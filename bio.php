<?php
	require_once('requeridos/conexion/connection.php');
	$seccion = 1;
	$tabla = 'contenidos';
	$idioma = (isset($_GET['lang'])) ? $_GET['lang'] : 0;
	$hijo = false;
	require_once('requeridos/qs.php');
	require_once('requeridos/elementos-arr.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<?php require_once('requeridos/tags.php'); ?>
		<link href="estilos/inicio-gr.css" rel="stylesheet" type="text/css"  media="screen"/>
		<link href="estilos/inicio-pq.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:50px) and (max-width:480px)"  />
		<link href="estilos/bio-gr.css" rel="stylesheet" type="text/css"  media="screen"/>
	</head>

	<body>
		<?php require_once('requeridos/cabezote1.php'); ?>

		<div id="cuerpo">
			<?php while($bio = mysql_fetch_array($r_bio)): ?>
				<div class="tarjeta">
					<h1 class="tt1"><?php echo $bio['titulo']; ?></h1>
					<p><?php echo $bio['contenido']; ?></p>
				</div>
			<?php endwhile; ?>
		</div>
		<?php require_once('requeridos/footer.php'); ?>
	</body>
</html>
