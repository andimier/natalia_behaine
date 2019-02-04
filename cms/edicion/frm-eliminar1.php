	

	<div id="cnt_formularioEliminar">
	
		<!--<form action="<?php //echo $archivo_eliminar; ?>" enctype="multipart/form-data" method="post">-->
		<form action="edicion/eliminar-grupo-contenido.php" enctype="multipart/form-data" method="post">
		
			<input type="hidden" name="id"        value="<?php echo $id; ?>"/>
			<input type="hidden" name="tabla" 	  value="<?php echo $tabla; ?>"/>
			<input type="hidden" name="seccion"   value="<?php echo $seccion; ?>"/>
			
			<input type="hidden" name="imagenprincipal" value="<?php echo $imagenprincipal; ?>"/>
			<input type="hidden" name="video"   value="<?php echo $video; ?>"/>
			<input type="hidden" name="archivo" value="<?php echo $archivo; ?>"/>
			
			<input type="submit" name="eliminar" id="btn_eliminar1" value="<?php echo $tituloboton; ?>" onClick="return confirm('Esta acción eliminará definitivamente este contenido., quieres continuar?')"/>
		</form>
	
	</div>