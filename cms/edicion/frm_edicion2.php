


<form enctype="multipart/form-data" name="formularioedicion1" id="formularioedicion1" method="post">

	<input type="hidden" name="id"     value="<?php echo $id;?>"/>
	<input type="hidden" name="tabla"  value="<?php echo $tabla;?>"/>


	
	<?php if(isset($contenido)): ?>
	
	
		<div id="cnt_botonesedicion">


			<img class="intLink" title="Quitar Formato" onClick="qFormato('removeFormat');" src="edicion/iconos/formato1.png">
			<img class="intLink" title="Negrilla" onClick="formatDoc('bold');"     src="edicion/iconos/bold.png" />
			<img class="intLink" title="Enlazar"  onClick="linkear('createLink');" src="edicion/iconos/link.png" />
			<img class="intLink" title="Desenlazar"  onClick="formatDoc('unlink');" src="edicion/iconos/unlink.png" />
			
			<img class="intLink" title="Subrayar"  onClick="formatDoc('underline');"   src="edicion/iconos/underline.png" />
			
			<div id="btn_pegar">Pegar texto</div>
			
		</div>
	


		<textarea style="display:none;" name="areadetexto" id="areadetexto" cols="100" rows="14" ></textarea>

		
		
		<div id="cnt_cajasdetexto">
		
			<div id="caja1" contenteditable=""><?php echo $contenido; ?></div> 
			<pre id="caja2" contenteditable="true" style="background-color:#ff0"></pre> 
			
		</div>
		
		<pre id="caja3" ></pre> 
		<div id="btn_completar" onClick="javascript:QuitarFormato();"/>GUARDAR</div>
	
	
		<input type="submit" name="boton1" class="boton1" value="Guardar" onClick="javascript:submit_form();"/> 
		
		
		<script src="js/formulario_edicion.js" type="text/javascript"></script>
		
		
	
	<?php else: ?>
		<!--
		// SI EL CONTENIDO A ACTUALIZAR
		// ES UN ÁLBUM, QUITO LA FUNCION DE JS
		-->
		<br />
		<input type="submit" name="boton1" class="boton1" value="Guardar" /> 

	
	<?php endif; ?>


</form>



















