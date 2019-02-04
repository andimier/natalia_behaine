<?php

	require_once("includes/sesion.php");
	require_once("includes/connection.php");
	require_once("includes/functions.php");
	
	
	
	if(isset($_GET['seccion_id'])){
	
		$seccion_id = $_GET['seccion_id'];
		
		$seccion = $_GET['sec'];

		$palabras1 = "Cambia este texto";
		$descripcion1 = "Cambia este texto";
		
		
		$busqueda = "SELECT id FROM metatags WHERE seccion_id = {$seccion_id}";
		$resultado = mysql_query($busqueda, $connection);
		
		if(mysql_num_rows($resultado) >= 1){
			//echo "Bien --- {$id}";
			//header('Location: content.php');
			header('Location: editar-metatags.php?seccion_id='. $seccion_id . '&sec=' . $seccion);
			exit;
		}else{
			//"NO HAY NADA";
			$creacion = "
			INSERT INTO metatags (seccion_id, palabras1, descripcion1) 
			VALUES ('{$seccion_id}', '{$palabras1}', '{$descripcion1}')
			";
			
			$crear = mysql_query($creacion, $connection);
			
			if(mysql_affected_rows() >= 1){
				//echo "Se creó correctamente";
				header('Location: editar-metatags.php?seccion_id='. $seccion_id . '&sec=' . $seccion);
			}else{
				echo mysql_error();
				echo "No se creo nada";
			}
		}
	}


?>