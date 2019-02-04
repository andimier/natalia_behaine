<?php
	require_once('requeridos/conexion/connection.php');
	$seccion = 0;

	if(isset($_GET['lang'])){
		$idioma = $_GET['lang'];
	}else{
		$idioma = 0;
	}

	$hijo = false;

	require_once('requeridos/qs.php');
	require_once('requeridos/elementos-arr.php');	
?>

<!doctype html>
<html>
	<head>
		<?php include('requeridos/tags.php'); ?>
		<link href="estilos/inicio-gr.css" type="text/css" rel="stylesheet" media="screen"/>
		<!--<link href="estilos/inicio-md.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:481px) and (max-width:800px)"  />-->
		<link href="estilos/inicio-pq.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:50px) and (max-width:480px)" />	
	</head>
	<body>

		<?php include('requeridos/cabezote1.php'); ?>

		<div id="img_inicio">
			<img src="cms/<?php echo $img2; ?>" />
		</div>

		<div id="txt_inicio">
			<p><?php echo $txt; ?></p>
		</div>

		<?php require_once('requeridos/footer.php'); ?>
	</body>
</html>


