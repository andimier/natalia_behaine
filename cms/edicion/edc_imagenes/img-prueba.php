<?php

if(isset($_POST['boton'])){
	
	$id    = $_POST['contenido_id'];
	$tabla = $_POST['tabla'];
	
	if(isset($_POST['ruta'])){
		
		$ruta = $_POST['ruta'];
		$arr = explode('/', $ruta);
		$archivoparaborrar = $arr[2];
		$archivomediano = "imagenes/medianas/" . $archivoparaborrar;
		$archivogrande  = "imagenes/grandes/"  . $archivoparaborrar;
		
		if($archivoparaborrar == 'camara_01.png'){
			
		}else{
			if(unlink($ruta)){
				unlink($archivomediano);
				unlink($archivogrande);
				$mensaje = "La imagen ha sido eliminada, selecciona una nueva <br /><br />";
			}else{
				$mensaje = "No se ha eliminado la imagen! <br />" . mysql_error();	
			} 
		}
	}

}else{
	//$mensajeimagen =  "No se ha enviado nada.";
}

	//============================= INSERCION DE LA IMAGEN ========================================
	
	if(isset($_POST['botonsubirimagen']) ){
			
		$tabla   = $_POST['tabla'];
		$id      = $_POST['contenido_id'];
		
		$archivo = $_FILES['nombre_archivo'];  // ==> ARRAY !!!
		$nombre_archivo = basename($archivo['name']);
		$nombre_archivo = preg_replace('#[^a-z.0-9_-]#i',"_",$nombre_archivo);  // FILTRO Y REMPLAZO DENOMBRE DEL ARCHIVO ORIGINAL
		
		$temp_path = $archivo['tmp_name'];
		
		
		$randomnumber = rand(0000,9999);
		$nombre_archivo = $randomnumber . $nombre_archivo;
		//$nombre_archivo = time().rand() . "-" . $nombre_archivo;
		//$nombre_archivo = time().rand().".".$ext_archivo;  ///---CON ESTA FUNCIPON SE RENOMBRA EL ARCHIVO CON UN TIME SRTAMP
				
		$max_file_size = 1048576;
		$message = "";
		$errors = array();	
		
		$upload_errors = array(
			UPLOAD_ERR_OK         => "No Hay Errores",
			UPLOAD_ERR_INI_SIZE   => "Larger than the upload max filesize",
			UPLOAD_ERR_FORM_SIZE  => "Larger than the form max filesize",
			UPLOAD_ERR_PARTIAL    => "Partial Upload",
			UPLOAD_ERR_NO_FILE    => "No file",
			//UPLOAD_ERR_NO_TEMP_DIR=> "No temporary dir",
			UPLOAD_ERR_CANT_WRITE => "Can't write to the disk",
			UPLOAD_ERR_EXTENSION  => "File upload stopped by extension"
		);
		
		
		if(!$archivo || empty($archivo) || !is_array($archivo)){
			//$errors[] = "No se ha subido ningun archivo! <br />";
			$mensaje = "No se ha subido ningun archivo! <br />";
		}elseif($archivo['error'] !=0){
			$mensaje =  "No se ha seleccionado nada.";
		}else{
			
			$kaboom = explode(".", $nombre_archivo); //OBTENER LA EXTENSION DEL ARCHIVO  kaboom es una array
			$ext_archivo = end( $kaboom );
			
			$destino = "imagenes/grandes/"  . $nombre_archivo;
			
			$ruta1   = "imagenes/pequenas/" . $nombre_archivo;
			$ruta2   = "imagenes/medianas/" . $nombre_archivo;
			$ruta3   = "imagenes/grandes/"  . $nombre_archivo;
			
			if( move_uploaded_file( $temp_path, $destino )){
				//echo "SIII";
				$sql  = "UPDATE $tabla SET imagen1 = '{$ruta1}', imagen2 = '{$ruta2}', imagen3 = '{$ruta3}' WHERE id = $id";
				$update = mysql_query($sql, $connection);
				
				if(mysql_affected_rows()==1){
					$mensaje = 'Imagen cambiada correctamete!<br /><br />';
				}else{
					$mensaje = "Falló!!<br />" . mysql_error();
				}
				
				//======== REDUCCION DE IMAGEN ======================================================
				
				require_once("reduccionimagenes.php");
				
				$archivo_origen   = $ruta3;
				$destino_medianas = $ruta2;
				$ruta_pequenas = $ruta1;
				$wmax = 460;
				$hmax = 195;
				reducir_imagen($archivo_origen, $destino_medianas, $wmax, $hmax, $ext_archivo, $ruta_pequenas);
				
			}else{
				$mensajeimagen = "NADA" . mysql_error();
			}
		}
		
	}
	
	
?>

