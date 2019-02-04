<?php
	require_once("../includes/connection.php");

	//============================= INSERCION DE LA IMAGEN ========================================
	
	if(isset($_POST['insertarimagen'])){
		
		$variacion = 0;
		
		$tabla   = $_POST['tabla'];
		$id      = $_POST['campo_id'];
		$campo 	 = $_POST['campo'];
		
		if(!$_POST['modulo']){
			$variacion = 2;
		}else{
			$variacion = 1;
			$modulo = $_POST['modulo'];
		}
		
		if(empty($_POST['redireccion'])){
			echo "No llego nada";	
		}else{
			$redireccion = $_POST['redireccion'];
		}
		
		$archivo = $_FILES['nombre_archivo'];  // ==> ARRAY !!!
		$temp_path = $archivo['tmp_name'];
		$nombre_archivo = basename($archivo['name']);
		
		$randomdigit = rand(0000,9999);
		$nombre_archivo = $randomdigit . $nombre_archivo;
		
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
		
		
		$errores = "";
		
		if(!$archivo || empty($archivo) || !is_array($archivo)){
			
		echo $variacion;
			$mensaje = "No se ha subido ningun archivo! <br />";
			if($variacion == 1){
				header('Location: '. $redireccion . $id ."&modulo=". $modulo);
			}else{
				header('Location: '. $redireccion . $id);
			}
			
		}elseif($archivo['error'] !=0){
			
			$mensaje =  "No se ha seleccionado nada.";
			if($variacion == 1){
				header('Location: '. $redireccion . $id ."&modulo=". $modulo);
			}else{
				header('Location: '. $redireccion . $id);
			}
			
		}else{
			
			$kaboom = explode(".", $nombre_archivo); 
			$ext_archivo = $kaboom[1];
		
			$destino = "../imagenes/grandes/"  . $nombre_archivo;
			
			$ruta1   = "imagenes/pequenas/" . $nombre_archivo;
			$ruta2   = "imagenes/medianas/" . $nombre_archivo;
			$ruta3   = "imagenes/grandes/"  . $nombre_archivo;
			
			if(move_uploaded_file($temp_path, $destino)){
				//echo "SIII";
				$sql  = "INSERT INTO $tabla ($campo, imagen1, imagen2, imagen3) VALUES ($id, '$ruta1', '$ruta2', '$ruta3')";
				
				if($update = mysql_query($sql, $connection)){
					
					if(mysql_affected_rows()==1){
						if($variacion = 1){
							$mensaje = 'Imagen insertada correctamete!<br />';
							header('Location: '. $redireccion . $id ."&modulo=". $modulo);
						}else{
							$mensaje = 'Imagen insertada correctamete!<br />';
							header('Location: '. $redireccion . $id);
						}
						
					}else{
						$mensaje = "Falló!!<br />" . mysql_error();
					}
						
					//======== REDUCCION DE IMAGEN ======================================================
					
					require_once("reduccionimagenes.php");
				
					$archivo_origen   = "../" . $ruta3;
					$destino_medianas = "../" . $ruta2;
					$wmax = 250;
					$hmax = 250;
					reducir_imagen($archivo_origen, $destino_medianas, $wmax, $hmax, $ext_archivo);
					
				}else{
					echo mysql_error();
				}
				
			}else{
				//$mensajeimagen = "NADA" . mysql_error();
			}
		}
	}
	
	
?>

