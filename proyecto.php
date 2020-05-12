<?php
	require_once('requeridos/conexion/connection.php');
	$seccion = 5;
	$idioma = isset($_GET['lang']) ? $_GET['lang'] : 0;
	$hijo = true;

	require_once('utils/phpfunctions.php');
	require_once('requeridos/qs.php');
	require_once('requeridos/elementos-arr.php');
    require_once('requeridos/modelos/modelo-proyecto.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<?php require_once('requeridos/tags.php'); ?>
		<link href="../estilos/proyectos-gr2.css" rel="stylesheet" type="text/css"  media="screen"/>
		<link href="../estilos/proyectos-md.css"  rel="stylesheet" type="text/css"  media="only screen and (min-width:481px) and (max-width:800px)"  />
		<link href="../estilos/proyectos-pq.css"  rel="stylesheet" type="text/css"  media="only screen and (min-width:50px) and (max-width:480px)"  />
		<?php include('requeridos/tags-galeria.php'); ?>
	</head>

	<body>
		<?php require_once('requeridos/cabezote1.php'); ?>

		<div id="cuerpo">
			<div class="tarjeta_prg">
				<div class="img_prg f-box-gallery">
					<a class="f-box f-box-main-image" href="cms/<?php echo $largeImage; ?>" img-id="<?php echo $imageId; ?>" title="" texto="<?php echo piedefoto($imageId); ?>">
						<img id="prg-img" class="fbox-over" src="http://www.nataliabehaine.com/cms/<?php echo $largeImage; ?>" alt="<?php echo piedefoto($imageId); ?>" />
					</a>
				</div>

				<div class="cnt_txt_prg">
					<div class="txt_prg">
						<h2>
                            <?php echo $projectDataList['project_title']; ?>
                        </h2>

						<!-- BOTON DE COMPRA -->
						<?php if ($projectDataList['project_purchase'] == 1) : ?>
                            <?php $link_carrito = $gn_arr['url-lang'][8][$idioma]; ?>
                            <a href="<?php echo $link_carrito ?>"><?php echo $link_carrito ?></a>

                            <div class="btn-compra">
                                <form method="post" action="<?php echo $link_carrito ?>">
                                    <input type="hidden" name="link-carrito" value="<?php echo $link_carrito; ?>" />
                                    <input type="hidden" name="pid" value="<?php echo $projectDataList['project_id']; ?>" />
                                    <input type="hidden" name="titulo" value='<?php echo $projectDataList['project_title']; ?>' />
                                    <input type="hidden" name="imagen" value="<?php echo $proy_im1; ?>" />
                                    <input s type="submit" name="btn_carrito" id="btn-carrito" value="<?php echo ucfirst($gn_arr['titulos']['comprar-obra'][$idioma]); ?>" />
                                </form>
                            </div>
						<?php endif; ?>

						<!--
						<div class="txt_resena">
							<h3>
								<?php //echo ($idioma == 0 ) ? 'Sinopsis de la Obra' : (( $idioma == 1 ) ? 'Project synopsis' : 'Résumé des travaux'); ?>
							</h3>
							SINOPSIS DE LA OBRA
							<p id="txt1"></p>
						</div>
						-->
					</div>
				</div>
			</div>

			<div id="tt-descripcion">
				<h2>
					<?php echo stripslashes($gn_arr['titulos']['descripcion-de-la-obra'][$idioma]); ?>
				</h2>
			</div>

			<div id="cntp">
				<?php if (isset($textos['descripcion-obra'])): ?>
					<p id="txt-fragmento1"></p>
                    <p id="extra-text-container"></p>

                    <button id="extra-text-button" type="button">
                        <?php echo stripslashes($gn_arr['titulos']['leer-mas'][$idioma]); ?>
                    </button>

                    <?php if (isset($textos['descripcion-tecnica']) && !empty($textos['descripcion-tecnica'])): ?>
                        <p id="technical-description">
                            <?php echo $textos['descripcion-tecnica']; ?>
                        </p>
                    <?php endif; ?>
				<?php endif; ?>
			</div>

            <!--  GALERIA DE VIDEOS -->
            <?php if (!empty($projectDataList['installation'])) : ?>
                <?php $instData = $projectDataList['installation']; ?>

                    <div id="installation" class="<?php echo $topGalleryPadding; ?> gallery-container">
						<h2>
							<span><?php echo $gn_arr['titulos']['galeria-de-videos'][$idioma]; ?></span>
						</h2>

                        <div id="installation-container" class="f-box-gallery">
                            <?php for ($i = 0; $i < count($instData); $i++): ?>
                                <?php if ($i < 6): ?>
									<div class="installation-img">
										<a class="f-box" fbox-element-id=<?php echo $i ?> <?php echo $instData[$i]['linkTagAttributes']; ?> >
											<img class="foto-img" src="<?php echo $instData[$i]['smallImage']; ?>"/>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
            <?php elseif (!empty($projectDataList['project_video'])): ?>
                <div class="video default-top-padding" style="border-bottom: <?php echo $estilo; ?>;">
                    <iframe src="<?php echo getProjectVideoUrl($projectDataList['project_video']); ?>" width="100%" height="100%" frameborder="0" title="" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                </div>
            <?php endif; ?>

			<!--  GALERIA DE IMÁGENES -->
			<?php if (!empty($albumId)) : ?>
				<?php if (phpMethods('num-rows', $r_imagenes) >= 1) : ?>
					<div id="cnt_galeria" class="<?php echo $topGalleryPadding; ?> gallery-container">

						<h2>
							<span><?php echo setImagesCountText($idioma, $img_arr, $gn_arr) ?></span>
						</h2>

						<button class="load-gallery-btn" data-href=<?php echo $gn_arr['url-lang'][6][$idioma] . $albumId; ?>>
							+ <?php echo $gn_arr['titulos']['ir-a-galeria-completa'][$idioma] ?>
						</button>

						<div id="galeria">
							<?php for ($i = 0; $i < count($img_arr); $i++): ?>
                                <?php if ($i < 6): ?>
                                    <div class="foto-wrapper">

											<a class="foto fancybox"
												data-fancybox-group="gallery"
												fbox-element-id="<?php echo $i ?>"
												href="<?php echo 'cms/' . $img_arr[$i]['imagen3']; ?>"
												title="<?php echo $img_arr[$i]['alt']; ?>"
											>
												<img class="foto-img" src="<?php echo 'http://www.nataliabehaine.com/cms/' . $img_arr[$i]['imagen1']; ?>" alt="<?php echo $img_arr[$i]['alt']; ?>" />
											</a>

                                    </div>
                                <?php endif; ?>
							<?php endfor; ?>
						</div>

						<button class="load-gallery-btn" data-href="<?php echo $gn_arr['url-lang'][6][$idioma] . $albumId; ?>">
							+ <?php echo $gn_arr['titulos']['ir-a-galeria-completa'][$idioma] ?>
						</button>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if(!empty($projectDataList['project_audio'])): ?>
				<div class="audio">
					<div id="mando" class="play" ></div>
					<div id="tt_media" src="<?php echo 'cms/'.  $projectDataList['project_audio']; ?>"><?php echo $nom_cancion; ?></div>
				</div>
			<?php endif; ?>

			<?php if(!empty($projectDataList['project_audio'])): ?>
				<script src="js/playlist.js"></script>
			<?php endif; ?>

			<script>
				var fechas = document.getElementsByClassName('fecha');
				var c1 = new Array();

				for (var i=0; i < fechas.length; i++) {
					c1.push = fechas[i].innerHTML;
				}
			</script>

			<!-- BOTONES ANTERIOR Y SIGUIENTE -->
			<div id="indicador">
				<div id="pagi">
					<?php if( isset($ruta_anterior)): ?>
						<div id="anterior">
							<a href="<?php echo $ruta_anterior; ?>">
								<?php echo $gn_arr['titulos']['anterior'][$idioma]; ?>
							</a>
						</div>
					<?php else: ?>
						<div id="anterior" class="inactivo" ><?php echo $gn_arr['titulos']['anterior'][$idioma]; ?></div>
					<?php endif; ?>

					<div id="separador">}</div>

					<?php if(isset($ruta_siguiente)): ?>
						<div id="siguiente">
								<a href="<?php echo $ruta_siguiente; ?>">
								<?php echo $gn_arr['titulos']['siguiente'][$idioma]; ?>
							</a>
						</div>
					<?php else: ?>
						<div id="siguiente" class="inactivo"><?php echo $gn_arr['titulos']['siguiente'][$idioma]; ?></div>
					<?php endif; ?>
				</div>
			</div>

			<script>
				var descriptionText = '<?php echo stripslashes($textos['descripcion-obra']); ?>',
                    reedMoreLabel = '<?php echo stripslashes($gn_arr['titulos']['leer-mas'][$idioma]); ?>';
                    closeLabel = '<?php echo stripslashes($gn_arr['titulos']['cerrar'][$idioma]); ?>';
			</script>
			<script src="js/leer-mas.js"></script>
			<script src="js/proyecto.js"></script>

			<?php if (!empty($galeria) || $galeria != 0 ): ?>
				<script>
					var galeria = <?php echo $galeria;?>;
				</script>

				<script src="js/galeria-videos.js"> </script>
				<script src="js/reproductor.js"></script>
			<?php endif; ?>

			<script src="js/f-box1.js"></script>
		</div>
		<?php require_once('requeridos/footer.php'); ?>
        <div id="fbox-element-container"></div>
	</body>
</html>


