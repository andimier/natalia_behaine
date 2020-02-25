<?php
	require_once('../requeridos/conexion/connection.php');
	$seccion = 8;

	$idioma = isset($_GET['lang']) ? $_GET['lang'] : 0;
	$hijo = false;

	require_once('../requeridos/qs.php');
	require_once('../requeridos/elementos-arr.php');
	require_once('../requeridos/qs-comercial.php');
?>

<!doctype html>
<html>
	<head>
		<?php include('../requeridos/tags.php'); ?>
		<link href="estilos/comercial-gr.css" rel="stylesheet" type="text/css"  media="screen"/>
		<link href="estilos/comercial-md.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:481px) and (max-width:800px)"  />
		<link href="estilos/comercial-pq.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:50px)  and (max-width:480px)" />
		<?php include('../requeridos/tags-galeria.php'); ?>
	</head>

	<body>
		<?php include('../requeridos/cabezote3.php'); ?>

		<div id="cuerpo">
			<div id="cnt_contacto">
				<h2>Bogotá, Colombia</h2>
				<h2><a href="http://www.nataliabehaine.com/en/contact">nataliabehaine@gmail.com</a></h2>
			</div>

			<?php while($contenido = phpMethods('fetch', $r_comercial)): ?>
				<div class="comercial-tarjeta">

					<h1><?php echo $contenido['titulo']; ?></h1>
					<h2 style="display:none;"><?php echo str_replace('-', '/', $contenido['fecha']); ?></h2>

					<div class="comercial-cnt-img">
						<?php imagenPrincipal($contenido['id'], $idioma); ?>
					</div>

					<div class="comercial-cnt-imgs" style="display:none;">
						<?php qFotosAlbum($contenido['id'], $idioma); ?>
					</div>

					<div class="comercial-cnt-imagenes"></div>

					<div class="comercial-txt">
						<p>
							<?php echo $contenido['contenido']; ?>
						</p>
					</div>

					<div class="vacio"></div>
				</div>
			<?php endwhile ?>
		</div>

		<?php require_once('../requeridos/footer.php'); ?>
	</body>
	<script src="js/f-box.js"></script>
	<script src="js/comercial.js"></script>
</html>


