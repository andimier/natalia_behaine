	
	<a href="<?php echo 'editar-imagen.php?texto_id='.$txt_id.'&src='.$txt_img1; ?>">
		<img src="<?php echo $txt_img1; ?>" width="165"/>
	</a>
	
	<br>

	<div class="cnt_nuevo_archivo">
	
		<form enctype="multipart/form-data" method="post">
		
			<input type="hidden" name="contenido_id" value="<?php echo $txt_id;    ?>" />
			<input type="hidden" name="texto_id"     value="<?php echo $txt_id;    ?>" />
			<input type="hidden" name="contenido"    value="<?php echo $_GET['contenido']; ?>" />
			<input type="hidden" name="sub-contenido"    value="<?php echo $_GET['sub-contenido']; ?>" />
			<input type="hidden" name="ruta" 		 value="<?php echo $txt_img1; ?>"/>
			<input type="hidden" name="tabla"        value="textos_contenidos" />
			
			<div id="fileUpload">
			<input id="btn_foto" type="button" value="escoge una imagen" class="mascara">
			<input id="foto"  type="file" name="nombre_archivo"  class="upload" onchange="myFunction(this.value)" >
			</div>

			<p id='nm_imagen'></p>
			
			<input id="bsubirimg" type="submit" name="botonsubirimagen" value="" class="fondo_negro"/>
		</form>
		
		
	</div>
	
	<script>
		
		function myFunction(val) {
			//document.getElementById("uploadFile").value = this.value;
			$("#nm_imagen").text(val);
			$("#bsubirimg").css('display', 'block');
			
		};
		
	</script>