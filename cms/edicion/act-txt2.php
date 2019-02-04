<?php // ======================================== ACTUALIZACION DE LOS CONTENIDOS ========================================
	
	if(isset($_POST['boton1'])){
	
	
		$tabla = $_POST['tabla'];

		$id        = mysql_prep($_POST['id']);
		$fecha     = mysql_prep($_POST['fecha']);
		$titulo    = trim(mysql_prep($_POST['titulo']));
		
		// SI EL CONTENIDO 
		// NO TIENE TEXTO
		if( isset($_POST['areadetexto']) ){
			
			$contenido = mysql_prep($_POST['areadetexto']);
		}else{
			$contenido = "";
		}
		
		$query = "
		UPDATE $tabla 
		SET  titulo = '{$titulo}', fecha = '{$fecha}', contenido = '{$contenido}' 
		WHERE id = {$id}
		";
		
		
		
		
		$result = mysql_query($query, $connection);
			
		if(mysql_affected_rows() == 1){
			$mensaje = '<div id="mensaje_positivo">{ La Sección fue actualizada correctamente! }</div>';
			
		}else{
			$mensaje = '<div id="mensaje_negativo">{ La Sección no fue actualizada. No hiciste ningún cambio. }</div>';
			echo "Nada". mysql_error();
		}
		
		
	}
?>

