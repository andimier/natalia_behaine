<?php 
	
	require_once("../includes/connection.php");
	
	$q_select_imagenes = "SELECT id, contenido_id FROM imagenes_albums WHERE contenido_id > 0";
	$r_select_imagenes = mysql_query($q_select_imagenes, $connection);
	
	$q_select_contendios = "SELECT id, contenido_id FROM contenidos";
	$r_select_contenidos = mysql_query($q_select_contendios, $connection);
	//$imagen1 = mysql_fetch_array($r_select_imagenes);
	
	while($imagen = mysql_fetch_array($r_select_imagenes)){
		//$imagenes[] = $imagen["contenido_id"];
		$imagenes[] = $imagen["contenido_id"];
		$imagenes_id[] = $imagen["id"];
	}
	
	while($contenido = mysql_fetch_array($r_select_contenidos)){
		$contenidos[] = $contenido["id"];
	}
	
	//echo count($imagenes);
	//echo count($contenidos);
	
	if(count($imagenes) > count($contenidos)){
		
		$ref = count($imagenes);
	}else{
		$ref = count($contenidos);
	}
	
	echo 'cuenta = '.count($imagenes);
	echo '<br> <br>';
	for($i = 0; $i <count($imagenes); $i++ ){
		echo $imagenes[$i]. '<br>';
	}
	echo '<br> <br>';
	//echo 'imagen = '.$imagen1[1]. '<br>';
	//echo count($imagen1) . '<br>';
	//print_r($imagen1) . '<br>';
	
	for($i = 0; $i <count($imagenes); $i++ ){
		
		//$search =  array_search($imagenes[$i], $contenidos) ;
		$search =  array_search($imagenes[$i], $contenidos) ;
		
		if($search == 0 || $search == ''){
			echo $imagenes[$i] . '-' . $imagenes_id[$i]. '<br>';
		}

	}
	
	
	
	echo '<br> <br>';
	for($i = 0; $i <count($contenidos); $i++ ){
		echo $contenidos[$i]. '<br>';
	}
	