<?php
	/*
	TRAER LAS IMÁGENES Y LOS TEXTOS DE LOS ALT POR SEPARADO
	METERLOS EN UN ARRAY, LUEGO METERLE EL ALT A ESE ARRAY
	PARA QUE EL QUERY FUNCIONE Y TRAIGA TODAS LA IMÁGENES
	AUNQUE NO TENGAN ALT.
	*/

	$i = 0;
	$img_arr = array();
	
	function reemplazarCaracteres($cadena) {
		return str_replace('"','&quot;', $cadena);
	}
	
	function traerImagenesYpiesDePagina($i) {
		global $r_imagenes;
		global $idioma;
		global $connection;
		global $img_arr;

		if (mysql_num_rows($r_imagenes) >= 1) {
			while ($imagen = mysql_fetch_array($r_imagenes)) {
				$img_arr[] = array(
					$i => $imagen['id'],
					"imagen1" => $imagen['imagen1'],
					"imagen3" => $imagen['imagen3'],
					"alt" => ""
				);

				$q_alt  = " SELECT img_id, texto ";
				$q_alt .= " FROM img_entradas_textos ";
				$q_alt .= " WHERE img_id = " . $imagen['id'];
				$q_alt .= " AND idioma = " . $idioma;
				$r_alt = mysql_query($q_alt, $connection);

				while($alt = mysql_fetch_array($r_alt)){
					if ($alt['img_id'] == $imagen['id']) {
						$img_arr[$i]["alt"] = reemplazarCaracteres($alt['texto']);
					} else {
						$img_arr[$i]["alt"] = "";
					}
				}
				$i++;
			}
		}
	}
	
	traerImagenesYpiesDePagina($i);
?>
