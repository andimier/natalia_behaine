<?php
	require_once("includes/requeridos.php");

	$mensaje = "";
	$mensaje2 = "";
	$imagen = "";

	if (!isset( $_GET['id'] ) == 0 && !isset( $_GET['contenido_id'] ) == 0 ) {
		header("Location: inicio.php");	
		exit;
	} else {
		// IDIOMAS
		require_once('includes/idiomas-arr.php');

		if (isset($_GET['idioma'])) {
			$idioma = $_GET['idioma'];
		} else {
			$idioma = 0;
		}

		require_once('includes/mensaje-reload.php');

		// ******************
		// EXCEPCION PARA PROYECTO NATAB 
		// CAMBIAR LA TABLA SI VIENE DE CONTENIDO O DE ALBUMES 
		// CONVERTIR TABLA IMAGENES ALBUMS, EN IMAGNES
		// INSERTAR ACA CADA IMAGEN DE CADA CONTENIDO Y ALBUM
		
		
		// FUNCION QUE HACE EL TRABAJO
		require_once('edicion/edc_imagenes/img-insertar-texto.php');

		if (isset($_GET['id'])) {
			$imagen_id = $_GET['id'];
			$columna = 'id';
			insertarTextoImagen($imagen_id, $idioma, $connection);
		} else if (isset($_GET['contenido_id'])) {
			$imagen_id = $_GET['contenido_id'];
			$columna = 'contenido_id';

			// BUSCAR EN IMAGENES ALBUMS POR EL REGISTRO
			$q_imgalbum  = " SELECT id, contenido_id ";
			$q_imgalbum .= " FROM imagenes_albums ";
			$q_imgalbum .= " WHERE contenido_id = " . $_GET['contenido_id'];
			$q_imgalbum .= " AND texto_id = 0 ";
			$r_imgalbum = mysql_query($q_imgalbum, $connection);

			if (mysql_num_rows($r_imgalbum) == 1) {
				// RESGISTRO ENCONTRADO, ENVIAR EL ID DE LA FOTO,  NO DEL CONTENIDO A LA FUNCION
				$f_imgalbum = mysql_fetch_array($r_imgalbum);
				$imagen_id  = $f_imgalbum['id'];

				insertarTextoImagen($imagen_id, $idioma, $connection);
			} else {
				// INSERTAR IMAGEN EN LA TABLA DE LAS IMAGENES
				$src = $_GET['src'];
				$src = explode('/', $src);
				$src = end($src);

				$imagen1 = 'imagenes/pequenas/'.$src;
				$imagen2 = 'imagenes/medianas/'.$src;
				$imagen3 = 'imagenes/grandes/'.$src;

				$q_insertar_imagen  = " INSERT INTO imagenes_albums ";
				$q_insertar_imagen .= " ( contenido_id, imagen1, imagen2, imagen3 ) ";
				$q_insertar_imagen .= " VALUES";
				$q_insertar_imagen .= " ( $imagen_id, '$imagen1', '$imagen2', '$imagen3' )";
				
				$r_insertar_imagen = mysql_query($q_insertar_imagen, $connection);
				
				// AL INSERTAR LA IMAGEN EN LA TABLA, ENVIAR EL ID DE ESTA IMAGEN A LA FUNCION
				$imagen_id = mysql_insert_id(); 
				
				if(mysql_affected_rows() == 1){
					//echo 'registro insertado!';
					insertarTextoImagen($imagen_id, $idioma, $connection);
				}
			}

		} else if (isset($_GET['texto_id'])) {
			
			$imagen_id = $_GET['texto_id'];
			$columna = 'contenido_id';
			
			// BUSCAR EN IMAGENES ALBUMS POR EL REGISTRO
			$q_imgalbum  = " SELECT id, contenido_id ";
			$q_imgalbum .= " FROM imagenes_albums ";
			$q_imgalbum .= " WHERE contenido_id = 0" ;
			$q_imgalbum .= " AND texto_id = " . $_GET['texto_id'];
			$r_imgalbum = mysql_query($q_imgalbum, $connection);
			
			if (mysql_num_rows($r_imgalbum) == 1) {
				// RESGISTRO ENCONTRADO, ENVIAR EL ID DE LA FOTO,  NO DEL CONTENIDO A LA FUNCION
				$f_imgalbum = mysql_fetch_array($r_imgalbum);
				$imagen_id  = $f_imgalbum['id'];

				insertarTextoImagen($imagen_id, $idioma, $connection);
			} else {
				// INSERTAR IMAGEN EN LA TABLA DE LAS IM�GENES
				$src = $_GET['src'];
				$src = explode('/', $src);
				$src = end($src);
				
				$imagen1 = 'imagenes/pequenas/'.$src;
				$imagen2 = 'imagenes/medianas/'.$src;
				$imagen3 = 'imagenes/grandes/'.$src;
				
				$q_insertar_imagen  = " INSERT INTO imagenes_albums ";
				$q_insertar_imagen .= " ( texto_id, imagen1, imagen2, imagen3 ) ";
				$q_insertar_imagen .= " VALUES";
				$q_insertar_imagen .= " ( $imagen_id, '$imagen1', '$imagen2', '$imagen3' )";
				
				$r_insertar_imagen = mysql_query($q_insertar_imagen, $connection);
				
				// AL INSERTAR LA IMAGEN EN LA TABLA, ENVIAR EL ID DE ESTA IMAGEN A LA FUNCION
				$imagen_id = mysql_insert_id(); 
				
				if(mysql_affected_rows() == 1){
					//echo 'registro insertado!';
					insertarTextoImagen($imagen_id, $idioma, $connection);
				}
			}
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include_once('includes/tags.php'); ?>
	</head>

	<body>
		<div id="col2">
			<div id="cnt_edicion">

				<?php echo $mensaje; ?>

				<?php while($imagen = mysql_fetch_array($r_imagen)): ?>
					<?php 
						// SELECIONAR EL ALBUM
						// ENLACE VOLVER AL ALBUM
						
						$q_album = "SELECT titulo FROM albumes WHERE id = " . $imagen['album_id'] ;
						$r_album = mysql_query($q_album, $connection);
						
						if (mysql_num_rows($r_album) >=1) {
							
							while($album = mysql_fetch_array($r_album)){
								$tt_album = $album['titulo'];
							}
							
							$ruta_album  = '<a href="editar-galeria.php?album_id=' . $imagen['album_id'];
							$ruta_album .= '&album=' . $tt_album;
							$ruta_album .= '">VOLVER AL ALBUM</a>';
							
							// ENLACE VOLVER AL ALBUM
							echo $ruta_album;
						} else {
							$ruta_contenido  = '<a href="editar-contenido.php?contenido_id=' . $imagen['contenido_id'];
							$ruta_contenido .= '">VOLVER AL PROYECTO</a>';
							// ENLACE VOLVER AL CONTENIDO
							echo $ruta_contenido;
						}
					?>

					<h3>
						<?php 
							// MOSTRAR SOLO EL NOMBRE DE LA IMAGEN SIN LA RUTA
							$exp = explode('/', $imagen['imagen1']);
							echo end($exp) . '<br>';
						?>
					</h3>

					<img imagen-id="<?php echo $imagen['id'];?>" src="<?php echo $imagen['imagen1'];?>" width="300"/>
					<br>
					<br>
					<br>

					<!--
					FECHA DE CREACION: <?php //echo $imagen['fecha_creacion'] . '<br>'; ?>
					<br>
					<br>
					-->

					<?php 
						// IDIOMAS
						for($d = 0; $d < count($idiomas_arr); $d++){
							echo '<a href="editar-imagen.php?id=' . $imagen_id . '&idioma=' . $d . '">'. $idiomas_arr[$d][0] .'</a>';
							echo ' / ';
						}
					?>
					<br>
					<br>
					<br>

					<?php echo $imagen['tipo_contenido'] . ' en ' . $idiomas_arr[$idioma][0] . ':<br>'; ?>
					<form action="edicion/edc_imagenes/img-actualizar-contenidos.php" method="post">
						<input type="hidden" name="id"     value="<?php echo $imagen['img_id']; ?>" />
						<input type="hidden" name="idioma" value="<?php echo $idioma; ?>" />
						<br>
						<textarea name="texto" cols="100" rows="5" ><?php echo $imagen['texto']; ?></textarea>
						<br>
						<input type="submit" name="btn-act-imagen" class="boton1" value="Guardar" /> 
					</form>
				<?php endwhile;?>
			</div>
		</div>

		<div id="footer"></div>
		<?php include_once('includes/cabezote.php'); ?>
		<?php include_once('includes/navegacion.php'); ?>
	</body>
</html>
<?php 
	if (isset($connection)) { mysql_close($connection); }
?>
