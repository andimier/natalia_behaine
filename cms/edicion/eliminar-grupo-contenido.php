<?php 
	
	require_once("../includes/connection.php");
	
	$general_arr = array();
	$general_img_arr = array();
	$tabla = 'contenidos';
	
	if(isset($_POST['id'])){
		$id = $_POST['id'];
	}
	
	if(isset($_POST['seccion'])){
		$seccion = $_POST['seccion'];
	}
	
	
	$q_contenidos = "SELECT id, titulo, imagen1 FROM contenidos WHERE id = " . $id;
	$r_contenidos = mysql_query($q_contenidos, $connection);
	
	$contenidos_id = array();
	
	if(mysql_num_rows($r_contenidos) > 0){

		while($contenido = mysql_fetch_array($r_contenidos)){
			
			array_push($contenidos_id, $contenido["id"]);
			array_push($general_arr, array($tabla, $contenido["id"]));
			
			// INSERTAR LA IMAGEN PRINCIPAL EN EL ARRAY
			if(!empty($contenido["imagen1"])){
				array_push($general_img_arr, $contenido["imagen1"]);
			}
			
			//echo $contenido["id"] . ' - ' . $contenido["titulo"] .  ' / ' .  $contenido["imagen1"] . '<br>';
		}
		
		subcontenidos($id, $contenidos_id);
		
	}else{
		////echo 'no hay contenidos con este id';
		
	}
	
	
	
	// RUTA 1
	// CONTENIDOS -> SUB CONTENIDOS
	
	function subcontenidos($id, $contenidos_id){
		
		//echo '<br>';
		//echo 'RUTA 1 => SUB CONTENIDOS => TEXTOS => IMAGENES ALBUMS (imagenes de los subcontenidos) => ENTRADAS IMAGENES => TEXTOS ENTRADAS IMAGENES <BR><BR> ';
		
		$subcontenidos = array();
		global $connection;
		global $general_arr;
		$tabla = 'contenidos';
	
		if(count($contenidos_id) > 0){

			for($b = 0; $b <count($contenidos_id); $b++ ){
			
				$q_contenidos2 = "SELECT id, contenido_id, titulo FROM contenidos WHERE contenido_id = " . $id;
				$r_contenidos2 = mysql_query($q_contenidos2, $connection);
				
				//***
				if(mysql_num_rows($r_contenidos2) > 0){
					
					while($contenido2 = mysql_fetch_array($r_contenidos2)){
                    
						array_push($subcontenidos, $contenido2["id"]);
						array_push($general_arr, array($tabla, $contenido2["id"]));
						
						//$sub_arr  = 'sub-contenidos = ';
						//$sub_arr .= $contenido2["contenido_id"] . ' - ';
						//$sub_arr .= $contenido2["id"] . ' - ';
						//$sub_arr .= $contenido2["titulo"] . ' <br> ';
						
						//echo $sub_arr;
					}
				}
			}
			
			textos($subcontenidos);
	
		}else{
			ruta2();
		}
	}
	
	
	
	//***
	// SUB CONTENIDOS -> TEXTOS 
	
	function textos($subcontenidos){
		
		//echo '<br>';
		
		$textos_arr = array();
		
		global $connection, $general_arr, $general_img_arr;
		$tabla = 'textos_contenidos';
	
		if(count($subcontenidos) > 0){
		
			for($c = 0; $c <count($subcontenidos); $c++ ){
			
				$q_textos = "SELECT id, contenido_id, texto_id, idioma, titulo, imagen1 FROM textos_contenidos WHERE contenido_id = " . $subcontenidos[$c];
				$r_textos = mysql_query($q_textos, $connection);
				
				if(mysql_num_rows($r_textos) > 0){
					
					while($texto = mysql_fetch_array($r_textos)){
						
						array_push($textos_arr, $texto["id"]);
						array_push($general_arr, array($tabla, $texto["id"]));
						
						
						$tx  = 'tex = ';
						$tx .= $texto["contenido_id"] .' - ';
						$tx .= $texto["id"] . ' - ';
						$tx .= $texto['texto_id'];
						
						if($texto['idioma'] == 0){
							$tx .= ' /   ' . $texto['titulo'] . ' / ';
							$tx .= $texto['imagen1'] . '<br>';
							
							// INSERTAR LAS IMAGENES EN EL ARRAY
							// SE PONE AQUÍ PARA EVITAR INSERTAR ENTRADAS EN BLANCO
							if(!empty($texto["imagen1"])){
								array_push($general_img_arr, $texto["imagen1"]);
							}
							
						}else{
							$tx .=  '<br>';
						}
						
						
						//echo $tx;
						
					}
				}else{
					////echo 'no hay textos asociados a este SUB CONTENIDO <br>';
				}
			}
		
			imagenes($textos_arr);
		}else{
			ruta2();
		}
		
	}
	
	
	
	function imagenes($textos_arr){
		
		//echo '<br>';
	
		$img2_arr = array();
		global $connection, $general_arr, $general_img_arr;
		$tabla = 'imagenes_albums';
		
		if(count($textos_arr) > 0){
			
			for($d = 0; $d <count($textos_arr); $d++ ){
			
				$q_img2 = "SELECT id, texto_id, imagen1, imagen2, imagen3 FROM imagenes_albums WHERE texto_id = " . $textos_arr[$d];
				$r_img2 = mysql_query($q_img2, $connection);
				
				if(mysql_num_rows($r_img2) > 0){
					
					while($img2 = mysql_fetch_array($r_img2)){
						
						array_push($img2_arr, $img2["id"]);
						array_push($general_arr, array($tabla, $img2["id"]));
						
						$im = 'imagenes = ';
						$im .= $img2["texto_id"] . ' - ';
						$im .= $img2["id"] . ' - ';
						$im .= $img2["imagen1"] . ' <br> ';
						
						//echo $im;
					}
				}
			}
			
			entradas($img2_arr);
		}else{
			ruta2();
		}
		
		////echo 'si';
		
	}
	
	
	
	
	function entradas($img2_arr){
		
		//echo '<br>';
		
		global $connection;
		global $general_arr;
		$tabla = 'img_entradas';
		$entradas_arr = array();
		
		if(count($img2_arr) > 0){
			
			for($e = 0; $e <count($img2_arr); $e++ ){
				
				$q_entrada_img = "SELECT id, img_id FROM img_entradas WHERE img_id = " . $img2_arr[$e];
				$r_entrada_img = mysql_query($q_entrada_img, $connection);
				
				if(mysql_num_rows($r_entrada_img) > 0){
					
					while($entrada = mysql_fetch_array($r_entrada_img)){
						
						array_push($entradas_arr, $entrada["id"]);
						array_push($general_arr, array($tabla, $entrada["id"]));
						
						$en = 'entradas imagenes = ';
						
						$en .= $entrada["img_id"] . ' - ';
						$en .= $entrada["id"] . ' <br> ';
						//echo $en;
					}
				}
			}
			
			imgEntradasTextos($entradas_arr);
		}else{
			ruta2();
		}
		
	}
	
	
	
	function imgEntradasTextos($entradas_arr){
		
		//echo '<br>';
		
		global $connection;
		global $general_arr;
		$tabla = 'img_entradas_textos';
	
		$entradas_textos_arr = array();
		
		
		if(count($entradas_arr) > 0){
			
			for($f = 0; $f <count($entradas_arr); $f++ ){
				
				$q_entrada_img_textos = "SELECT id, img_id, img_entrada_id FROM img_entradas_textos WHERE img_entrada_id = " . $entradas_arr[$f];
				$r_entrada_img_textos = mysql_query($q_entrada_img_textos, $connection);
				
				if(mysql_num_rows($r_entrada_img_textos) > 0){
					
					while($entrada_texto = mysql_fetch_array($r_entrada_img_textos)){
						
						array_push($entradas_textos_arr, $entrada_texto["id"]);
						array_push($general_arr, array($tabla, $entrada_texto["id"]));
						
						$en_img = 'entradas imagenes textos= ';
						$en_img .= $entrada_texto["img_entrada_id"] . ' - ';
						$en_img .= $entrada_texto["id"] . ' <br> ';
						//echo $en_img;
						
					}

				}

			}
			
			finalRuta1($entradas_textos_arr);
		}else{
			ruta2();
		}
		
	}
	
	function finalRuta1 ($entradas_textos_arr){
		
		////echo "---------------------<br>";
		
		if(count($entradas_textos_arr) > 0){
			ruta2();
			////echo "saliendo de la 1 <br>";
		}else{
			ruta2();
			////echo 'no hay en img entradas textos <br>';
		}
	}

	
	
	function ruta2(){
		//echo '<br>';
		//echo '---------------------<br>';
		//echo '<br>';
		//echo 'RUTA 2 => CONTENIDOS => IMAGENES ALBUMS (imagen principal del contenido) => ENTRADAS IMAGENES => TEXTOS ENTRADAS IMAGENES <BR><BR> ';
		
		global $contenidos_id;
		global $connection;
		global $id;
		global $general_arr;
		global $general_img_arr;
		
		$tabla = "imagenes_albums";
		$imagenes_arr = array();
		
		// CONTENIDOS -> IMAGENES 
		if(count($contenidos_id) > 0){
			
			for($i = 0; $i <count($contenidos_id); $i++ ){
			
				$q_imagenes = "SELECT id, contenido_id, imagen1, imagen2, imagen3 FROM imagenes_albums WHERE contenido_id = " . $id;
				$r_imagenes = mysql_query($q_imagenes, $connection);
				
				while($imagen = mysql_fetch_array($r_imagenes)){
					
					array_push($imagenes_arr, $imagen["id"]);
					array_push($general_arr, array($tabla, $imagen["id"]));
					
					// INSERTAR IMAGEN EN EL ARRAY BARA BORRARLA
					if(!empty($imagen["imagen1"])){
						array_push($general_img_arr, $imagen["imagen1"]);
					}

					//echo 'imagenes = ' . $imagen["contenido_id"] . ' - ' . $imagen["id"] . ' - '.  $imagen["imagen1"] . '<br>';
				}
			}
			
			entradas2($imagenes_arr);
		}else{
			ruta3();
		}
	}
	
	
	function entradas2($imagenes_arr){
		
		//echo "<br>";
		
		global $connection;
		global $general_arr;
		$entradas2_arr = array();
		$tabla = 'img_entradas';
		
		if(count($imagenes_arr) > 0){
			
			for($g = 0; $g <count($imagenes_arr); $g++ ){
			
				$q_entrada_img = "SELECT id, img_id FROM img_entradas WHERE img_id = " . $imagenes_arr[$g];
				$r_entrada_img = mysql_query($q_entrada_img, $connection);
				
				if(mysql_num_rows($r_entrada_img) > 0){
					
					while($entrada = mysql_fetch_array($r_entrada_img)){
						
						array_push($entradas2_arr, $entrada["id"]);
						array_push($general_arr, array($tabla, $entrada["id"]));
						
						$en = 'entradas imagenes 2 = ';
						
						$en .= $entrada["img_id"] . ' - ';
						$en .= $entrada["id"] . ' <br> ';
						//echo $en;
					}
				}
			
			}
			
			imgEntradasTextos2($entradas2_arr);
		}else{
			ruta3();
		}
		
	}
	
	
	
	function imgEntradasTextos2($entradas2_arr){
		
		//echo '<br>';
		
		global $connection;
		global $general_arr;
		$tabla = 'img_entradas_textos';
	
		$entradas_textos2_arr = array();
		
		
		if(count($entradas2_arr) > 0){
			
			for($h = 0; $h <count($entradas2_arr); $h++ ){
				
				$q_entrada_img_textos = "SELECT id, img_id, img_entrada_id FROM img_entradas_textos WHERE img_entrada_id = " . $entradas2_arr[$h];
				$r_entrada_img_textos = mysql_query($q_entrada_img_textos, $connection);
				
				if(mysql_num_rows($r_entrada_img_textos) > 0){
					
					while($entrada_texto = mysql_fetch_array($r_entrada_img_textos)){
						
						array_push($entradas_textos2_arr, $entrada_texto["id"]);
						array_push($general_arr, array($tabla, $entrada_texto["id"]));
						
						$en_img = 'entradas imagenes textos 2 = ';
						$en_img .= $entrada_texto["img_entrada_id"] . ' - ';
						$en_img .= $entrada_texto["id"] . ' <br> ';
						//echo $en_img;
					}

				}

			}
			
			finalRuta2($entradas_textos2_arr);
		}else{
			ruta2();
		}
		
	}
	
	
	function finalRuta2 ($entradas_textos2_arr){
		//echo '<br>';
		//echo "---------------------<br>";
		if(count($entradas_textos2_arr) > 0){
			ruta3();
			////echo "saliendo de la 1 <br>";
		}else{
			ruta3();
			////echo 'no hay en img entradas textos <br>';
		}
	}
	
	
	
	function ruta3(){
		
		// ***SELECCIONAR LOS TEXTOS DE LOS CONTENIDOS
		//echo 'RUTA 3 => CONTENIDOS => TEXTOS <BR><BR> ';
		
		global $contenidos_id;
		global $connection;
		global $id;
		global $general_arr;
		$tabla = "textos_contenidos";
		$textos3_arr = array();
		
		// CONTENIDOS -> IMAGENES 
		if(count($contenidos_id) > 0){
			
			for($j = 0; $j <count($contenidos_id); $j++ ){
			
				$q_textos = "SELECT id, contenido_id, texto_id, idioma, titulo, contenido FROM textos_contenidos WHERE contenido_id = " . $id;
				$r_textos = mysql_query($q_textos, $connection);
				
				if(mysql_num_rows($r_textos) > 0){
					
					while($texto = mysql_fetch_array($r_textos)){
						
						array_push($textos3_arr, $texto["id"]);
						array_push($general_arr, array($tabla, $texto["id"]));
                    
						$tx  = 'tex 3 = ';
						$tx .= $texto["contenido_id"] .' - ';
						$tx .= $texto["id"] . ' - ';
						$tx .= $texto['texto_id'] . ' / ';
						$tx .= $texto['titulo'] . ' / ';
						if($texto["idioma"] == 0){
							$tx .= substr($texto['contenido'], 0, 100) . '.....<br> ';
						}else{
							$tx .= '<br> ';
						}

						////echo $tx;
						
					}
				}else{
					////echo 'no hay textos asociados a este SUB CONTENIDO <br>';
				}
			}
			
			finalRuta3();
		}else{
			finalRuta3();
		}
	}
	
	
	function finalRuta3 (){
		
		//*************  ELIMINAR IMAGENES
		
		global $general_arr, $general_img_arr, $connection, $seccion;

		$gn_imagenes = array_unique($general_img_arr);
		sort($gn_imagenes);
		
		$img_segura1 = 'photo.png';
		$img_segura2 = 'iconos/photo.png';
		
		$cadena = '^imagenes/pequenas/$';
		
		for($k = 0; $k < count($gn_imagenes); $k++ ){
			
			$gn_imagenes[$k] = str_replace('imagenes/pequenas/', '', $gn_imagenes[$k]);
			
			//echo ' ../imagenes/pequenas/ ' . $gn_imagenes[$k] . '<br>';
			//echo ' ../imagenes/medianas/ ' . $gn_imagenes[$k] . '<br>';
			//echo ' ../imagenes/grandes/ '  . $gn_imagenes[$k] . '<br>';
			
			if(trim($gn_imagenes[$k]) == $img_segura1){
				
				//echo 'NO SE PUEDE BORRAR CASO 1= ' . $gn_imagenes[$k] . '<br>';
				//echo 'la imagen = ' . $gn_imagenes[$k] . '<br>';

			}else if(trim($gn_imagenes[$k]) == $img_segura2){
				
				//echo 'NO SE PUEDE BORRAR, CASO 2= ' . $gn_imagenes[$k] . '<br>';
				//echo 'la imagen = ' . $gn_imagenes[$k] . '<br>';
				
			}else{
				//echo '<br> PROCEDER AL BORRADO => ' . $gn_imagenes[$k];
				//ELIMINAR IMAGENES
				unlink('../imagenes/pequenas/' . $gn_imagenes[$k]);
				unlink('../imagenes/medianas/' . $gn_imagenes[$k]);
				unlink('../imagenes/grandes/'  . $gn_imagenes[$k]);
			}

		}
		


		// ********  ELIMINAR CONTENIDOS
		
		for($i = 0; $i <count($general_arr); $i++ ){
			
			// ECHOS DE PRUEBA
			//echo $general_arr[$i][0] . ' - ' . $general_arr[$i][1]  . '<br>';
			
			$b_grupo_contenido = "DELETE FROM " . $general_arr[$i][0] . " WHERE id = " . $general_arr[$i][1];
			$r_grupo_contenido = mysql_query($b_grupo_contenido, $connection);
			
			if($r_grupo_contenido){
				// REGRESAR A LA SECCION
				if($i == count($general_arr)-1 ){
					header('Location: ../editar-seccion.php?seccion=' . $seccion);
					//echo $seccion;
				}
			}else{
				echo mysql_error();
			}
			
			
		}
	}

	
	
	
	
?>