<?php
	
	require_once("../includes/connection.php");

	if(isset($_POST['eliminar'])){
		
		$id = $_POST['id'];
		$contenido_id = $_POST['contenido_id'];
		$seccion = $_POST['seccion'];
		
		
		
		if(isset($_POST['imagen'])){
			
			$imagen = $_POST['imagen'];
			
			if(!empty($imagen)){
			
				if($imagen == 'imagenes/pequenas/photo.png'){
				// no se hace nada
				}else{
					
					$img = explode('/',$imagen);
					$img = end($img);
					
					$nombreA = "../imagenes/pequenas/" . $img;
					$nombreB = "../imagenes/medianas/" . $img;
					$nombreC = "../imagenes/grandes/"  . $img;
					
					if(unlink($nombreA)){
						unlink($nombreB);
						unlink($nombreC);
					}else{
						echo mysql_error();
					}
					
				}
				
			}else{
				//echo "No hay imagen para borrar";	
			}
			
			
			// REVISAR SI EXISTE LA IMAGEN EN LA TABLA DE IMAGENES ALBUMS - SI EXISTE, TIENE PIE DE FOTO
			$q_imgpie = "SELECT * FROM imagenes_albums WHERE texto_id = " . $id;
			$r_imgpie = mysql_query($q_imgpie, $connection);
			
			if(mysql_num_rows($r_imgpie) > 0 ){
				
			
				while($fila = mysql_fetch_array($r_imgpie)){
					$idimgpie = $fila['id'];
					//echo $idimgpie;
				}
				
				//$b_fotopie = "DELETE FROM imagenes_albums WHERE texto_id = " . $id;
				//$r_fotopie = mysql_query($b_fotopie, $connection);
				//
				if ( mysql_affected_rows() >= 1){
					
					$b_entradaspie = "DELETE FROM img_entradas WHERE img_id = " . $idimgpie;
					$r_entradaspie = mysql_query($b_entradaspie, $connection);
					
					$b_textospie = "DELETE FROM img_entradas_textos WHERE img_id = " . $idimgpie;
					$r_textospie = mysql_query($b_textospie, $connection);
				}
			}
		}
		

		
		$q_borrado1 = "DELETE FROM textos_contenidos WHERE id = {$id}";
		$r_borrado1 = mysql_query($q_borrado1, $connection);
		
		if ( mysql_affected_rows() >= 1){
			
			$q_borrado2 = "DELETE FROM textos_contenidos WHERE texto_id = {$id}";
			$r_borrado2 = mysql_query($q_borrado2, $connection);
			
			header("Location: ../editar-subcontenido.php?contenido_id=" . $contenido_id);
			
		}

	}
	
	
?>