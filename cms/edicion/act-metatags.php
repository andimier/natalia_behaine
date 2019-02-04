<?php 
	
	if(isset($_POST['guardar'])){
	
		$id = mysql_prep($_POST['id']);

		
		$palabras1     = mysql_prep($_POST['palabras1']);
		$descripcion1  = trim(mysql_prep($_POST['descripcion1']));
		
		$palabras2     = mysql_prep($_POST['palabras2']);
		$descripcion2  = trim(mysql_prep($_POST['descripcion2']));
		
		$palabras3     = mysql_prep($_POST['palabras3']);
		$descripcion3  = trim(mysql_prep($_POST['descripcion3']));
		
		
		
		$query = "UPDATE metatags SET  
				palabras1 = '{$palabras1}', descripcion1 = '{$descripcion1}' ,
				palabras2 = '{$palabras2}', descripcion2 = '{$descripcion2}',
				palabras3 = '{$palabras3}', descripcion3 = '{$descripcion3}'				
				
				WHERE id = {$id}";
	
		
		$result = mysql_query($query, $connection);
		
		if(mysql_affected_rows() == 1){
			$mensaje = '<div id="mensaje_positivo"> El campo fue actualizado correctamente! </div>';
		}else{
			$mensaje = '<div id="mensaje_negativo">El campo no fue actualizado. No hiciste ningún cambio. </div>'.
			mysql_error();
		}

		
		
	}
?>

