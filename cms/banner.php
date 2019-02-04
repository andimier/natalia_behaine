<?php
	require_once("includes/requeridos.php");
	
	$mensaje = "";
		
	require_once("edicion/insertar-imgbanners.php");
	require_once("edicion/eliminar-imgbanners.php");
	
	
	
	if ( isset($_GET['seccion']) && !isset($_GET['idioma']) ){
	
		$seccion_id = $_GET['seccion'];
		$idioma = 0;
		
		$imagenes = "SELECT * FROM imagenes_banners WHERE seccion_id = {$seccion_id}";
		$banner = mysql_query($imagenes, $connection);
		
	}else if ( isset($_GET['seccion']) && isset($_GET['idioma']) ){
	
		$seccion_id = $_GET['seccion'];
		$idioma = $_GET['idioma'];
		
		$imagenes = "SELECT * FROM imagenes_banners WHERE seccion_id = {$seccion_id} AND idioma = {$idioma}";
		$banner = mysql_query($imagenes, $connection);
		
	}
	
	/*
	// DETECTAR IDIOMA PARA EL TITULO DEL BANNER
	if( $idioma == 0 ){
		$lenguaje = 'ESPAÑOL';
	}else if( $idioma == 1 ){
		$lenguaje = 'INGLÉS';
	}else{
		$lenguaje = 'PORTUGUÉS';
	}
	*/
	
	
	encontrar_seccion_y_contenido_seleccionados();
	
	require_once("cabeza.php");
?>

<div class="col2">
	<div class="imagenes">
		
	   <h3>BANNER <?php echo $seccion_seleccionada['titulo'] . " - " . $lenguaje; ?></h3>
			
			
			<?php 
				if($seccion_id == 1){
					echo "<div class=\"titulo-azul\">Estas imágenes deben tener un tamaño de 960px x 404px para que su visualización sea la adecuada.</div> <br />";
				}
			?>
			<div class="mensaje"> <?php echo $mensaje; ?></div>  
			
			
			<!-- ============= INSERTAR IMAGEN =========================================== -->
			
			<form enctype="multipart/form-data" method="post">
			 
				<input type="hidden" name="tabla"     value="imagenes_banners" />
				<input type="hidden" name="campo_id"  value="<?php echo $seccion_id; ?>" />
				<input type="hidden" name="campo"     value="seccion_id" />
				<input type="hidden" name="idioma"    value="<?php echo $idioma; ?>" />
				
				<input type="file"   name="nombre_archivo" />
				<input type="submit" name="insertarimagen" value="Insertar Imagen"/>
			</form>
		  
			<hr />
			<br />
			
			
				<?php while($imagen = mysql_fetch_array($banner)): ?>
					<?php 
						$explotarnombre = explode('/', $imagen['imagen1']); 
						$nombrearchivo = $explotarnombre[2]; 
						
					?>
					
					<div class="cnt_thumbs"> 
						<img src="<?php echo $imagen['imagen1']; ?>"  width="150" /> 
						<br />
						<br />
						<?php echo $nombrearchivo; ?> 
					
						<form enctype="multipart/form-data" method="post">
							<input type="hidden" name="tabla"     value="imagenes_banners" />
							<input type="hidden" name="id"  value="<?php echo $imagen['id'];?>" />
							<input type="submit" name="eliminar-imagen" value="Eliminar" id="btn_eliminar1" onClick="return confirm('Se eliminará definitivamente la imagen, quieres continuar?')"/>
						</form>
					</div>
				<?php endwhile; ?>
			
			
		

	</div>
	
</div>