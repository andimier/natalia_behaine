<?php	
	
	require_once("../includes/sesion.php");
	require_once("../includes/connection.php");
	require_once("../includes/functions.php");
	
	//========== INSERCION NUEVO CONTENIDO =========================================//
	
	if(isset($_POST['insertar_contenido'])){
	
		$titulo = $_POST['titulo'];
		
		date_default_timezone_set('America/Bogota');
		$fecha = date("Y-m-j");
		
		
		// INSERTAR CONTENIDO EN SECCION O
		// SUB CONTEDIDO EN CONTENIDO
		
		if(isset( $_POST['seccion_id'])  &&  !isset($_POST['contenido_id'])){
		
		
			$seccion_id = $_POST['seccion_id'];
			$contenido_id = 0;
			
			// ASIGNAR O NO LA IMAGEN 
			// SEGUN SECCION

			if( $seccion_id == 3 || $seccion_id == 4 || $seccion_id == 8){
				$imagen1 = 'imagenes/pequenas/photo.png';
				$imagen2 = 'imagenes/medianas/photo.png';
				$imagen3 = 'imagenes/grandes/photo.png';
			}else{
				$imagen = '';
			}

		}else if( isset( $_POST['seccion_id']) && isset( $_POST['contenido_id'] ) ){

			$seccion_id = $_POST['seccion_id'];
			$contenido_id = $_POST['contenido_id'];
		}
		

		$errores = array();
		
		$required_fields = array('titulo');
		$imagenprovisional = "imagenes/pequenas/photo.png";
		
		foreach($required_fields as $fieldname){
			if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname])  && !is_numeric($_POST[$fieldname]))){
				$errores[] = $fieldname;	
			}
		}
		
		
		if(empty($errores)){
			
			$indice = 0;
			$borrable = 1; 
			// Si se puede borrar (aparece el botón para eliminar)

			
			// CREACION DEL
			// CONTENIDO PRINCIPAL
			
			$query  = " INSERT INTO contenidos ";
			$query .= " ( fecha, titulo, seccion_id, imagen1, imagen2, imagen3, borrable ) ";
			$query .= "	VALUES 	";
			$query .= "( '$fecha', '$titulo', $seccion_id, '$imagen1', '$imagen2', '$imagen3', $borrable )";
			
			
			$result = mysql_query($query, $connection);
			$ultimo_id = mysql_insert_id();
			
			$extras = array('Exposiciones', 'Convocatorias');
			
			if(mysql_affected_rows() >= 1){
				
				
				// SE CREA EL TEXTO 1
				$q_insertar1  = " INSERT INTO textos_contenidos ";
				$q_insertar1 .= " ( seccion_id, contenido_id,  titulo, idioma ) ";
				$q_insertar1 .= " VALUES";
				$q_insertar1 .= " ( $seccion_id, $ultimo_id, '$titulo', 0 )";
				
				$r_insertar1 = mysql_query($q_insertar1, $connection);
				$u_id = mysql_insert_id();
				
				
				for($b=1; $b<3; $b++){
					// CREACIÓN TEXTO 1 IDIOMAS ADICIONALES
					$q_insertar2  = " INSERT INTO textos_contenidos ";
					$q_insertar2 .= " ( seccion_id, contenido_id,  texto_id, idioma) ";
					$q_insertar2 .= " VALUES";
					$q_insertar2 .= " ( $seccion_id, $ultimo_id, $u_id, $b )";
					
					$r_insertar2 = mysql_query($q_insertar2, $connection);
	
				}
				
				
				if($seccion_id == 3){
					
					// INSERTAR EXTRAS EN PROYECTOS
					for($c=0; $c < count($extras); $c++){
						
						$q_insertar3  = "INSERT INTO contenidos (seccion_id, contenido_id,  titulo) ";
						$q_insertar3 .= "VALUES	( $seccion_id, $ultimo_id, '$extras[$c]' )";
						
						$r_insertar3 = mysql_query($q_insertar3, $connection);
						
						if(mysql_affected_rows() >= 1){
							header("Location: ../editar-seccion.php?seccion=" . $seccion_id . "&act=1");
							// ENVIAR VALRIABLE ACTUALIZACIN PARA MOSTRAR MENSAJE
						}else{
							echo mysql_error();
						}
					}
				}else{
					header("Location: ../editar-seccion.php?seccion=" . $seccion_id . "&act=1");
				}

			}else{
				echo "No se creo nada - Error:" .  mysql_error();
				
			}
		
		}else{
			$mensaje = "Debes ingresar un titulo!!";
		}
	
	}
	
	?>