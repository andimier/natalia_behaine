<?php 
	
	require_once('requeridos/conexion/connection.php');
	
	$seccion = 6;

	if(isset($_GET['lang'])){
		$idioma = $_GET['lang'];
	}else{
		$idioma = 0;
	}
	
	$hijo = false;

	require_once('requeridos/qs.php');
		
	
	if( $idioma == 0){
		
		$tag_titulo  =  'Natalia Behaine';
		$titulo_seccion= 'Inicio';
		
		$seccion_url1 ='english/contact.php';
		$seccion_url2 ='francais/contact.php';
		
		
		$seccion_url = '';
		$ruta = '';
		
	}else if($idioma == 1){
		$tag_titulo  =  'Natalia Behaine';
		$titulo_seccion= 'Home';
		
		$seccion_url1 ='../contacto.php';
		$seccion_url2 ='../francais/contact.php';
		
		$seccion_url = '';
		$ruta = '../';
	}else{
		$tag_titulo  =  'Natalia Behaine';
		$seccion_url1 ='../contacto.php';
		$seccion_url2 ='../english/contact.php';
		$ruta = '../';
	}
	

	
	
	if(isset($_POST['total'])){
		
		//$seccion = $_GET['seccion'];
		
		$total = $_POST['total'];
		$nombre = $_POST['nombre'];
		
		$body  = "<html>";
		$body .= "<body>";
		$body .= "<strong>ORDEN DE COMPRA</strong>";
		$body .= "<br />";
		$body .= "<br />";
		$body .= "<strong>Nombre:</strong>" . $_POST['nombre'] . "<br />";
		$body .= "<strong>Correo:</strong>" . $_POST['correo'] . "";
		$body .= "<br /><br />";
		
		$body .= "<strong>Pedido:</strong><br />";
		
		for($i = 0; $i < $total; $i++){
			$body .= $_POST[$i+1] . '<br>';
		}
		//$body .= "<strong>Mensaje:</strong> $mensaje";
		$body .= "</body>";
		$body .= "</html>";
		
		$message = "Tus datos han sido enviados correctamente!";

		$headers  = "From: <" . $_POST['correo'] . ">\r\n";
		$headers .= "X-Mailer: PHP/" .phpversion(). "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
		
		//$to = "nataliabehaine@gmail.com";
		//$to = "andimier@gmail.com";
		$to = "nataliabehaine@gmail.com, andimier@gmail.com";
		$subject = "Web Info Contacto";

		
		//echo $body;
		mail($to, $subject, $body, $headers);
		header('Location: orden.php?usuario='.$nombre);
	
		
	}else{
		$nombre = $_GET['usuario'];
	}

?>


<!doctype html>
<html>
	<head>

		<?php include( $ruta.'requeridos/tags.php'); ?>

	</head>

	<body>
		
		<?php include( $ruta.'requeridos/cabezote1.php'); ?>
		
		<div id="cuerpo">

			<div id="cnt_contacto">
	
				<div id="orden">
					<h2>
					Muchas gracias por tu pedido <?php echo $nombre; ?> <br>
					En el menor tiempo posible estaremos enviándote un correo con los detalles.
					</h2>
				</div>
				
				
				<!--
				<div id="redes2">
					<a href="<?php //echo $redes[0]; ?>" target="_blank" ><div class="red fb" ></div></a>
					<a href="<?php //echo $redes[1]; ?>" target="_blank" ><div class="red in" ></div></a>
				</div>
	-->
				
			</div>

			
		</div>
		<?php require_once($ruta.'requeridos/footer.php'); ?>
	</body>
</html>

