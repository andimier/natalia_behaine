<?php 
	
	require_once('requeridos/conexion/connection.php');
	$seccion = 3;
	
	if(isset($_GET['lang'])){
		$idioma = $_GET['lang'];
	}else{
		$idioma = 0;
	}
	$hijo = false;
	
	require_once('requeridos/qs.php');
	require_once('requeridos/elementos-arr.php');

?>



<!doctype html>
<html>
	<head>

		<?php include('requeridos/tags.php'); ?>

		<link href="estilos/bitacora-gr.css" rel="stylesheet" type="text/css"  media="screen"/>
		<link href="estilos/bitacora-md.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:481px) and (max-width:800px)"  />
		<link href="estilos/bitacora-pq.css" rel="stylesheet" type="text/css"  media="only screen and (min-width:50px) and (max-width:480px)" />
	
	</head>

	<body>
		
		<?php include('requeridos/cabezote1.php'); ?>
		
		<div id="cuerpo">
			
			<?php while($bitacora = mysql_fetch_array($r_bitacoras)): ?>
				
				<?php
					
					require_once('requeridos/caracteres-arr.php');
					$ttparcial = str_replace(array_keys($arrcaract), array_values($arrcaract), $bitacora['titulo']);
					$ttlink = str_replace(' ', '-', $ttparcial);
				?>
				
				
				
				<div style="clear:both">
		
					<h1 class="tt_bitacora">
					
						<!--
						ENLACE ORIGINAL FUERA DE LA CARPETA BITACORA
						<a href="<?php //echo $rta_proyecto . strtolower($ttlink); ?>">
						-->
						
						<?php
						
						$link_bit  = $gn_arr['url'][7][$idioma];
						$link_bit .= '/' . strtolower($ttlink)
						?>
						<a href="<?php echo $link_bit; ?>">
							<?php echo $bitacora['titulo']; ?>
							
						</a>
						
					</h1>
					
					
					
					<h2 class="fch_bitacora"><?php echo str_replace('-', '/', $bitacora['fecha']); ?></h2>
					
					<div class="tj_bitacora">
					
						<p class="txt_bitacora">
						
						<?php array_push($arr_textos, $bitacora['contenido']); ?>
						<?php array_push($arr_imagen, $bitacora['imagen3']); ?>
						
						</p>
						<div class="vacio"></div>
					</div>
					
					
					<h3 class="tt_mas lninferior">
						<!--
						ENLACE ORIGINAL FUERA DE LA CARPETA BITACORA
						<a href="<?php //echo $ruta . $rta_proyecto . strtolower($ttlink); ?>">
						-->
						
						<a href="<?php echo strtolower($ttlink); ?>">
							<?php echo $gn_arr['titulos']['leer-mas'][$idioma]; ?>
						</a>
					</h3>
					
				</div>
			<?php endwhile; ?>

			
			
			
		
			<script>
				var rbitacora = 1.77;
	
				var entrada = document.getElementsByClassName('tj_bitacora');
				var imagen = document.getElementsByClassName('img_bitacora');
				
				window.addEventListener('resize', ResizeBitacora);
				
				function ResizeBitacora(){
					AjustarBItacora();
				}
				
				function AjustarBItacora(){
					
					
					
				}
				
				
				
				var textos = [];
				var imagenes = [];
				
				var txt_bitacora = document.getElementsByClassName('txt_bitacora');
				var cuerpo = document.getElementById('cuerpo')
	
				<?php foreach($arr_textos as $key => $val){ ?>
					textos.push('<?php echo $val; ?>');
				<?php } ?>
				
				<?php foreach($arr_imagen as $key2 => $val2){ ?>
					imagenes.push('<?php echo $val2; ?>');
				<?php } ?>
				
				
				
				for(t=0; t< txt_bitacora.length; t++){
			
					txt_bitacora[t].innerHTML = '<div class="img_bitacora"><img src="cms/'+imagenes[t]+'" /></div> ' + textos[t].substr(0, 2000);
				}
				
				
				//$('.img_bitacora img').each(function(){
				//	console.log($(this).height());
				//})
				
				AjustarBItacora();
				
				//arget.getAttribute('data-src');
				
				
			</script>
			
		</div>
		
		<?php require_once('requeridos/footer.php'); ?>
	</body>
</html>


