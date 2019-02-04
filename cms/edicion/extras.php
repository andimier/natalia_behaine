	<div class="cnt-generico">
		Archivo de Audio
		<br>
		<br>
		<?php if(!isset($_POST['boton'])): ?>
		   
			<?php
				if(!empty($archivo)){
					
					$nombre = explode("/", $archivo); 
					echo $nombre[1];
					$valor = 'Cambiar Archivo';
					echo "<br>";
					echo "<br>";
				}else{
					$valor = 'Insertar Archivo';
				}  
			?>
			
			<!-- 
			//  REEMPLAZARRRR  ===============
			//  ARCHIVO
			-->
			
			<form enctype="multipart/form-data" method="post">
				<input type="hidden" name="contenido_id"  value="<?php echo $id;?>"/>
				<input type="hidden" name="tabla" 		  value="<?php echo $tabla; ?>"/>
				<input type="hidden" name="ruta" 		  value="<?php echo $archivo; ?>"/>
				<input type="submit" name="boton"  id="btn_cambioimagen"	value="<?php echo $valor; ?>" onClick="return confirm('Esta acción eliminará¡ la imagen, quieres continuar?')"/>
			</form>

		<?php else: ?>

			<!-- 
			//  INSERTAR  ===============
			//  ARCHIVO
			-->
			<br>
			<div class="cnt_nuevo_archivo fondo_gris">
			
				<form enctype="multipart/form-data" method="post">
					<input type="hidden" name="contenido_id" value="<?php echo $id;    ?>" />
					<input type="hidden" name="tabla"        value="<?php echo $tabla; ?>" />
					
					<input type="file" 	 name="nombre_archivo" class="letra_negra nuevo_archivo"/>
					<br />
					<input type="submit" name="btn_subirarchivo" value="Subir Archivo" class="fondo_negro"/>
				</form>
				
				
			</div>
			
		<?php endif; ?>
	
	</div>
	
	<div class="cnt-generico">
	
		Enlace Video
		<br>
		<br>
		<form enctype="multipart/form-data" method="post">
			<input type="text"   name="video"        value="<?php echo $video; ?>">
			<input type="hidden" name="contenido_id" value="<?php echo $id;?>"/>
			<input type="hidden" name="tabla" 		 value="<?php echo $tabla; ?>"/>
			<input type="hidden" name="ruta" 		 value="<?php echo $archivo; ?>"/>
			<br>
			<input type="submit" name="bvideo"       value="Guardar" class="boton1"	/>
		</form>
		
	</div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	