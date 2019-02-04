<?php

	
	if(isset($_POST['bsubirarchivo']) ){
		
		$tabla   = $_POST['tabla'];
		$id      = $_POST['contenido_id'];
		
		$archivo        = $_FILES['nombre_archivo'];  // ==> ARRAY !!!
		$temp_path      = $archivo['tmp_name'];
		$nombre_archivo = basename($archivo['name']);
		$peso           = filesize($archivo['tmp_name']);
		
		$nombre = explode(".", $nombre_archivo); 
		$extension = end($nombre);
		$ext_valida = "mp3";
		
		
		
		if($_FILES['nombre_archivo']['error'] == 1){
			
			$mensaje = '<div id="mensaje_negativo">el archivo que seleccionaste es demasiado grande</div>';
			
		}else if($_FILES['nombre_archivo']['error'] == 4){
			
			$mensaje = '<div id="mensaje_negativo">no has seleccionado un archivo</div>';
			
		}else if(file_exists('imagenes/pequenas/' . $nombre_archivo)){
			
			$mensaje = '<div id="mensaje_negativo">el archivo ya existe, seleciona otro diferente o cambia el nombre</div>';
			
		}else if($extension != $ext_valida){
			
			$mensaje = '<div id="mensaje_negativo">el tipo de archivos no es valido</div>';
		
		}else{
			
			
			if($_POST['ruta'] == ''){
				
			}else{
				unlink($_POST['ruta']);
			}
			
			
			$destino = "archivos/" . $nombre_archivo;
			
			
			if(move_uploaded_file($temp_path, $destino)){
				//echo "SIII";
				$sql  = "UPDATE $tabla SET archivo1 = '{$destino}' WHERE id = $id";
				$update = mysql_query($sql, $connection);
				

				if(mysql_affected_rows()==1){
					$mensaje = 'Archivo cambiada correctamete!<br /><br />';
				
				}else{
					$mensaje = "Falló!!<br />" . mysql_error();
				}
				
				
			}else{
				$mensaje = "NADA" . mysql_error();
			}

		}
		
	}
	
	
	
	if(isset($_POST['borrararchivo'])){
		
		if($_POST['ruta'] == ''){
			$mensaje = '<div id="mensaje_negativo">No has borrado nada</div>';
		}else{
			unlink($_POST['ruta']);
			$sql  = "UPDATE contenidos SET archivo1 = '' WHERE id = " . $_POST['contenido_id'];
			$update = mysql_query($sql, $connection);
			$mensaje = '<div id="mensaje_positivo">El audio ha sido borrado correctamnte</div>';
		}
	}
	
?>

