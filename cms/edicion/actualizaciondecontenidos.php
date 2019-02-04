<?php // ======================================== ACTUALIZACION DE LOS CONTENIDOS ========================================
	
	if(isset($_POST['boton1'])){
	
	
		$tabla = $_POST['tabla'];
		//echo $tabla;

		if( $tabla == 'albumes'){
		
	
			$id     = mysql_prep($_POST['id']);
			$fecha  = mysql_prep($_POST['fecha']);
			$titulo = trim(mysql_prep($_POST['titulo']));
			$contenido_id = $_POST['contenido_id'];
			
			
			$q_ttcontenido ="SELECT seccion_id, titulo FROM contenidos WHERE id = {$contenido_id} LIMIT 1";
			$r_ttcontenido = mysql_query($q_ttcontenido, $connection);
			
			
			if( $dato = mysql_fetch_array($r_ttcontenido)){
			
				$titulo_contenido = $dato['titulo'];
				$seccion_id = $dato['seccion_id'];
				
			}else{
				
				$titulo_contenido = '';
				$seccion_id = 0;
			
			}
			
			
			$query = "
			
			UPDATE $tabla 
			SET 
			
			titulo = '$titulo', 
			fecha = '$fecha', 
			seccion_id = $seccion_id, 
			contenido_id = $contenido_id, 
			contenido_titulo = '$titulo_contenido', 
			visible = 0 
			
			WHERE id = $id";
			
			if( mysql_query($query, $connection)){
				//echo 'si';
			}else{
				mysql_error();
			}
			
			
		}else{
		
			$id        = mysql_prep($_POST['id']);
			$fecha     = mysql_prep($_POST['fecha']);
			$titulo    = trim(mysql_prep($_POST['titulo']));
			
		
			
			// SI SE ACTIVA LA OPCIÓN DEL BOTÓN DE COMPRAR OBRA
			// **** SE INCLUYE EN EL QUERY, EL CAMPO COMPRA
			
			if(isset($_POST['compra'])){
				echo $_POST['compra'];
				if( $_POST['compra'] == 'activado'){
					$compra = 1;
				}else{
					$compra = 0;
				}
				
			}else{
				$compra = 0;
			}
			echo 'compra = ' . $compra;
			
			$query  = " UPDATE contenidos ";
			$query .= " SET";
			$query .= " titulo  = '{$titulo}' ,"; 
			$query .= " fecha   = '{$fecha}'  ,";
			$query .= " compra  =  " . $compra ;
			$query .= " WHERE id = " . $id;
			
			
			
			$result = mysql_query($query, $connection);

			if(mysql_affected_rows() == 1){
				//$mensaje = '<div class="mensaje_positivo">{ La Sección fue actualizada correctamente! }</div>';
				header('Location: editar-contenido.php?contenido_id='. $id . '&act=1' );
			}else{
				//$mensaje = '<div class="mensaje_negativo">{ La Sección no fue actualizada. No hiciste ningún cambio. }</div>';
				header('Location: editar-contenido.php?contenido_id='. $id );
				//echo "Nada". mysql_error();
			}
			
		}

	}
?>


