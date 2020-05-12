<?php 
	require_once("headers/hdr-login.php"); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include_once('includes/tags.php'); ?>
	</head>
	<body>
		<div id="pagina">
			<div id="cnt_login">

				<div id="mensaje_login">
					<?php 
						echo $mensaje;
						echo $mensaje4;
						echo $mensaje1;
						echo $mensaje2;
						echo $mensaje3;
					?>
				</div>

				<form id="frm-login" action="login.php" method="post">
					<label for="campo_usuario" id="labe">Nombre de Usuario</label>
					<input type="text" name="usuario" id="campo_usuario"  />
					<label for="password" id="label">Tu Contraseña</label>
					<input type="password" name="contrasena" id="password" maxlength="50" />
					<br />
					<br />
					<br />

					<input type="submit" name="submit" class="boton_entrar fondo_verde" value="Ingresar" />
				</form>
			</div>
		</div>
		<div id="cabezote"></div>
	</body>
</html>
<?php if(isset($connection)) { phpMethods('close', $connection); } ?>
