<?php 
	
	require_once('requeridos/conexion/connection.php');

	$seccion = 3.1;
	$idioma = 0;
	$hijo=true;
	
	require_once('requeridos/qs.php');
	
	$ruta = '../';
	
	
	//$ruta = '../';

?>

<!doctype html>
<html>
	<head>
		<?php echo 'ruta = ' . $ruta; ?>
		<link rel="shorcut icon" href="<?php echo $ruta; ?>imagenes/icon.png" type="image/x-icon" />
		
		<?php include( 'requeridos/tags2.php'); ?>
		
		
		<link href="<?php echo $ruta; ?>estilos/proyectos-gr2.css" type="text/css" rel="stylesheet" media="screen"/>
		<link rel="stylesheet" type="text/css"  media="only screen and (min-width:481px) and (max-width:800px)" href="<?php echo $ruta; ?>estilos/proyectos-md.css" />
		<link rel="stylesheet" type="text/css"  media="only screen and (min-width:50px) and (max-width:480px)" href="<?php echo $ruta; ?>estilos/proyectos-pq.css" />
		
		<?php include('requeridos/tags-galeria.php'); ?>
		
		<link rel="stylesheet" type="text/css"  media="screen" href="<?php echo $ruta; ?>estilos/cabezote-gr.css"  />
		<link rel="stylesheet" type="text/css"  media="only screen and (min-width:480px) and (max-width:800px)" href="<?php echo $ruta; ?>estilos/cabezote-md.css" />
		<link rel="stylesheet" type="text/css"  media="only screen and (min-width:50px) and (max-width:479px)" href="<?php echo $ruta; ?>estilos/cabezote-pq.css" />
		
	</head>
<body>
		
		

<?php require_once('cuerpo/proyecto2.php'); ?>