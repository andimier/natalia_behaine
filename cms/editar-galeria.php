<?php require_once("headers/hdr-editar-galeria.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include_once('includes/tags.php'); ?>
	</head>

	<body>
		<div id="col2">
			<div id="cnt_edicion">
				<div class="imagenes">

					<?php echo $mensaje; ?>

					Imágenes del Album: <?php echo $titulo; ?>
					<br>
					<br>

					<!-- INSERTAR  IMAGEN -->
                    <div class="form-container">
                        <form enctype="multipart/form-data" action="edicion\edc_imagenes\imgbanners_insertar.php" method="post">
                            <input type="hidden" name="tabla" value="<?php echo $tabla; ?>" />
                            <input type="hidden" name="campo" value="<?php echo $campo; ?>" />
                            <input type="hidden" name="campo_id" value="<?php echo $campo_id; ?>" />
                            <input type="hidden" name="album" value="<?php echo $_GET['album']; ?>" />

                            <?php
                                if (isset($_GET['tipo']))
                                    echo '<input type="hidden" name="type" value="' . $_GET['tipo'] . '" />';
                            ?>

                            <div id="fileUpload">
                                <input id="btn_foto" type="button" value="escoge una imagen" class="mascara">
                                <input id="foto"  type="file" name="nombre_archivo" class="upload" onchange="myFunction(this.value)" >
                            </div>
                        

                            <p id='nm_imagen'></p>
                            <input id="bsubirimg" type="submit" name="insertar_imagen" value="" class="fondo_negro"/>
                        </form>
                    </div>

                    <!-- INSERTAR IMAGEN O VIDEO EN GALERÍA INSTALACIÓN-->
                    <?php if ($isInstallation): ?>
                        <div class="form-container">
                            <form enctype="multipart/form-data"  action="edicion\edc_imagenes\imgbanners_insertar.php" method="post">
                                <input type="hidden" name="albumId" value="<?php echo $album_id; ?>" />
                                <input type="hidden" name="album" value="<?php echo $_GET['album']; ?>" />
                                <?php
                                    if (isset($_GET['tipo']))
                                        echo '<input type="hidden" name="type" value="' . $_GET['tipo'] . '" />';
                                ?>

                                <label>Video</label>
                                <input id="btn_foto" name="videoKey" type="text" value="">

                                <input type="submit" name="insertVideo" value="Insertar video" class="fondo_negro"/>
                            </form>
                        </div>
                    <?php endif; ?>

					<script>
						function myFunction(val) {
							$("#nm_imagen").text(val);
							$("#bsubirimg").css('display', 'block');
						};
					</script>
					<br />
					<br />

					<div class="mensaje1"> <?php echo $msj_nueva_imagen; ?></div>

					<!-- TODAS LAS IMAGENES DEL ALBUM -->
                    <div class="form-container">
                        <form enctype="multipart/form-data" method="post" id="formulario_galeria" action="edicion/edc_imagenes/imgbanners_guardar_eliminar.php">
                            <input type="submit" name="btn_guardar" value="guardar cambios" class="btn_guardar fondo_verde" onclick="return confirm('Confirmas actualizar y/o borrar imagenes');"/>
                            <input type="hidden" name="album_id" value="<?php echo $_GET['album_id'];?>" />
                            <input type="hidden" name="album" value="<?php echo $_GET['album'];?>" />

                            <?php while($imagen = mysql_fetch_array($album)): ?>
                                <?php
                                    $explotarnombre = explode('/', $imagen['imagen1']);
                                    $nombrearchivo = $explotarnombre[2];
                                ?>

                                <div class="cnt_thumbs" style="height:<?php echo $altura; ?>">
                                    <div class="cnt_posicion" style="display:<?php echo $display; ?>">
                                        <input type="text" name="posicion[]" class="posicion" value="<?php echo $imagen['posicion']; ?>" />
                                    </div>

                                    <div class="cnt_imagen">
                                        <a id="<?php echo $imagen['id'];?>" posicion="<?php echo $imagen['posicion'];?>" href="editar-imagen.php?id=<?php echo $imagen['id'];?>">
                                            <img src="<?php echo $imagen['imagen1']; ?>"  />
                                            <div class="nombre_imagen"><?php echo $nombrearchivo; ?> </div>
                                        </a>
                                    </div>

                                    <input type="hidden" name="tabla" value="<?php echo $tabla; ?>" />
                                    <input type="hidden" name="id[]" value="<?php echo $imagen['id'];?>" />

                                    <div class="check_eliminar">
                                        Eliminar
                                        <input type="checkbox" class="check" name="eliminar[]" value="<?php echo $imagen['id'];?>" />
                                    </div>
                                </div>
                            <?php endwhile; ?>
                            <br />
                        </form>
                    </div>
				</div>
			</div>
		</div>

		<div id="footer"></div>

		<?php include_once('includes/cabezote.php'); ?>
		<?php include_once('includes/navegacion.php'); ?>
		<script src="js/general.js" type="text/javascript"></script>
	</body>
</html>

<?php
	if(isset($connection)){
		mysql_close($connection);
	}
?>