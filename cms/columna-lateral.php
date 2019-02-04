<?php 


	require_once("includes/sesion.php");
	require_once("includes/connection.php");
	require_once("includes/functions.php");
	
	encontrar_seccion_y_contenido_seleccionados();


	$mensaje = "";
	
	

	if(isset($_POST['insertarnoticia'])){
		$titulo = $_POST['titulo'];
		
		$errores = array();
		$required_fields = array('titulo');
		$imagenprovisional = "imagenes/pequenas/camara_01.png";
		
		foreach($required_fields as $fieldname){
			if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname])  && !is_numeric($_POST[$fieldname]))){
				$errores[] = $fieldname;	
			}
		}
		
		if(empty($errores)){
			$query = "INSERT INTO noticias (titulo, imagen1, imagen2, imagen3) VALUES ('$titulo', '$imagenprovisional', '$imagenprovisional', '$imagenprovisional')";
			if($result = mysql_query($query, $connection)){
				$mensaje = "La publicacion se ha creado correctamente";	
			}
		}else{
				$mensaje = "Debes ingresar un titulo!!";
			}
		}

		require_once("cabeza.php");
	
	
?>    





	<div class="col2">
	
	
		<h3>Sección: Noticias</h3>
		<h2>CONTENIDOS EN ESTA SECCIÓN</h2>
		<div class="mensaje" style="color:#F00"> <? echo $mensaje; ?></div>
		
		<h4>Has click sobre el titulo del contenido para editarlo.</h4> 
		
		<?php
			$query = "SELECT * FROM contenidos";
			$result_set = mysql_query($query, $connection);
			confirm_query($result_set);
				
			while($contenido = mysql_fetch_array($result_set)){
				echo "<a href=\"editar-contenido.php?contenido_id=" . urlencode($contenido["id"]) . "\"> {$contenido["titulo"]}</a><br />";
			}
		?>
	   
		<hr />
		<!--
		<h3>Insertar nueva Publicacion</h3>
		Titluo:
		<form enctype="multipart/form-data" method="post">
			<input type="hidden" name="tabla"   value="imagenes_publicaciones" />
			<input type="text"   name="titulo"  value="" size="50" maxlength="50" />
			<input type="submit" name="insertarnoticia" value="Insertar Noticia"/>
		</form>
		-->
	</div>


	</div>
	<?php require("includes/footer.php");?>
