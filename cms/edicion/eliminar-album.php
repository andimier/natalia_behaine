<?php		
		require_once("../includes/sesion.php");
		require_once("../includes/connection.php");
		require_once("../includes/functions.php");
	
		if( isset($_POST['eliminaralbum'])){

		
			$imagenes = "SELECT * FROM imagenes_albums WHERE album_id = " . $_POST['id'];
			$album = mysql_query($imagenes, $connection);

			
			$num_imagenes = mysql_num_rows($album);
			
			
			if( $num_imagenes >=1 ){
	
				while($imagen = mysql_fetch_array($album)) {
					
					unlink( '../' . $imagen['imagen1'] );
					unlink( '../' . $imagen['imagen2'] );
					unlink( '../' . $imagen['imagen3'] );

				}

				for($i=0; $i<$num_imagenes; $i++){
					
					$borrar_imagenes = "DELETE FROM imagenes_albums WHERE album_id = " . $_POST['id'] . " LIMIT 1";
					$resultado_borrar_imagenes = mysql_query($borrar_imagenes, $connection);
				
				}
	
			}else{
				//echo 'No hay imagenes en este album';
			}
		
			$exp = explode('/',$_POST['imagenprincipal']);
			$nombreimagen = $exp[2];
			
			
			unlink( '../imagenes/pequenas/' . $nombreimagen );
			unlink( '../imagenes/meidanas/' . $nombreimagen );
			unlink( '../imagenes/grandes/' . $nombreimagen );
			
			$q_balbum = "DELETE FROM albumes WHERE id = " . $_POST['id'] . " LIMIT 1";
			$r_balbum = mysql_query($q_balbum, $connection);
			
			if(mysql_affected_rows() >=1){
				header("Location: ../albumes.php");
			}else{
				mysql_error();
			}
		}
		
?>