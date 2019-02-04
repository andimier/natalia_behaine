<?php
require_once("../includes/connection.php");


	if(isset($_POST['eliminar'])){
		
		$id      = $_POST['id'];
		$tabla   = $_POST['tabla'];
		$seccion = $_POST['seccion'];
		$archivo = $_POST['archivo'];
		
		$imagenprincipal = $_POST['imagenprincipal'];
		
		//echo $id . "<br>";
		//echo $archivo . "<br>";
		
		
		//if( !empty($imagenprincipal )){
		//	
		//	if($imagenprincipal == 'imagenes/pequenas/photo.png'){
		//		// no se hace nada
		//	}else{
		//		$explotarnombre = explode("/", $imagenprincipal);
		//		$nombrearchivo  = $explotarnombre[2];
		//		
		//		$nombreA = "../imagenes/pequenas/" . $nombrearchivo;
		//		$nombreB = "../imagenes/medianas/" . $nombrearchivo;
		//		$nombreC = "../imagenes/grandes/"  . $nombrearchivo;
		//		
		//		unlink($nombreA);
		//		unlink($nombreB);
		//		unlink($nombreC);
		//	}
		//	
		//}else{
		//	//echo "No hay imagen para borrar";	
		//}
		
		
		
		//if( !empty($archivo) ){
		//	$n_archivo = "../" . $archivo;
		//	unlink($n_archivo);
		//}else{
		//	mysql_error();	
		//}
		
		
		
		
		
		////////////////
		
		if($seccion == 3 ){
			
			// BUSCAR SI HAY SUBCONTENIDOS EN LA SECCION 3ENCONTRAR
			// ENCONTRAR EN ID DEL SUBCONTENIDO 
			
			$q1 = "SELECT * FROM contenidos WHERE contenido_id = " . $id;
			$r1 = mysql_query($q1, $connection);
			
			while($ides = mysql_fetch_array($r1)){
				$cont[] = $ides['id'];
			}
			
			echo 'count length = ' . count($cont);
			
			for($i=0; $i<3; $i++){
				
				$q2 = "SELECT * FROM textos_contenidos WHERE contenido_id = " . $cont[$i];
				$r2 = mysql_query($q2, $connection);
				
				if(mysql_num_rows($r2) >=1){
					
					while($ico = mysql_fetch_array($r2)){
						$textos_ids[] = $ico['id'];
					}
				
				}else{
					//echo 'nada';
				}

			}
			
			
			
			//if(isset($textos_ids)){
			//
			//	for($e=0; $e<count($textos_ids); $e++){
			//		$q_borrado4 = "DELETE FROM textos_contenidos WHERE id = " . $textos_ids[$e];
			//		$r_borrado4 = mysql_query($q_borrado4, $connection);
		    //
			//	}
			//}
		}
		
		
		
		
		
		
		
		////////////////////
		
		$borrado1 = "DELETE FROM contenidos WHERE id = {$id} LIMIT 1";
		$result = mysql_query($borrado1, $connection);

		
		if ( mysql_affected_rows() >= 1){
			
			if($seccion == 3 ){
				
				$q_borrado2 = "DELETE FROM contenidos WHERE contenido_id = " . $id;
				$r_borrado2  = mysql_query($q_borrado2, $connection);
			}
			
			
			if ( mysql_affected_rows() >= 1){
				$q_borrado3 = "DELETE FROM textos_contenidos WHERE contenido_id = " . $id;
				$r_borrado3  = mysql_query($q_borrado3, $connection);
				header("Location: ../editar-seccion.php?seccion=" . $seccion);
			}
		}
		
		
		
	}else{
		
	}
	
?>

