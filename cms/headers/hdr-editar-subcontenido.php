<?php
	require_once("includes/sesion.php");
	require_once("includes/connection.php");
	require_once("includes/functions.php");

	$mensaje = "";

	date_default_timezone_set('America/Bogota');
	$fecha = date("Y-m-d");

	$imagen1 = '';
	$imagen2 = '';
	$imagen3 = '';

	require_once('edicion/insertar_textos.php');
	//require_once('edicion/cambioimagen1.php');
	require_once('edicion/edc_imagenes/img_cambio.php');

	encontrar_seccion_y_contenido_seleccionados();

	if (isset( $_GET['contenido_id']) ) {
		$id = mysql_prep($_GET['contenido_id']);

		$q_textos  = " SELECT * FROM textos_contenidos ";
		$q_textos .= " WHERE contenido_id =" . $contenido_seleccionado['id'];
		$q_textos .= " AND idioma = 0";

		$r_textos = mysql_query($q_textos, $connection);
	}
	
	// PARAMETROS FORMULARIO ACTUALIZACION DE CONTENIDOS
	$tabla   = "contenidos";
?>