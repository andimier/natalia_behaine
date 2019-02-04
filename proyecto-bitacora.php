<?php 
	
	require_once('requeridos/conexion/connection.php');
	$seccion = 7;
	
	if(isset($_GET['lang'])){
		$idioma = $_GET['lang'];
	}else{
		$idioma = 0;
	}
	
	$hijo=true;
	
	require_once('requeridos/qs.php');
	require_once('requeridos/elementos-arr.php');


?>


<!doctype html>
<html>
	<head>
		
		
		<?php include('requeridos/tags.php'); ?>
		
		
		<link href="<?php echo $gn_arr['ruta'][$seccion][$idioma] . 'estilos/bitacora-gr.css';?>" type="text/css" rel="stylesheet" media="screen"/>
		<link href="<?php echo $gn_arr['ruta'][$seccion][$idioma] . 'estilos/bitacora-md.css';?>" rel="stylesheet" type="text/css"  media="only screen and (min-width:481px) and (max-width:800px)"  />
		<link href="<?php echo $gn_arr['ruta'][$seccion][$idioma] . 'estilos/bitacora-pq.css';?>" rel="stylesheet" type="text/css"  media="only screen and (min-width:50px) and (max-width:480px)"  />
		
	
		<?php include('requeridos/tags-galeria.php'); ?>
	</head>

	<body>
		
		<?php include('requeridos/cabezote1.php'); ?>
		
		<div id="cuerpo">

			<h1 class="tt_bitacora"><?php echo $bit_tt; ?></h1>
			<h2 class="fch_bitacora"><?php echo str_replace('-', '/', $bit_fec); ?></h2>
			
			<div class="tj_bitacora">
			
				<p class="txt_bitacora">
				
					<div class="img_bitacora">
						<img src="<?php echo $gn_arr['ruta'][$seccion][$idioma] . 'cms/' . $bit_img3; ?>" />
					</div>
					<?php echo $bit_txt; ?>
		
				</p>
				
				
				<div class="vacio"></div>
			</div>
			
			
			<?php if(!empty($bit_vid)): ?>
				<div class="video">
					<iframe src="//player.vimeo.com/video/<?php echo $bit_vid; ?>" width="100%" height="100%" frameborder="0" title="" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				</div>
			<?php endif; ?>
			
			<?php if(!empty($album_id)): ?>
				
				<?php
					$q_imagenes = 'SELECT * FROM imagenes_albums WHERE album_id = ' . $album_id;
					$r_imagenes = mysql_query($q_imagenes, $connection);
					
				?>
			
				<?php if(mysql_num_rows($r_imagenes) >=1): ?>
				
					<div id="cnt_galeria">
						<div id="tt_galeria">
							<h1><?php echo $gn_arr['titulos']['imgenes-del-proceso'][$idioma]; ?></h1>
							
						</div>
						
						<div id="galeria">
							
							<?php while($imagen = mysql_fetch_array($r_imagenes)): ?>
							
								<?php
								$link_imagenes  = $gn_arr['ruta'][$seccion][$idioma] . 'cms/';
								$link_imagenes .= $imagen['imagen3'];
								?>
								
								<div class="foto">
									<a class="fancybox" href="<?php echo $link_imagenes; ?>" data-fancybox-group="gallery" title="" >
										<img src="<?php echo $gn_arr['ruta'][$seccion][$idioma] . 'cms/' . $imagen['imagen1']; ?>" />
									</a>
								</div>
								
							<?php endwhile; ?>
						
							<div class="vacio"></div>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			
			
			
			
			
			<script>
				var ratioV = 1.77;
				var video = document.getElementsByClassName('video');
				
				var img_bitacora = document.getElementsByClassName('img_bitacora');
			
				var fuente = img_bitacora[0].getElementsByTagName('img')[0].src;
				
	
		
				window.addEventListener('resize', Ordenar,false);
				
				function Ordenar(){
					AjustarBitacora();
				}
				
				function AjustarBitacora(){
					
					if(video.length >= 1){
						video[0].style.height = video[0].offsetWidth / ratioV + 'px';
					}
					///////////
					
					margen = $('.foto').first().css('margin-left');
				
					margenF = margen.replace('px', '');
					console.log(margenF);
					
					for( f = 0; f < foto.length; f++ ){
						foto[f].style.height = foto[0].offsetWidth + 'px';
					}
					
					$('.foto').each(function(){
						$(this).css({ marginTop : margenF *2 +'px'})
					});
					
					
					var img = new Image();
					img.src = fuente;
					
					img.addEventListener('load', function(){
						
						var ancho = this.width;
						var alto = this.height;
						
						if(alto > ancho){
							
							if(window.innerWidth > 400){
								img_bitacora[0].style.width = '40%';
							}else if(window.innerWidth < 401){
								img_bitacora[0].style.width = '100%';
							}
							
							
						}else{
							
							if(window.innerWidth<801 && window.innerWidth >400){
								img_bitacora[0].style.width = '45%';
							}else if(window.innerWidth < 401){
								img_bitacora[0].style.width = '100%';
							}else{
								img_bitacora[0].style.width = '60%';
							}
						}
					});
					
				}
				
			
				
				///////////////
				
				var foto = document.getElementsByClassName('foto');
				var margen = $('.foto').first().css('margin-left');
				
				var ratioT = 2.18;
				var ratioP = 1.38;
				
			
				
				AjustarBitacora();
				
				
				/////////////////
				
				
				
				
				
			</script>
			
			
		</div>
		
		<?php require_once('requeridos/footer.php'); ?>
	</body>
</html>