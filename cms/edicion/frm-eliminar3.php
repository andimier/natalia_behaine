	

	<div id="cnt_formularioEliminar">
	
		<form action="edicion/eliminar-textos.php" enctype="multipart/form-data" method="post">
		
			<input type="hidden" name="id"        		value="<?php echo $txt_id; ?>"/>
			<input type="hidden" name="contenido_id" 	value="<?php echo $txt_contenido_id; ?>"/>
			<input type="hidden" name="seccion" 	    value="<?php echo $txt_seccion; ?>"/>
			<input type="hidden" name="url" 	    	value="<?php echo $url; ?>"/>
			<input type="hidden" name="imagen" 	    	value="<?php echo $txt_img1; ?>"/>
			
			<input type="submit" name="eliminar" id="btn_eliminar1" value="<?php echo $tituloboton; ?>" onClick="return confirm('Esta acción eliminará definitivamente este contenido., quieres continuar?')"/>
		</form>
	
	</div>