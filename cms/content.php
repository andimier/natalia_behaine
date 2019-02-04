<?php 

	require_once("includes/sesion.php");
	require_once("includes/connection.php");
	require_once("includes/functions.php");
	
	encontrar_seccion_y_contenido_seleccionados();


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">


	<head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>DIEGO ZAMORA</title>

		

		<script type="text/javascript">
	
		</script>
		<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
		<script type="text/javascript" src="edicion/editortexto.js"></script>


	</head>
	
	

	<body>

		<div id="cabezote"></div>

		<div id="contenedor">

			<div class="col1">
				
				<div class="etiquetalogout">
					<a href="logout.php" onclick="return confirm('estas a punto de cerrar sesion, se perderan los cambios que no hayas guardado!')">CERRAR SESIÓN</a>
				</div>
				
				<br />
				
				<div id="sitioyusuario">
					WWW.CONTEMPORABALLET.COM<br />
					Usuario: <?php echo $_SESSION['username']; ?>
				</div>
				
				<br />
				<br />
				
				
				<div class="secciones">
					
					<?php navegacion($seccion_seleccionada, $contenido_seleccionado)?><br />
				
				</div>
			
			</div>


		</div>
		
		
		<br />
		<br />
		

		<div id="footer"></div>
		
		
	</body>
	
</html>


<?php 
	if(isset($connection)){
		mysql_close($connection);
	}
?>


