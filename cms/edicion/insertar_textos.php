<?php	

//========== INSERCION NUEVO CONTENIDO =========================================//
	
	if(isset($_POST['btn_texto'])){
	
		$titulo = $_POST['titulo'];

		$seccion_id = $_POST['seccion_id'];
		$contenido_id = $_POST['contenido_id'];
		
		$errores = array();
		$required_fields = array('titulo');
		
		
		foreach($required_fields as $fieldname){
			if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname])  && !is_numeric($_POST[$fieldname]))){
				$errores[] = $fieldname;	
			}
		}
		

		
		if(empty($errores)){
			
			$imagen1 = 'imagenes/pequenas/photo.png';
			$imagen2 = 'imagenes/medianas/photo.png';
			$imagen3 = 'imagenes/grandes/photo.png';
			
			$query  = " INSERT INTO textos_contenidos ";
			$query .= " (seccion_id, contenido_id, titulo, borrable, imagen1, imagen2, imagen3) ";
			$query .= " VALUES ";
			$query .= " ($seccion_id, $contenido_id, '$titulo', 1, '$imagen1', '$imagen2', '$imagen3') ";
			
			$result = mysql_query($query, $connection);
			$ultimo_id = mysql_insert_id();
			//echo $ultimo_id;
			
			$titulos = [
				'', 
				'Cambia '.$titulo.' al inglés', 
				'Cambia '.$titulo. ' al francés'
			];
			
			
			if(mysql_affected_rows() >= 1){
			
				
				for($c=1; $c<3; $c++){
					
					$q_insertar2  = " INSERT INTO ";
					$q_insertar2 .= " textos_contenidos ";
					$q_insertar2 .= " (seccion_id, contenido_id, texto_id, idioma,  titulo) ";
					$q_insertar2 .= " VALUES ";
					$q_insertar2 .= " ($seccion_id, $contenido_id, $ultimo_id, $c, '$titulos[$c]')";
					
					$r_insertar2 = mysql_query($q_insertar2, $connection);
					
					if(mysql_affected_rows() >= 1){
						$mensaje = '<div id="mensaje_positivo">El texto fue insertado correctamente!</div>';
					}else{
						$mensaje = '<div id="mensaje_negativo">El texto no fue insertado!</div>';
						//mysql_error();
					}
					
				}

			}else{
				
			}
		
		}else{
			$mensaje = "Debes ingresar un titulo!!";
		}
	
	}
	
	?>