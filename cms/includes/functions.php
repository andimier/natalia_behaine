<?php
	function redirect_to($location = NULL){
		if ($location !=NULL){
			header("Location: {$location}");
			exit;
		} 
	} 

	function mysql_prep($value){
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists("mysql_real_scape_string");
		
		if($new_enough_php){
			if($magic_quotes_active){$value = stripslashes($value);}
			$value = mysql_real_scape_string($value);
		}else{
			if(!$magic_quotes_active){$value = addslashes($value);}
		}
		return $value;
	}
	
	function confirm_query($result_set){
		if(!$result_set){
			die("La busqueda en la Base de Datos fallo: " . mysql_error());
		}
	}
	
	//======================= SECCIONES ==============================//
	
	function todas_las_secciones(){
		global $connection;
		$query = 
			
		$grupo_secciones = phpMethods('query', "SELECT * FROM secciones ORDER BY id ASC");
		confirm_query($grupo_secciones);
		return $grupo_secciones;
	}
	
	function traer_seccion_por_id($seccion_id){
		global $connection;
		$query = "SELECT * FROM secciones WHERE id=" . $seccion_id ." LIMIT 1";
		
		$result_set = phpMethods('query',$query);
		confirm_query($result_set);
	
		if ($seccion = phpMethods('fetch', $result_set)) {
			return $seccion;
		} else {
			return NULL;
		}
	}
	
	//============== PUBLICACIONES ==================
	
	function todas_las_publicaciones(){
		global $connection;
		$query = "SELECT * FROM publicaciones ORDER BY fecha DESC";
			
		$grupo_publicaciones = mysql_query($query, $connection);
		confirm_query($grupo_publicaciones);
		return $grupo_publicaciones;
	}
	
	function traer_publicacion_por_id($publicacion_id){
		global $connection;
		$query = "SELECT * FROM publicaciones WHERE id =" . $publicacion_id ." LIMIT 1";
		
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
	
		if($contenido = mysql_fetch_array($result_set)){
			return $contenido;
		}else{
			return NULL;
		}
	}
	
	function traer_publicacion_seleccionada(){
		global $publicacion_seleccionada;
		
		if(isset($_GET['publicacion_id'])){
			$sel_publicacion = $_GET['publicacion_id'];
			$publicacion_seleccionada = traer_publicacion_por_id($sel_publicacion);
		}
	}
	
	//============  IMAGENES PUBLICACIONES ==================//

	
	function traer_imagenes_publicacion_por_id($id){
		global $connection;
		$query = "SELECT * FROM imagenes_publicaciones WHERE publicacion_id = $id";
		
		$grupo_imagenes = mysql_query($query, $connection);
		confirm_query($grupo_imagenes);
		return $grupo_imagenes;
	}
	
	
	//==================== NOTICIAS =========================================
	
	function todas_las_noticias(){
		global $connection;
		$query = "SELECT * FROM noticias ORDER BY fecha DESC";
			
		$grupo_noticias = mysql_query($query, $connection);
		confirm_query($grupo_noticias);
		return $grupo_noticias;
	}
	
	function traer_noticia_por_id($noticia_id){
		global $connection;
		$query = "SELECT * FROM noticias WHERE id =" . $noticia_id ." LIMIT 1";
		
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
	
		if($contenido = mysql_fetch_array($result_set)){
			return $contenido;
		}else{
			return NULL;
		}
	}
	
	function traer_noticia_seleccionada(){
		global $noticia_seleccionada;
		
		if(isset($_GET['noticia_id'])){
			$sel_noticia = $_GET['noticia_id'];
			$noticia_seleccionada = traer_noticia_por_id($sel_noticia);
		}
	}
	
	//============  IMAGENES NOTICIAS ==================//

	
	/*function traer_imagenes_publicacion_por_id($id){
		global $connection;
		$query = "SELECT * FROM imagenes_publicaciones WHERE publicacion_id = $id";
		
		$grupo_imagenes = mysql_query($query, $connection);
		confirm_query($grupo_imagenes);
		return $grupo_imagenes;
	}
	*/
	
	//====================  CONTENIDOS  =========================================//
	
	function traer_contenido_por_id($contenido_id){
	
		global $connection;
		$query = "SELECT * FROM contenidos WHERE id =" . $contenido_id ." LIMIT 1";
		
		$result_set = phpMethods('query', $query);
		confirm_query($result_set);
	
		if ($contenido = phpMethods('fetch', $result_set)) {
			return $contenido;
		} else {
			return NULL;
		}
	}
	
	//===============================  SECCION Y CONTENIDO SELECCIONADO ==========================//
	
	function encontrar_seccion_y_contenido_seleccionados(){
		
		global $seccion_seleccionada;
		global $contenido_seleccionado;
			
		if(isset($_GET['seccion'])){
			$sel_seccion = $_GET['seccion'];
			$seccion_seleccionada = traer_seccion_por_id($sel_seccion);
			
			$sel_contenido = "";
			$contenido_seleccionado = NULL;
			
		}elseif(isset($_GET['contenido_id'])){
		
			$sel_contenido = $_GET['contenido_id'];
			$contenido_seleccionado = traer_contenido_por_id($sel_contenido);
			
			$sel_seccion = "";
			$seccion_seleccionada = NULL;
			
		}else{
			$sel_seccion = "";
			$sel_contenido = "";
			$seccion_seleccionada = NULL;
			$contenido_seleccionado = NULL;
		}
	}
	
	//============================= ARTICULOS ====================================
	
	function traer_articulo_por_id($articulo_id){
		global $connection;
		$query = "SELECT * FROM articulos WHERE id=" . $articulo_id ." LIMIT 1";
		
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
	
		if($articulo = mysql_fetch_array($result_set)){
			return $articulo;
		}else{
			return NULL;
		}
	}
	
	function traer_articulo_seleccionado(){
		global $articulo_seleccionado;
		
		if(isset($_GET['articulo_id'])){
			$sel_articulo = $_GET['articulo_id'];
			$articulo_seleccionado = traer_articulo_por_id($sel_articulo);
		}
	}
	
	//============  IMAGENES ARTICULOS ==================//

	function traer_imagenes_articulo_por_id($id){
		global $connection;
		$query = "SELECT * FROM imagenes_articulos WHERE articulo_id = $id";
		
		$grupo_imagenes_articulo = mysql_query($query, $connection);
		confirm_query($grupo_imagenes_articulo);
		return $grupo_imagenes_articulo;
	}
	
	
	// ================== NAVEGACION ======================================================//
	
	function navegacion($seccion_seleccionada, $contenido_seleccionado){
	
		$grupo_secciones = todas_las_secciones();
	
		while ($seccion = phpMethods('fetch', $grupo_secciones)) {
			
			if($seccion['indice'] == 0){
				echo "<div class=\"secciones1\"><a href=\"editar-seccion.php?seccion=" . $seccion['id'] . "\"> {$seccion['titulo']} </a></div>"; 
			}else{
				echo "<div class=\"secciones2\"><a href=\"editar-seccion.php?seccion=" . $seccion['id'] . "\"> {$seccion['titulo']} </a></div>";
			}
		}
	}
	
?>