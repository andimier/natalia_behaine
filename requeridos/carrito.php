<?php

	$en_array = false;
	$i = 0;
	
	if(isset($_POST['pid'])){
		
		$pid = $_POST['pid'] . '<br>';
		$titulo = $_POST['titulo'] . '<br>';
		$imagen = $_POST['imagen'];
		$link_carrito = $_POST['link-carrito'];
		
		if( !isset($_SESSION['carrito_arr']) || count($_SESSION['carrito_arr']) < 1 ){
			
			$_SESSION['carrito_arr'] = array( 0 =>array('item_id' => $pid, 'titulo'=> $titulo, 'imagen'=>$imagen, 'cantidad' =>1));
			//echo $idioma;
			if($idioma == 0){
				header('Location: ../'.$link_carrito );
			}else{
				header('Location: ../../'.$link_carrito );
			}
			
	
			
		}else{
			
			foreach( $_SESSION['carrito_arr'] as $cada_item){
				
				while( list($key, $value) = each($cada_item)){
					if($key == "item_id" && $value == $pid){
						array_splice($_SESSION['carrito_arr'], $i, 1, array(array("item_id" => $pid, "titulo"=> $titulo, "imagen"=>$imagen, "cantidad" => $cada_item['cantidad']+1 )));
						$en_array = true;
					}
				}
				
				$i++;
			}
			
			if($en_array == false){
				array_push($_SESSION['carrito_arr'], array("item_id"=>$pid, "titulo"=> $titulo, "imagen"=>$imagen, "cantidad" => 1));
			}
			// REDIRECCIONAR PARA EVITAR AUMENTAR LA CANTIDAD
			// AL RECARGAR LA PÁGINA
			
			//echo $idioma;
			if($idioma == 0){
				header('Location: ../'.$link_carrito );
			}else{
				header('Location: ../../'.$link_carrito );
			}
	
		}
	}
	
	
	// VACIAR CARRITO DE COMPRAS
	if(isset($_GET['cmd']) && $_GET['cmd'] = 'vaciarcarrito'){
		unset($_SESSION['carrito_arr']);
	}
	
	
	
	//$base = array(0 =>array("orange", "banana", "apple", "raspberry"), 1=>array('andi', 'john'));
	//$replacements = array(0 => "pineapple", 4 => "cherry");
	////$replacements2 = array(0 => "grape");
	//
	//$basket = array_replace($base[0], $replacements);
	//
	//print_r($base) . '<br><br>';


	//$base = array('citrus' => array( "orange" => 1, "cosa" => 5) , 'berries' => array("blackberry", "raspberry"), );
	//$replacements = array('citrus' => array('orange' => 0), 'berries' => array('blueberry'));

	//$base = array_replace_recursive($base, $replacements);
	//print_r($base);

	//$basket = array_replace($base, $replacements);
	//print_r($basket);
	
	
	
	
	// CAMBIO DE CANTIDAD
	if(isset($_POST['btn-cambio-cantidad'])){
		
		$item = $_POST['item'];
		$cantidad = $_POST['cantidad'];
		$link_carrito = $_POST['link-carrito'];
		
		// QUITAR PUNTOS PARA DECIMALES
		$cantidad = preg_replace('#[^0-9]#i',"", $cantidad);
		
		if($cantidad < 1 || $cantidad == ""){
			$cantidad = 1;
		}
		
		$i = 0;
		
		foreach( $_SESSION['carrito_arr'] as $cada_item){
			
			$remplazo = array($i => array('cantidad'=>$cantidad));
			
			while( list($key, $value) = each($cada_item)){
				
				if($key == "item_id" && $value == $item){
		
					$_SESSION['carrito_arr'] = array_replace_recursive($_SESSION['carrito_arr'], $remplazo);
				}
				
			}
		
			$i++;
			
		}
		
		header('Location: '. $link_carrito);
	
	}else{
		//echo 'no llega';
	}
	
	
	// ELIMINAR ELEMENTO DEL PEDIDO
	if( isset($_POST['quitar_index']) && $_POST['quitar_index'] != ''){
		
		$elemento_quitar = $_POST['quitar_index'];
		$link_carrito = $_POST['link-carrito'];
		
		if(count($_SESSION["carrito_arr"]) <= 1 ){
			unset($_SESSION["carrito_arr"]);
			header('Location: '. $link_carrito);
		}else{
			unset($_SESSION["carrito_arr"][$elemento_quitar]);
			sort($_SESSION["carrito_arr"]);
			header('Location: '. $link_carrito);
		}
	}
	
	
?>