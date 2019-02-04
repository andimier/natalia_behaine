<?php
	require_once("includes/requeridos.php");

	$mensaje = "";
	$palabras = "";
	$descripcion = "";

	if (!isset($_GET['seccion_id'])) {
		header("Location: content.php");	
		exit;
	} else {
		$seccion_id = $_GET['seccion_id'];
		$seccion = $_GET['sec'];
		require_once("edicion/act-metatags.php");

		$query = "SELECT * FROM metatags WHERE seccion_id = {$seccion_id}";
		$result = mysql_query($query, $connection);

		while ( $datos = mysql_fetch_array($result)) {
			$id = $datos['id'];
			$palabras1 = $datos['palabras1']; 
			$descripcion1 = $datos['descripcion1'];
			$palabras2 = $datos['palabras2']; 
			$descripcion2 = $datos['descripcion2'];
			$palabras3 = $datos['palabras3']; 
			$descripcion3 = $datos['descripcion3'];
		}
	}	
?>
