<?php 
	require_once("includes/sesion.php");
	require_once("utils/phpfunctions.php");
	include_once('headers/hdr-editar-contenido.php'); 
?>

<!DOCTYPE html">
<html>
	<head>
		<?php include_once('includes/tags.php'); ?>
	</head>
	<body>
		<div id="col2">
			<div id="cnt_edicion">
				<a href="editar-seccion.php?seccion=<?php echo $contenido_seleccionado['seccion_id']; ?>">VOLVER A LA SECCIÓN</a>
				<br>
				<br>

				Editar Contenido: <?php echo $contenido_seleccionado['titulo'] . ' / ' . $fecha; ?>
				<br />
				<br />

				<?php echo $mensaje; ?>

				<?php if (!empty($imagenprincipal)): ?>
					<div id="col3" >
						<?php require_once('edicion/edc_imagenes/img_principal.php'); ?>
					</div>
				<?php endif; ?>

				<!-- CAMPOS GENERALES TITULO FECHA	BOTON COMPRA -->
				<div style="clear:both">
					<form enctype="multipart/form-data" name="formularioedicion1" id="formularioedicion1" method="post">
						<input type="hidden" name="id" value="<?php echo $id;?>"/>
						<input type="hidden" name="tabla"  value="<?php echo $tabla;?>"/>

						<?php
							echo ($seccion == 2 || $seccion == 8) ? $texto_titulo : '' ;
						?>
						<input type="text" name="titulo" id="titulo" value="<?php echo htmlentities(stripslashes($titulo)); ?>" size="50" maxlength="50" />
						<input type="text" name="fecha"  id="fecha"  value="<?php echo $fecha; ?>"  size="50" maxlength="50" />
						<br>

						<!-- //// BOTON ACTIVAR COMPRA DE OBRA //// -->
						<?php if ($seccion == 3): ?>
							<input type="checkbox" name="compra" value="activado" <?php echo ($compra == 1) ? 'checked' : '';?>> Activar botón de compra
							<br>
						<?php endif; ?>

						<input type="submit" name="boton1" class="boton1" value="Guardar" />
					</form>
				</div>

                <ul class="container">
                    <li>
                        <a href="<?php echo $contentTextLinkAndButtonText[0]; ?>" >
                            <?php echo $contentTextLinkAndButtonText[1]; ?>
                        </a>
                    </li>

                    <?php if ($seccion == 3): ?>
                        <li>
                            <a href="<?php echo $technicalDescriptionLinkAndButtonText[0]; ?>" >
                                <?php echo $technicalDescriptionLinkAndButtonText[1]; ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php while($sub = phpMethods('fetch', $r_sub)): ?>
                        <li>
                            <a href="editar-subcontenido.php?contenido_id=<?php echo $sub['id']; ?>" >
                                <?php echo $sub['titulo']; ?>
                            </a>
                        </li>
                    <?php endwhile; ?>

                    <?php if ($contenido_seleccionado['seccion_id'] == 3 || $contenido_seleccionado['seccion_id'] == 4):?>
                        <!-- AUDIO y VIDEO -->
                        <a href="editar-extras.php?contenido_id=<?php echo $contenido_seleccionado['id']; ?>">
                            <li class="extra">Editar Audio / Video</li>
                        </a>

                        <!-- GALERIA INSTALACION -->
                        <?php if (!empty($installationTitle)): ?>
                            <a href="editar-album.php?album_id=<?php echo $installationId; ?>&tipo=instalacion" >
                                <li>
                                    <div class="list-title">Editar Galería de Videos:</div>
                                    <div class="list-parent-title"><?php echo $installationTitle; ?></div>
                                </li>
                            </a>
                        <?php else: ?>
                            <a href="edicion/create-installation-gallery.php?contentId=<?php echo $contenido_seleccionado['id']; ?>&contentTitle=<?php echo $contenido_seleccionado['titulo']; ?>">
                                <li>
                                    <div class="list-parent-title">Crear Galería de Videos</div>
                                </li>
                            </a>
                        <?php endif; ?>

                    <?php endif; ?>

                    <?php if (!empty($mainAlbumTitle)): ?>
                        <a href="editar-album.php?album_id=<?php echo $mainAlbumId; ?>" >
                            <li>Editar Álbum: <?php echo $mainAlbumTitle; ?></li>
                        </a>
                    <?php endif; ?>
                </ul>
				<!-- //// FORMULARIO DE EDICION	SE OCULTA EL CAMPO DE TEXTO EN	FORMULARIOEDICIO //// -->
				<?php if ($seccion == 3 || $seccion ==4): ?>
					<?php if ( $filas > 0 ): ?>
						<div id="cnt_albumesconteido">
							<br />
							<br />

							Seleciona el que quieres que aparezca en la seccion de este fotografo.
							<br />
							<br />

							<form enctype="multipart/form-data" method="post">
								<input type="hidden" name="kontenido_id" value="<?php echo $contenido_seleccionado['id']; ?>" />

								<?php while ($albumcontenido = phpMethods('fetch', $r_albumescontenido)): ?>
									<div class="albumcontenido">
										<input type="radio" name="visible" value="<?php echo $albumcontenido['id']; ?>" <?php if ($albumcontenido['visible'] == 1) { echo 'checked'; } ?> />
										<?php echo $albumcontenido['titulo']; ?>
									</div>
								<?php endwhile; ?>
								<br />
								<input type="submit" name="btn_veralbumes" class="boton1" value="Guardar" />
							</form>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<br>
				<br>
				<br>

				<!-- //// FORMULARIO ELIMINAR DEL CONTENIDO //// -->
				<?php
					if ($borrable == 1){
						echo '<div id="col4" >';
						require_once("edicion/frm-eliminar1.php");
						echo '</div>';
					}
				?>
			</div>
		</div>
		<div id="footer"></div>
		<?php include_once('includes/cabezote.php'); ?>
		<?php include_once('includes/navegacion.php'); ?>
	</body>
</html>
<?php if (isset($connection)) { phpMethods('close', $connection); } ?>
