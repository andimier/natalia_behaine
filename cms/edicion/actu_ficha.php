<? // ======================================== ACTUALIZACION DE LOS CONTENIDOS ========================================
	
	if(isset($_POST['areadeficha'])){
		
		$errores = array();
		$required_fields = array('areadeficha');
		
		foreach($required_fields as $fieldname){
			if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname])  && !is_numeric($_POST[$fieldname]))){
				$errores[] = $fieldname;	
			}
		}
		if(empty($errores)){
			
			$tabla = $_POST['tabla'];
			$id    = mysql_prep($_POST['id']);
			$ficha = mysql_prep($_POST['areadeficha']);
			
			$query = "UPDATE $tabla SET ficha_tecnica = '{$ficha}' WHERE id = {$id}";
			$result = mysql_query($query, $connection);
			
			if(mysql_affected_rows() == 1){
				$mensaje = "<h4>La Sección fue actualizada correctamente!</h4>
				---------------------------------------------------------------------------------------<br /><br />";
			}else{
				$mensaje = "<h4>La Sección no fue actualizada. No hiciste ningún cambio.</h4>				---------------------------------------------------------------------------------------<br /><br />";
			}
		}else{
			if(count($errores) == 1){
				 $mensaje = "Dejaste este campo vacío:" . $errores[0];
			}else if(count($errores) == 2){
				//$mensaje = "Dejaste " . count($errores) . " campos vacíos:";
				echo count($errores);
				foreach($errores as $error){
					$mensaje = "- " . $error . "<br />";
				}
				echo "</h4>-----------------------------------------------------------------------------------------------------------------";
			}
		}
	}else{
		
	}
?>

