



		<form enctype="multipart/form-data" action="edicion/act-textos.php" name="formularioedicion1" id="formularioedicion1" method="post">
			
			<input type="hidden" name="tabla"    value="<?php echo $tabla;?>"/>
			
			<?php 
			if(isset($_GET['sub-contenido'])){
				echo '<input type="hidden" name="sub-contenido" value="'.$_GET['sub-contenido'].'"/>';
			}
			?>
			
			<input type="hidden" name="contenido_id"  value="<?php echo $txt_contenido_id;?>"/>
			
			<input type="hidden" name="texto_id" value="<?php echo $txt_texto_id;?>"/>
			<input type="hidden" name="id"       value="<?php echo $txt_id;?>"/>
			
			
			<input type="hidden" name="idioma"  value="<?php echo $txt_idioma;?>"/>
			
			
			<?php 
			
			// VERIFICAR SI GET CONTENIDO EXISTE PARA
			// ACTIVAR EL CAMPO TÍTULO Y FECHA
			
			if(isset($_GET['contenido'])){
				
				$contenidos_arr = array('Menciones','Exposiciones', 'Publicaciones', 'Convocatorias');
				$cont_arr = array();
				
				foreach($contenidos_arr as $valor){
					if($_GET['contenido'] == $valor){
						array_push($cont_arr, $valor);
					}
				}

			}

			?>
			
			<input type="text" name="titulo" id="titulo" value="<?php echo $txt_titulo; ?>" size="50" maxlength="50" />
			<input type="text" name="fecha"  id="fecha"  value="<?php echo $txt_fecha; ?>"  size="50" maxlength="50" />
			
			
			
			<div id="cnt_botonesedicion">

				<img class="intLink" title="Quitar Formato" onClick="qFormato('removeFormat');" src="edicion/iconos/formato1.png">
				<img class="intLink" title="Negrilla" onClick="formatDoc('bold');"      src="edicion/iconos/bold.png" />
				<img class="intLink" title="Enlazar"  onClick="linkear('createLink');"  src="edicion/iconos/link.png" />
				<img class="intLink" title="Desenlazar"  onClick="formatDoc('unlink');" src="edicion/iconos/unlink.png" />
				
				<img class="intLink" title="Subrayar"  onClick="formatDoc('underline');"   src="edicion/iconos/underline.png" />
				
				<div id="btn_pegar">Pegar texto</div>
				
			</div>



			<textarea style="display:none;" name="areadetexto" id="areadetexto" cols="100" rows="14" ></textarea>

			<div id="cnt_cajasdetexto">
				<div id="caja1" contenteditable=""><?php echo $txt_contenido; ?></div> 
				<div id="caja2" contenteditable="true" style="background-color:#ff0"></div> 
			</div>

			
			<!--<pre id="caja3"></pre> -->
			<div id="btn_completar" onClick="javascript:QuitarFormato();"/>GUARDAR</div>
			
			<input type="submit" name="boton1" class="boton1" value="Guardar" onClick="javascript:submit_form();"/> 


			<script src="js/formulario_edicion.js" type="text/javascript"></script>

		</form>