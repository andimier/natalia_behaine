<?php

	
	
	//========== PARAMETROS FORMULARIO ACTUALIZACION DE CONTENIDOS =================//
	
	if(isset($_GET['contenido_id'])){
		
		
		// PARÁMETROS PARA 
		// ACTUALIZAR 
		
		
		$tabla 	   = "contenidos";
		$id        = $contenido_seleccionado['id'];
		
		$fecha     = $contenido_seleccionado['fecha'];
		$titulo    = $contenido_seleccionado['titulo']; 
		
		$compra    = $contenido_seleccionado['compra'];
		$archivo   = $contenido_seleccionado['archivo1'];
		$video     = $contenido_seleccionado['video'];
		$videos_gl = $contenido_seleccionado['galeria_videos'];

		$seccion       = $contenido_seleccionado['seccion_id'];
		$contenido     = $contenido_seleccionado['contenido'];
		
		
		$imagenprincipal = $contenido_seleccionado['imagen1'];
		$img = $contenido_seleccionado['imagen2'];
		
		
		// PARÁMETROS PARA 
		// EL ARCHIVO DE ELIMINAR 
		
		$indice    = $contenido_seleccionado['indice'];
		$borrable  = $contenido_seleccionado['borrable'];
		
	
	
	}else if(isset($_GET['album_id'])){
	
		//echo "album";
		// PARÁMETROS PARA 
		// ACTUALIZAR 
		
		$tabla 	   = "albumes";
		$id        = $album_seleccionado['id'];
		$fecha     = $album_seleccionado['fecha'];
		$titulo    = $album_seleccionado['titulo']; 
		$contenido_id = $album_seleccionado['contenido_id']; 
		
		
		$imagenprincipal = $album_seleccionado['imagen1'];
		$img = $album_seleccionado['imagen2'];
		
		// PARÁMETROS PARA 
		// EL ARCHIVO DE ELIMINAR 
		$borrable  = 1;
		$seccion   = $album_seleccionado['seccion_id'];
	
	}
	
	
	
	
	
?>