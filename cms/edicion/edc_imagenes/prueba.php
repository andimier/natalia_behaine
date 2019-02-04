<?php

if(isset($_POST['boton'])){
	
	$id    = $_POST['contenido_id'];
	$tabla = $_POST['tabla'];
	
	if(isset($_POST['ruta'])){
		
		$ruta = $_POST['ruta'];
		$arr = explode('/', $ruta);
		$archivoparaborrar = $arr[2];
		$archivomediano = "imagenes/medianas/" . $archivoparaborrar;
		$archivogrande  = "imagenes/grandes/"  . $archivoparaborrar;
		
		if($archivoparaborrar == 'camara_01.png'){
			
		}else{
			echo $ruta . "<br />";
			echo $archivomediano . "<br />";
			echo $archivogrande;
			
		}
	}

}else{
	//$mensajeimagen =  "No se ha enviado nada.";
}

	
	
?>

