<?php // ======================================== ACTUALIZACION DE LOS CONTENIDOS ========================================
	
	require_once("../includes/connection.php");
	
	
	if(isset($_POST['boton1'])){
	
		if(isset($_GET['sub-contenido'])){
			$sub_contenido  =  $_POST['sub-contenido'];
		}

		$texto_id = $_POST['texto_id'];
		$id    =  $_POST['id'];
		$tabla =  $_POST['tabla'];
		
		
		//  SOLO SE MUESTRA EL TITULO PARA LOS TEXTOS DE MENCIONES, 
		//  PUBLICACIONES, EXPOSICIONES Y CONVOCATORIAS
		
		if(isset($_POST['titulo'])){
			$titulo    = $_POST['titulo'];
		}else{
			$titulo = "";
		}
		
		$contenido = $_POST['areadetexto'];
		// ALICAR ESTA FUNCION PARA PERMITIR LOS " ' " (APOSTROFES)
		$contenido = mysql_real_escape_string($contenido);
		
		$idioma = $_POST['idioma'];
		$contenido_id = $_POST['contenido_id'];
		
	
		// SOLO SE MUESTRA LA FECHA PARA LOS TEXTOS DE MENCIONES, PUBLICACIONES, EXPOSICIONES Y CONVOCATORIAS
		if(isset($_POST['fecha'])){
			$fecha = $_POST['fecha'];
		}else{
			$fecha = 0;
		}
		
		//echo $idioma . '<br>';
		//echo $id . '<br>';
		//echo $fecha . '<br>';
		//echo $contenido;
		//echo $contenido_id;
		//echo $texto_id;
		
		$qa_textos  = " UPDATE textos_contenidos ";
		$qa_textos .= " SET titulo ='$titulo', fecha = '$fecha', contenido = '$contenido' ";
		$qa_textos .= " WHERE id = " . $id;
		$qa_textos .= " AND idioma = " . $idioma;
		$ra_textos = mysql_query($qa_textos, $connection);
		
		
		if(isset($sub_contenido)){
			if($idioma == 0){
				$url = 'Location: ../editar-textos.php?sub-contenido='.$sub_contenido.'&texto_id='.$id.'&idm='.$idioma.'&contenido='.$contenido_id;
			}else{
				$url = 'Location: ../editar-textos.php?sub-contenido='.$sub_contenido.'&texto_id='.$texto_id.'&idm='.$idioma.'&contenido='.$contenido_id;
			}
		}else{
			if($idioma == 0){
				$url = 'Location: ../editar-textos.php?texto_id='.$id.'&idm='.$idioma.'&contenido='.$contenido_id;
			}else{
				$url = 'Location: ../editar-textos.php?texto_id='.$texto_id.'&idm='.$idioma.'&contenido='.$contenido_id;
			}
		}
		
		
		if(mysql_affected_rows() == 1){
			header($url.'&act=1');
			//echo 'si ->' . $url;
		}else{
			//header('Location: ../editar-textos.php?texto_id='.$texto_id.'&idm='.$idioma.'&contenido='.$contenido_id);
			header($url);
			//echo mysql_error();
			//echo 'no ->' . $url;
			//if(isset($sub_contenido)){
			//	header('Location: ../editar-textos.php?sub-contenido='.$sub_contenido.'&texto_id='.$id.'&idm='.$idioma.'&contenido='.$contenido_id);
			//}else{
			//	header('Location: ../editar-textos.php?texto_id='.$id.'&idm='.$idioma.'&contenido='.$contenido_id);
			//}
			//echo '<div id="mensaje_negativo">La Sección no fue actualizada. No hiciste ningún cambio. </div>';
			//echo "Nada". mysql_error();
		}
		

	}
?>

