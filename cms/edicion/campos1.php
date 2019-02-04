<?php	
	$metatags = '';
	$img_pr = '';
	$nuevo_contenido = '';
	$extras = '';

	function metaTags($campos_arr, $seccion_id, $seccion_tt){
		global $metatags;
		$i=0;

		while($i<count($campos_arr)){
			if($seccion_id == $campos_arr[$i]['id'] && $campos_arr[$i]['meta-tags']== true){
				$metatags  = '<div class="titulo-rojo">';
				$metatags .= '<a href="puente_metatags.php?seccion_id=' . $seccion_id . '&sec='. $seccion_tt.'">';
				$metatags .= '> EDITAR META-TAGS';
				$metatags .= '</a>';
				$metatags .= '</div>';
			}
			$i++;
		}
	}

	function imgPrincipal($campos_arr, $seccion_id, $tabla, $imagenprincipal){
		global $img_pr;
		global $imagenprincipal;
		$id = $seccion_id;
		$i=0;
		while($i<count($campos_arr)){
			if($seccion_id == $campos_arr[$i]['id'] && $campos_arr[$i]['img-pr']== true){
				require_once('edicion/edc_imagenes/img_principal.php'); 
			}
			$i++;
		}
	}

	function insertarContenido($campos_arr, $seccion_id){
		global $nuevo_contenido;
		$i=0;
		while($i<count($campos_arr)){
			if($seccion_id == $campos_arr[$i]['id'] && $campos_arr[$i]['nvo-contenido']== true){
				$nuevo_contenido .= '<h4>Insertar nuevo contenido</h4>';
				$nuevo_contenido .= 'Nuevo Titulo:';
				$nuevo_contenido .= '<form enctype="multipart/form-data" method="post" action="edicion/insertar_contenidos.php">';
				$nuevo_contenido .= '<input type="hidden" name="tabla"        value="imagenes_publicaciones" />';
				$nuevo_contenido .= '<input type="hidden" name="seccion_id"   value="'.$seccion_id.'" />';
				$nuevo_contenido .= '<input type="text"   name="titulo"       value="" class="letra_azul borde_puntos" size="50" maxlength="50" />';
				$nuevo_contenido .= '<br />';
				$nuevo_contenido .= '<input type="submit" name="insertar_contenido" id="insertar_contenido" class="fondo_azul" value="insertar contenido"/>';
				$nuevo_contenido .= '</form>';
				$nuevo_contenido .= '<br />';
				$nuevo_contenido .= '<br />';
			}
			$i++;
		}
	}

	function extras($campos_arr, $seccion_id){
		global $extras;
		$i=0;

		while ($i<count($campos_arr)) {
			if ($seccion_id == $campos_arr[$i]['id'] && $campos_arr[$i]['editar-extras']== true){
				$extras .= '<ul>';
				$extras .= '<li><a href="editar-extras-enlace-video.php?seccion='. $seccion_id.'">Editar enlace video</a></li>';
				$extras .= '</ul>';
			}
			$i++;
		}
	}
?>
