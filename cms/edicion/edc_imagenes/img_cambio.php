<?php

	function redirect($tabla, $id, $subcontenido, $texto_id, $contenido){
		
		if($tabla=='secciones'){
			$redirect = 'Location: editar-seccion.php?seccion=' . $id;
		}elseif($tabla=='contenidos'){
			$redirect = 'Location: editar-contenido.php?contenido_id=' . $id;
		}else{
			$redirect = 'Location: editar-textos.php?sub-contenido='.$subcontenido.'&texto_id=' . $texto_id . '&contenido=' . $contenido;
		}
		return $redirect;
	}
	
	
	//============================= INSERCION DE LA IMAGEN ========================================
	
	if(isset($_POST['botonsubirimagen']) ){
		
		$tabla = $_POST['tabla'];
		$id    = $_POST['contenido_id'];
		$ruta  = $_POST['ruta'];
		
		
		// SI LA IMAGEN VIENE DE UN SUBCONTENIDO
		if(isset($_POST['texto_id'])){
			$contenido = $_POST['contenido'];
			$texto_id = $_POST['texto_id'];
			//echo 'siii';
		}
		
		if(isset($_POST['sub-contenido'])){
			$subcontenido = $_POST['sub-contenido'];
		}
		
		$archivo        = $_FILES['nombre_archivo'];  // ==> ARRAY !!!
		$temp_path      = $archivo['tmp_name'];
		$nombre_archivo = basename($archivo['name']);
		$nombre_archivo = preg_replace('#[^a-z.0-9_-]#i',"-",$nombre_archivo);  // FILTRO Y REMPLAZO DENOMBRE DEL ARCHIVO ORIGINAL
		
		$extensiones = array('jpg','png');
		$ex_ext = explode('.', $nombre_archivo);
		$extension = end($ex_ext);
		
		
		
		if($_FILES['nombre_archivo']['error'] == 1){
			
			$mensaje = '<div id="mensaje_negativo">el archivo que seleccionaste es demasiado grande</div>';
			
		}else if($_FILES['nombre_archivo']['error'] == 4){
			
			$mensaje = '<div id="mensaje_negativo">no has seleccionado una imagen</div>';
			
		}else if(file_exists('imagenes/pequenas/' . $nombre_archivo)){
			
			$mensaje = '<div id="mensaje_negativo">el archivo ya existe, seleciona otro diferente o cambia el nombre</div>';
			
		}else if($extension != $extensiones[0] && $extension != $extensiones[1]){
			
			$mensaje = '<div id="mensaje_negativo">el tipo de archivos no es valido</div>';
		
		}else{
			
			
			$destino = "imagenes/grandes/"  . $nombre_archivo;
			
			$ruta1   = "imagenes/pequenas/" . $nombre_archivo;
			$ruta2   = "imagenes/medianas/" . $nombre_archivo;
			$ruta3   = "imagenes/grandes/"  . $nombre_archivo;

			///////////
			
			$ruta = $_POST['ruta'];
			
			$arr = explode('/', $ruta);

			if(count($arr) == 3){
				$archivoparaborrar = $arr[2];
			}else{
				$archivoparaborrar = 'iconos/photo.png';
			}
			
			$archivomediano = "imagenes/medianas/" . $archivoparaborrar;
			$archivogrande  = "imagenes/grandes/"  . $archivoparaborrar;
			
			echo $archivoparaborrar;
			if($archivoparaborrar == 'photo.png' || $archivoparaborrar == 'iconos/photo.png'){
				
			}else{
				
				if(unlink("imagenes/pequenas/" . $archivoparaborrar)){
					unlink($archivomediano);
					unlink($archivogrande);
					$mensaje = '<div id="mensaje_positivo">La imagen ha sido eliminada, selecciona una nueva</div>';
				}else{
					$mensaje = '<div id="mensaje_negativo">No se ha eliminado la imagen! </div>';	
				} 
			}
		
			////////////
			
			if(move_uploaded_file($temp_path, $destino)){
				
				if($tabla == 'textos_contenidos'){
					$q_txt  = "UPDATE textos_contenidos SET imagen1 = '{$ruta1}', imagen2 = '{$ruta2}', imagen3 = '{$ruta3}' WHERE texto_id = $id";
					$u_txt = mysql_query($q_txt, $connection);
				}

				// BUSCAR LA IMAGEN EN ALBUMES CONTENIDOS (SI ESTÁ, TIENE PIE DE FOTO Y SE DEBE ACTUALIZAR)
				if(isset($texto_id)){
					$q_imgpie = "SELECT * FROM imagenes_albums WHERE texto_id = " . $texto_id; 
					$r_imgpie = mysql_query($q_imgpie, $connection);
					
					if(mysql_num_rows($r_imgpie) > 0){
						//echo 'sub contenido';
						$u_imgpie = "UPDATE imagenes_albums SET imagen1 = '{$ruta1}', imagen2 = '{$ruta2}', imagen3 = '{$ruta3}' WHERE texto_id = $texto_id";
						$u_imgpie = mysql_query($u_imgpie, $connection);
					}
				}else{
					$q_imgpie = "SELECT * FROM imagenes_albums WHERE contenido_id = " . $id; 
					$r_imgpie = mysql_query($q_imgpie, $connection);
					
					if(mysql_num_rows($r_imgpie) > 0){
						//echo 'contenido';
						$u_imgpie = "UPDATE imagenes_albums SET imagen1 = '{$ruta1}', imagen2 = '{$ruta2}', imagen3 = '{$ruta3}' WHERE contenido_id = $id";
						$u_imgpie = mysql_query($u_imgpie, $connection);
					}   
				}
				
				
				
				$sql  = "UPDATE $tabla SET imagen1 = '{$ruta1}', imagen2 = '{$ruta2}', imagen3 = '{$ruta3}' WHERE id = $id";
				$update = mysql_query($sql, $connection);

	
				if(mysql_affected_rows()==1){
					$mensaje = '<div id="mensaje_positivo">Imagen cambiada correctamete</div>';
					header(redirect($tabla, $id, $subcontenido, $texto_id, $contenido));
					
				}else{
					$mensaje = "Falló!!<br />" . mysql_error();
				}
				
				//======== REDUCCION DE IMAGEN ======================================================
				
				require_once("img_reduccion.php");

				reducir_imagen($ruta3, $ruta2, $extension, $ruta1);
				
			}else{
				$mensajeimagen = "NADA" . mysql_error();
			}
			
			////////////
			
		}
		
	}
	
	
?>

