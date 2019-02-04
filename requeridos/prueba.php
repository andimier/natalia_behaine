<?php
function piedefoto (){
			
			global $piedefoto;
			
			if(isset($_GET['popo'])){
				echo 'popo = '.$_GET['popo'];
			}else{
				echo 'nada';
			}
			
			
			//$q_piedefoto  = " SELECT ";
			//$q_piedefoto .= " imagenes_albums.id";
			//$q_piedefoto .= " img_entradas_textos.texto";
			//$q_piedefoto .= " FROM imagenes_albums ";
			//$q_piedefoto .= " INNER JOIN img_entradas_textos";
			//$q_piedefoto .= " ON imagenes_albums.id = img_entradas_textos.img_id";
			//$q_piedefoto .= " WHERE imagenes_albums.contenido_id = ".$contenido_id;
			//$q_piedefoto .= " AND img_entradas_textos.idioma = " . $idioma;
			//
			//$r_piedefoto = mysql_query($q_piedefoto, $connection);
			//
			//$f_piedefoto = mysql_fetch_array($r_piedefoto);
			//$piedefoto  = $f_piedefoto['texto'];
		}
		
		
		//$idioma = 'popo';
		piedefoto();
		
		?>