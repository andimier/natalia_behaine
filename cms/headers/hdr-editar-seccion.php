<?php 
    $mensaje = "";

	date_default_timezone_set('America/Bogota');
	$fecha = date("Y-m-d");

	$imagen1 = '';
	$imagen2 = '';
	$imagen3 = '';

	//require_once('edicion/insertar_contenidos.php');
	
	// MOSTRAR MENSAJE DE INSERCION DE CONTENIDO
	if (isset($_GET['act'])) {
		$mensaje = '<div id="mensaje_positivo">Contenido creado correctamente</div>';
		unset($_GET['act']);
	}

	require_once('edicion/edc_imagenes/img_cambio.php');
	encontrar_seccion_y_contenido_seleccionados();

	$seccion_id = mysql_prep($_GET['seccion']);

	$q_contenido  = "SELECT * FROM contenidos ";
	$q_contenido .= "WHERE seccion_id = {$seccion_id} ";
	$q_contenido .= "AND contenido_id = 0 ";
	$q_contenido .= "ORDER BY fecha DESC";

	$contenidos = phpMethods('query', $q_contenido);
	confirm_query($contenidos); 

	//========== PARAMETROS FORMULARIO ACTUALIZACION DE CONTENIDOS =================//
	
	$tabla   = "secciones";	
	$id = $seccion_seleccionada['id'];
	$seccion = $seccion_seleccionada['id'];
	$imagenprincipal = $seccion_seleccionada['imagen1'];
	$img = $seccion_seleccionada['imagen2'];

	$campos_arr = array(
		0 => array('id'=>1, 'meta-tags'=> true,  'img-pr'=>true,  'nvo-contenido' => false, 'editar-extras'=>false),
		1 => array('id'=>2, 'meta-tags'=> true,  'img-pr'=>false, 'nvo-contenido' => true,  'editar-extras'=>false),
		2 => array('id'=>3, 'meta-tags'=> false, 'img-pr'=>false, 'nvo-contenido' => true,  'editar-extras'=>false),
		3 => array('id'=>4, 'meta-tags'=> true,  'img-pr'=>false, 'nvo-contenido' => true,  'editar-extras'=>false),
		4 => array('id'=>6, 'meta-tags'=> true,  'img-pr'=>false, 'nvo-contenido' => false, 'editar-extras'=>false),
		5 => array('id'=>7, 'meta-tags'=> true,  'img-pr'=>false, 'nvo-contenido' => false, 'editar-extras'=>false),
		6 => array('id'=>8, 'meta-tags'=> true,  'img-pr'=>true,  'nvo-contenido' => true, 'editar-extras'=>false)
    );
?>
