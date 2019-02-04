<?php
	require_once('requeridos/conexion/connection.php');
	$seccion = 6;
    $idioma = isset($_GET['lang']) ? $_GET['lang'] : 0;
	$hijo = false;
	require_once('requeridos/qs.php');
	require_once('requeridos/elementos-arr.php');
    require_once('requeridos/modelos/modelo-proyecto.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include('requeridos/tags.php'); ?>
		<link href="estilos/proyectos-gr.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="estilos/proyectos-md.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:481px) and (max-width:800px)"  />
		<link href="estilos/proyectos-pq.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:50px) and (max-width:480px)"  />
		<?php include('requeridos/tags-galeria.php'); ?>
	</head>

	<body>
		<?php include('requeridos/cabezote1.php'); ?>

		<div id="cuerpo">
			<div id="cnt_galeria">
				<div id="galeria">
					<?php for ($i = 0; $i < count($img_arr); $i++): ?>
						<div class="foto">
							<a class="fancybox" href="<?php echo 'cms/' . $img_arr[$i]['imagen3']; ?>" data-fancybox-group="gallery" title="<?php echo $img_arr[$i]['alt']; ?>">
								<img class="foto-img" src="<?php echo 'cms/' . $img_arr[$i]['imagen1']; ?>" alt="<?php echo $img_arr[$i]['alt']; ?>"/>
							</a>
						</div>
					<?php endfor; ?>

					<div class="vacio limite"></div>
				</div>
			</div>

			<script src="js/galeria.js"></script>
		</div>

		<?php require_once('requeridos/footer.php'); ?>
	</body>
</html>
