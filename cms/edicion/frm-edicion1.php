


<form enctype="multipart/form-data" name="formularioedicion1" id="formularioedicion1" method="post">

	<input type="hidden" name="id"     value="<?php echo $id;?>"/>
	<input type="hidden" name="txt_id" value="<?php echo $txt_id;?>"/>
	<input type="hidden" name="tabla"  value="<?php echo $tabla;?>"/>

	
	
	<input type="text" name="titulo" id="titulo" value="<?php echo $titulo; ?>" size="50" maxlength="50" />
	<input type="text" name="fecha"  id="fecha"  value="<?php echo $fecha; ?>"  size="50" maxlength="50" />
	
	
	<!--
	ASIGNACION DE 
	LOS FOTOGRAFOS
	-->
	<?php if(!isset($contenido)): ?>
		
		<br />
		<br />
		
		
		asignado a fotografo: <?php echo $quien ?>
		<br />
		<br />
		
		<input type="hidden" name="tt_contenido"  value="<?php echo $quien; ?>" />
		
	
		<select name="contenido_id" id="escoger2">
		
			<option value="0">ninguno</option>
			
			<?php while($conte = mysql_fetch_array($r_contenido)): ?>
				<option value="<?php echo $conte['id']; ?>" <?php echo $sele = ( $conte['titulo'] == $quien) ? $sele = 'selected': $sele =""; ?>>
					<?php echo $conte['titulo']; ?>
				</option>
			<?php endwhile; ?>
			
		</select>
		
		
	
	<?php endif; ?>
	
</form>



<script src="js/formulario_edicion.js" type="text/javascript"></script>















