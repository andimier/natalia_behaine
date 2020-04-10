<?php
	$arr_imagenes1 = array();
	$arr_imagenes2 = array();
	$fotos_arr = array();

	function phpMethods($method, $param) {
		global $connection;

		if (phpversion() < 6) {
			switch ($method) {
				case 'query':
					return mysql_query($param, $connection);
					break;
				case 'error':
					return mysql_error();
					break;
				case 'fetch':
					return mysql_fetch_array($param);
					break;
				case 'num-rows':
					return mysql_num_rows($param);
					break;
			}
		} 
		else {
			switch ($method) {
				case 'query':
					return mysqli_query($connection, $param);
					break;
				case 'error':
					return mysqli_error($connection);
					break;
				case 'fetch':
					return mysqli_fetch_array($param);
					break;
				case 'num-rows':
					return mysqli_num_rows($param);
					break;
			}
		}
	}

	function piedefotoComercial($id, $idioma, $cnt){
		// $cnt = 1 = foto principal
		// $cnt = 2 = fotos genrales
		
		global $connection;
		$alt = '';

		$q  = " SELECT ";
		$q .= " imagenes_albums.id, imagenes_albums.contenido_id, ";
		$q .= " img_entradas_textos.texto ";
		$q .= " FROM imagenes_albums, img_entradas_textos ";

		if ($cnt == 1) {
			$q .= " WHERE imagenes_albums.contenido_id = " . $id ;
		} else {
			$q .= " WHERE imagenes_albums.id = " . $id ;
		}

		$q .= " AND img_entradas_textos.img_id = imagenes_albums.id ";
		$q .= " AND img_entradas_textos.idioma = " . $idioma;

		// $r  = mysql_query($q, $connection);
		$r = phpMethods('query', $q);

		if (phpMethods('query', $q)) {
			while($z = phpMethods('fetch', $r)){
				$alt = $z['texto'];
			}
		}else{
			echo phpMethods('error', NULL);
		}

		return $alt;
	}
	
	function imagenPrincipal($contenido_id, $idioma){
		// TRAER IMAGEN PRINCIPAL Y PIEDEFOTO CON LA OTRA FUNCION
		global $connection;

		$q = 'SELECT * FROM contenidos WHERE id = ' . $contenido_id . ' LIMIT 1';
		$r = phpMethods('query', $q);

		while ($z = phpMethods('fetch', $r)) {
			$imagen  = '<a href="http://www.nataliabehaine.com/cms/'. $z['imagen3'] . '" data-fancybox-group="gallery" title="' . piedefotoComercial($z['id'], $idioma, $cnt=1) . '">';
			$imagen .= '<img src="http://www.nataliabehaine.com/cms/' . $z['imagen3'] . '" />';
			$imagen .= '</a>';

			echo $imagen;
		}
	}

	function qFotosAlbum($contenido_id, $idioma){
		global $connection;
		global $fotos_arr;

		$fotos = '';
		$q_comercial_album = 'SELECT * FROM albumes WHERE contenido_id = ' . $contenido_id . ' LIMIT 1';
		// $r_comercial_album = mysql_query($q_comercial_album, $connection);
		$r_comercial_album = phpMethods('query', $q_comercial_album);

		if ($r_comercial_album) {
			// while($album = mysql_fetch_array($r_comercial_album)){
			while ($album = phpMethods('fetch', $r_comercial_album)){ 
				$q_fotos  = " SELECT * ";
				$q_fotos .= " FROM imagenes_albums";
				$q_fotos .= " WHERE imagenes_albums.album_id = " . $album['id'];
				$q_fotos .= " ORDER BY posicion ASC";
				
				// $r_fotos = mysql_query($q_fotos);
				$r_fotos = phpMethods('query', $q_fotos);

				if ($r_fotos) {
					// while ($foto = mysql_fetch_array($r_fotos)) {
					while ($foto = phpMethods('fetch', $r_fotos)) {
						if(phpMethods('num-rows', $r_fotos) > 1){
							echo '<img alt="'. piedefotoComercial($foto['id'], $idioma, $cnt=2) .'" src="http://www.nataliabehaine.com/cms/'.$foto['imagen1'] .'"/>';
						}else{
							echo '<img alt="'. piedefotoComercial($foto['id'], $idioma, $cnt=2) .'" src="http://www.nataliabehaine.com/cms/'.$foto['imagen3'] .'"/>';
						}
					}
				}else{
					//$piedefoto = NULL;
				}
			}
		}else{
			echo mysql_error();
		}
	}

	$q_comercial  = " SELECT ";
	$q_comercial .= " contenidos.id, contenidos.fecha,";
	$q_comercial .= " textos_contenidos.titulo, textos_contenidos.contenido ";
	$q_comercial .= " FROM contenidos, textos_contenidos ";
	$q_comercial .= " WHERE contenidos.seccion_id = 8  ";
	$q_comercial .= " AND textos_contenidos.contenido_id = contenidos.id ";
	$q_comercial .= " AND textos_contenidos.idioma = " . $idioma;
	$q_comercial .= " ORDER BY contenidos.fecha DESC";

	$r_comercial  = phpMethods('query', $q_comercial);
?>