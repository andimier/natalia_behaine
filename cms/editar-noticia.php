<?php
	require_once("includes/requeridos.php");
	
	$mensaje = "";
	$mensaje2 = "";
	$imagen = "";
	$mensajeimagen = "";
		
	if(intval($_GET['noticia_id']) == 0){
		header("Location: content.php");	
		exit;
	}else{
		$id = $_GET['noticia_id'];
		//$grupo_imagenes = traer_imagenes_publicacion_por_id($id); 
	}
	
	require_once('edicion/cambioimagen1.php');
	require_once("edicion/actualizaciondecontenidos.php");
	
	traer_noticia_seleccionada(); 
	//Sí esto se pone al inicio del documento, al actualizar no se ven los cambios, pero sí se hacen 
	
	//========== PARAMETROS FORMULARIO ACTUALIZACION DE CONTENIDOS =================//
	
	$tabla      = "noticias";
	$id        	= $noticia_seleccionada['id'];
	$fecha     	= $noticia_seleccionada['fecha'];
	$titulo    	= $noticia_seleccionada['titulo']; 
	$contenido 	= $noticia_seleccionada['contenido'];
	
	$imagenprincipal = $noticia_seleccionada['imagen1'];
	
	$tituloboton = "Eliminar Noticia";

	require_once("cabeza.php");

?>

<div class="col2">

	Editar Noticia: <?php echo $noticia_seleccionada['titulo'];?>
    <br /><br />
        
	<?php $archivo_eliminar = 'edicion/eliminarnoticia.php'; ?>
	
	<?php echo $mensaje2; echo $mensaje;  ?>
	<?php require_once("edicion/formularioedicion1.php");	?>
    <?php require_once("edicion/formularioeliminar1.php"); ?>
    <br />
    <br />
    
      
</div>
   
<div class="col3" >
    <!-- ======================== IMAGEN PRINCIPAL DE LA PUBLICACION =====================-->
	<?php require_once('edicion/imagenprincipal.php'); ?>
</div>
