<?php
require_once("includes/connection.php");
require_once("includes/functions.php");

$mensaje = "";
$mensaje2 = "";

	if(isset($_POST['submit'])){
		$errores = array();
		$required_fields = array('username','password');
		//$errores = array_merge($errores, $required_fields);
		//$errores = array_merge($errores, check_required_fields($required_fields, $_POST));
		foreach($required_fields as $fieldname){
			if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname])  && !is_numeric($_POST[$fieldname]))){
				$errores[] = $fieldname;	
			}
		}
	
		$username = trim(mysql_prep($_POST['username']));	
		$password = trim(mysql_prep($_POST['password']));	
		//algoritmos de incriptacion
		//$hashed_password = md5($password);
		//$hashed_password = hash($password);
		$hashed_password = sha1($password);
	
		
		if(empty($errores)){
			$query = "INSERT INTO usuarios (username, hashed_password) VALUES ('{$username}','{$hashed_password}')";
			$result = mysql_query($query, $connection);
			
			if($result){
				 $mensaje = "El usuario fué creado correctamente! <br /> <a href=\"content.php\"><h1>Comenzar</h1></a>";	
			}else{
				 $mensaje = "No se creó el usuario!"	;
				 $mensaje .="<br />" . mysql_error();
			}
		}else{
			if(count($errores) ==1){
				 $mensaje = "Hubo un error en el formulario.";
			}else{
				 $mensaje = "Hubo " . count($errores) . " errores en el formulario.";
				 $mensaje = mysql_error();
			}
			 foreach($errores as $error){
				 $mensaje2 = "Por favor ingrese los siguientes campos: - " . $error . "<br/>";
			}
		}
	}else{
		$username = "";	
		$password = "";	
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Plataforma de Contenidos</title>

<link rel="Stylesheet" type="text/css" href="estilos/estilos.css" />
</head>

<body>


<div id="cabezote"><h2>ADMINISTRADOR DE CONTENIDOS</h2></div>

<div id="contenedor">

<div class="col1">
<h3>Bienvenido</h3>
<h3>Para crear un usuario: </h3>
<h2>Por favor ingresa los <br />
datos del nuevo <br />
administrador!</h2>
</div>

<div class="col2">

<h2>Crear Usuario</h2>
<h4><?php echo $mensaje; ?></h4>
<h4><?php echo $mensaje2; ?></h4>
-------------------------------------------------------------------------------------------------------
      

<form action="nuevo_usuario.php" method="post">
<h3>
<table><tr>
<td>Nombre de Usuario (username):&nbsp;</td><td><input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username);?>"/></td>
</tr>
<tr>
<td>Contraseña (password): &nbsp;</td><td><input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password)?>" /></td>
</tr>
<tr>
<td height="70"><input type="submit" name="submit" value="Crear Usuario" />
</td></tr>
</table></h3>
</form>

</div>
</div>

        
<?php require("includes/footer.php");?>
			