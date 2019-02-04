<?php  require_once("headers/hdr-albumes.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include_once('includes/tags.php'); ?>
	</head>
	<body>
		<div id="col2">
			<div id="cnt_edicion">
				<h3>ALBUMES</h3>
				<div id="formularioedicion1">

					<h4>Insertar nuevo Álbum</h4>

					Nuevo Titulo:
					<form enctype="multipart/form-data" method="post">
						<input type="hidden" name="tabla"   value="albumes" />
						<input class="borde_puntos letra_azul" type="text"   name="titulo"  value="" size="50" maxlength="50"/>
						<br />

						<input type="submit" name="insertar_album" class="insertar_contenido fondo_negro" value="insertar álbum"/>
					</form>
					<br />

					<div class="mensaje"><?php echo $mensaje2 . '<br /><br />'; ?></div>

					<!-- //// FILTROS //// -->
					<div id="cnt_filtros">
						Filtrar por:
						<br>
						<br>

						<a class="btn_filtro filtro2 fondo_gris2" href='albumes.php?fecha=1'>fecha</a>
						<a class="btn_filtro filtro3 fondo_gris2" href='albumes.php?proyecto=1'>proyecto</a>
						<a class="btn_filtro filtro3 fondo_gris2" href='albumes.php?bitacora=1'>bitácora</a>
					</div>

					<div class="mensaje"><?php echo $mensaje_filtro; ?></div>
					<br>
					<br>

					<strong>Haz click sobre el titulo del álbum para editarlo.</strong>

					<ul>
                        <?php for($i = 0; $i < count($albums); $i++): ?>
                            <a href="<?php echo $albums[$i]['albumUrlLink']; ?>">
                                <li>
									<div class="list-title"><?php echo $albums[$i]["albumTitle"]; ?><div>
                                    <div class="list-parent-title">Del contenido: <?php echo $albums[$i]["albumParentContentTitle"]; ?><div>
                                </li>
                            </a>
                        <?php endfor; ?>
					</ul>
					<br />
				</div>
			</div>
		</div>
		<div id="footer"></div>
		<?php include_once('includes/cabezote.php'); ?>
		<?php include_once('includes/navegacion.php'); ?>
	</body>
</html>
<?php if (isset($connection)) { mysql_close($connection); } ?>
