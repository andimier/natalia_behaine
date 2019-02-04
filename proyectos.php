<?php
	require_once('requeridos/conexion/connection.php');
	$seccion = 2;
	$tabla = 'contenidos';
	$idioma = (isset($_GET['lang'])) ? $_GET['lang'] : 0;

	require_once('requeridos/qs.php');
	require_once('requeridos/elementos-arr.php');
	require_once('requeridos/caracteres-arr.php');

	function reemplazarAcentos($arrcaract, $gn_arr, $seccion, $idioma, $titulo) {
		// RECORRER EL ARRAY PARA REEMPLAZAR CARACTERES CON ACENTOS
		$ttparcial = str_replace(array_keys($arrcaract), array_values($arrcaract), $titulo);
		$ttlink = str_replace(' ', '-', $ttparcial);
		$url_proyecto = $gn_arr['url-lang'][$seccion + 3][$idioma];
		$url_proyecto .= strtolower($ttlink);

		return $url_proyecto;
	}
	
	function imprimirSoloAno($fecha) {
		return explode("-", $fecha)[0];
	}
    
    $proyectos = getPoyectsList($idioma, $connection);
?>

<!DOCTYPE html>
<html>
	<head>
		<?php include('requeridos/tags.php'); ?>
		<link href="estilos/proyectos-gr.css" rel="stylesheet" type="text/css"  media="screen"/>
		<link href="estilos/proyectos-md.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:481px) and (max-width:800px)"  />
		<link href="estilos/proyectos-pq.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:50px) and (max-width:480px)"  />
	</head>

	<body id="proyectos">
		<?php include('requeridos/cabezote1.php'); ?>
		<div id="cuerpo">
			<div class="contenedor-proyectos">
				<?php foreach($proyectos as &$proyecto): ?>
					<div class="contenedor-proyecto">
						<a href="<?php echo reemplazarAcentos($arrcaract, $gn_arr, $seccion, $idioma, $proyecto['titulo']); ?>">
							<div class="tarjeta_prg">
								<div class="img_prg">
									<img class="prg-img" src="<?php echo 'cms/' . $proyecto['imagen']; ?>" />
								</div>

								<div class="cnt_txt_prg">
									<div class="txt_prg">
										<h2><?php echo imprimirSoloAno($proyecto['fecha']); ?></h2>
										<h1><?php echo $proyecto['titulo']; ?></h1>
									</div>
								</div>
								<div class="vacio"></div>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php require_once('requeridos/footer.php'); ?>
	</body>
</html>