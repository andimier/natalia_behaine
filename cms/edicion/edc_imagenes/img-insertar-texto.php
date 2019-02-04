<?php

	function insertarTextoImagen($imagen_id, $idioma, $connection){
	
		$numero = 1;
		
		global $r_imagen;
		
		//echo $imagen_id . '<br>';
		//echo $idioma. '<br>';
		
		
		$tituloboton = "Eliminar";
		$archivo_eliminar = 'edicion/eliminar-contenidos.php';
		
		$q_imagen  = ' SELECT ';
		
		$q_imagen .= ' imagenes_albums.album_id, imagenes_albums.imagen1, imagenes_albums.contenido_id, ';
		
		$q_imagen .= ' img_entradas_textos.img_id, ';
		$q_imagen .= ' img_entradas_textos.texto, ';
		$q_imagen .= ' img_entradas.tipo_contenido, ';
		$q_imagen .= ' img_entradas.fecha_creacion ';

		$q_imagen .= ' FROM imagenes_albums ';
		
		$q_imagen .= ' INNER JOIN img_entradas ';
		$q_imagen .= ' ON imagenes_albums.id  = img_entradas.img_id ';
		
		$q_imagen .= ' INNER JOIN img_entradas_textos ';
		$q_imagen .= ' ON img_entradas_textos.img_entrada_id  =  img_entradas.id';

		$q_imagen .= ' WHERE imagenes_albums.id =' . $imagen_id;
		$q_imagen .= ' AND img_entradas_textos.idioma =' . $idioma;
		$r_imagen = mysql_query($q_imagen, $connection);
		
		
		if(mysql_num_rows($r_imagen) < 1 ){
			//echo 'no existe';
			
			date_default_timezone_set('America/Bogota');
			$fecha = date("Y-m-j");
			
			$img_id = $imagen_id;
			$contenido_id = 1;
			$tipo_contenido = 'Descripción';
			
			$q_insertar_entrada  = " INSERT INTO img_entradas ";
			$q_insertar_entrada .= " ( img_id, img_contenido_id,  fecha_creacion, tipo_contenido, visible ) ";
			$q_insertar_entrada .= " VALUES ";
			$q_insertar_entrada .= " ( $img_id, $contenido_id, '$fecha', '$tipo_contenido', 1 )";
			
			$r_insertar_entrada = mysql_query($q_insertar_entrada, $connection);
			$ultimo_id = mysql_insert_id();
			
			if(mysql_affected_rows() == 1){
				
				//echo 'filas insertadas en entradas = ' . mysql_affected_rows() . '<br>';
				// SE CREA EL TEXTO 1
				
				$texto = '';
				
				$q_insertar_texto1  = " INSERT INTO img_entradas_textos ";
				$q_insertar_texto1 .= " ( img_id, img_contenido_id,  img_entrada_id, texto_id, fecha_creacion, tipo_contenido, idioma, texto ) ";
				$q_insertar_texto1 .= " VALUES";
				$q_insertar_texto1 .= " ( $img_id, $contenido_id, $ultimo_id, 0, '$fecha', '$tipo_contenido', 0, '$texto' )";
				
				$r_insertar_texto1 = mysql_query($q_insertar_texto1, $connection);
				$ultimo_id_entrada = mysql_insert_id();
				
				
				if(mysql_affected_rows() == 1){
					//echo 'si';
				
					for($i=1; $i<3; $i++){
					// CREACIÓN TEXTOS IDIOMAS ADICIONALES
						$q_insertar_texto2  = " INSERT INTO img_entradas_textos ";
						$q_insertar_texto2 .= " ( img_id, img_contenido_id,  img_entrada_id, texto_id, fecha_creacion, tipo_contenido, idioma, texto ) ";
						$q_insertar_texto2 .= " VALUES";
						$q_insertar_texto2 .= " ( $img_id, $contenido_id, $ultimo_id, $ultimo_id_entrada, '$fecha', '$tipo_contenido', $i, '$texto' )";
						
						$r_insertar_texto2 = mysql_query($q_insertar_texto2, $connection);
					
						if(mysql_affected_rows() == 1){
							// ACÁ NO HACER EL ENVIO A PAGINAS O SE HACE DOS VECES, BRUTO!!!
						}else{
							echo mysql_error();
						}
					}
					header('Location: editar-imagen.php?id=' . $img_id);
					//echo 'editar-imagen.php?id=' . $img_id . ' - numero = ' . $numero . '<br>';
					$numero++;
				
				}else{
					echo mysql_error();
				}
			}
			
		}else{
			
			//echo mysql_error(); 
		}
	}
?>