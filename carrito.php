<?php 
	session_start();
	
	require_once('requeridos/conexion/connection.php');

	$seccion = 8;
	
	
	
	
	
	if(isset($_GET['lang'])){
		$idioma = $_GET['lang'];
	}else{
		$idioma = 0;
	}
	
	// CARRITO
	require_once('requeridos/carrito.php');
	
	require_once('requeridos/qs.php');
	require_once('requeridos/elementos-arr.php');

?>


<!doctype html>
<html>
	<head>
		
		<?php require_once('requeridos/tags.php'); ?>
		
		<link href="estilos/proyectos-gr2.css" type="text/css" rel="stylesheet"  media="screen"/>
		<link href="estilos/proyectos-md.css"  rel="stylesheet" type="text/css"  media="only screen and (min-width:481px) and (max-width:800px)"  />
		<link href="estilos/proyectos-pq.css"  rel="stylesheet" type="text/css"  media="only screen and (min-width:50px) and (max-width:480px)"  />
		
		<?php include('requeridos/tags-galeria.php'); ?>
		
	</head>

	<body>
		
		<?php require_once('requeridos/cabezote1.php'); ?>
		
		<div id="cuerpo">
			
			
			<h2 id="tt-pedido"><?php echo ucfirst($gn_arr["titulos"]["items-en-el-pedido"][$idioma]); ?></h2>
			<div class="vaciar-carrito"><a href="carrito.php?cmd=vaciarcarrito"><?php echo $gn_arr["titulos"]["vaciar-carrito"][$idioma]; ?></a> </div>
			
			<br>
			<br>
			<br>
			<script>
			
				function mensajeVacio(){
					
					var pantalla = document.createElement('div');
					pantalla.id = 'pantalla';
					pantalla.style.position = 'fixed';
					pantalla.style.width = window.innerWidth + 'px';
					pantalla.style.height = window.innerHeight + 'px';
					pantalla.style.top = 0;
					pantalla.style.left = 0;
					pantalla.style.backgroundColor = 'black';
					pantalla.style.opacity = 0.5;
					
					
					// ESTILOS DE VACIO EN EL CSS
					var vacio = document.createElement('div');
					vacio.id = 'carrito-vacio';
					var texto = '<?php echo $gn_arr["titulos"]["carrito-vacio"][$idioma]; ?>';
					//console.log(texto);
					
					var t = document.createTextNode(texto);
					vacio.appendChild(t);
					
					document.body.appendChild(pantalla);
					document.body.appendChild(vacio);
					//alert('hola vacio')
					
					
				
					var timex ;
					timex = setTimeout(cerrarAviso, 1000);
					
					function cerrarAviso(){
						
						$('#pantalla').animate({opacity:0}, function(){
							document.body.removeChild(pantalla);
							document.body.removeChild(vacio);
						});
					}
				}
				
				
				
			</script>
			<?php 
				
				if( !isset($_SESSION['carrito_arr']) || count($_SESSION['carrito_arr']) < 1 ){
					echo '<script>mensajeVacio(); </script>';
					$i=0;
				}else{
					
					$i=0;
					
					foreach( $_SESSION['carrito_arr'] as $cada_item){
						
						$x = $i + 1;
						
						echo '<div class="item">';
							echo '<h3>Item No. ' . $x . '</h3>';
							//echo '<div class="item-id">' . $cada_item['item_id'] . '</div>';
							
							// IMAGEN DEL PROYECTO
							//echo $ruta . $cada_item['imagen'];
							echo '<div class="item-img"><img src="cms/'.$cada_item['imagen'] .'" /></div>';
							
							
							
							// DATOS DEL PROYECTO
							echo '<div class="item-datos">';
							
								echo  ucfirst($gn_arr["titulos"]["nombre-de-la-obra"][$idioma]) . ':';
								echo '<div class="item-tt">'  . $cada_item['titulo'] . '</div>';
								
								// CAMBIAR LA CANTIDAD 
								// Envío x js
								echo '<form id="frm-cantidad" method="post" action="carrito.php">';
									echo '<input type="hidden" name="link-carrito" value="'. $gn_arr["url-lang"][$seccion][$idioma] . '" />';
									echo '<input class="item-cantidad"type="text"   name="cantidad" value="' . $cada_item['cantidad'] . '" size="1"  />';
									echo '<input type="hidden" name="item"     value="' . $cada_item['item_id'] .'" class="item-id"/>';
									echo '<input type="submit" name="btn-cambio-cantidad" value="'.$gn_arr['titulos']['cambiar'][$idioma].'" class="btn-cambio-cantidad" />';
								echo '</form>';
								
								// BOTON ELIMINAR ELEMENTO DEL PEDIDO
								echo '<div class="eliminar-item">';
									echo '<form method="post" action="carrito.php">';
										echo '<input type="hidden" name="link-carrito" value="'. $gn_arr["url-lang"][$seccion][$idioma] . '" />';
										echo '<input type="hidden" name="quitar_index" value="' . $i . '" />';
										echo '<input type="submit" name="btn_quitar' .$i. '" value="' . $gn_arr["titulos"]["eliminar"][$idioma] . '" id="btn-quitar-obra"/>';
										
									echo '</form>';
								echo '</div>';
								
							echo '</div>';
	
	
	
	
						echo '</div>';
						
						/*
						while( list($key, $value) = each($cada_item)){
							echo $key .': '. $value . '<br>';
						}*/
						
						$i++;
						
					}

				}
			?>
			<div class="vaciar-carrito">
				<a href="carrito.php?cmd=vaciarcarrito">
					<?php echo $gn_arr["titulos"]["vaciar-carrito"][$idioma]; ?>
				</a> 
			</div>
			
			
			
			<!-- ===============FORMULARIO PARA ENVIAR EL PEDIDO COMPLETO ==========-->
			
			<div id="frm-pedido">
			<?php echo '<h2>' . ucfirst($gn_arr["titulos"]["obras-seleccionadas"][$idioma]) .': ' . $i . '</h2>'; ?>
			<br>
			<br>
			<?php if(!empty($_SESSION['carrito_arr'])) :?> 
			
				<form enctype="multipart/form-data" id="frm-carrito" method="post" action="orden.php" onsubmit="return validarFormulario()" autocomplete="on">
					
					<input type="text"   name="nombre" id="frm-nombre" placeholder="Nombre" />
					<br>
					<br>
				
					<input type="email" name="correo" placeholder="e-mail" id="frm-correo" autocomplete="off" />
					<br>
					<br>
					<input type="submit" id="btn-enviar-carrito" class="boton1" onClick="javascript:submit_form();" value="<?php echo $gn_arr["titulos"]["enviar"][$idioma] . ' ' . $gn_arr["titulos"]["pedido"][$idioma]; ?>" />
				</form>
			
			<?php endif; ?>
			</div>
			<script>
				
			
				var elFormulario = document.getElementById("frm-carrito");
				
				var items = document.getElementsByClassName('item');
				var it_titulo = document.getElementsByClassName('item-tt');
				var it_id = document.getElementsByClassName('item-id');
				var it_cantidad = document.getElementsByClassName('item-cantidad');
				
				var btn_actualizar = document.getElementById("btn-enviar-carrito");
				
			
				for(f=0; f < items.length; f++){
					
					var input = document.createElement("input");
					input.type = 'hidden';
					input.name = f+1; 
					input.value = 'Proyecto: ' + it_titulo[f].textContent + ' / cantidad: ' + it_cantidad[f].value; 
					elFormulario.appendChild(input);
					
				}
				
				if(elFormulario){
					var input2 = document.createElement("input");
					input2.type = 'hidden';
					input2.name = 'total'; 
					input2.value = items.length; 
					elFormulario.appendChild(input2);
				}
				

				
				//function submit_form(){
				//	
				//	elFormulario.submit();
				//}
				
				
			</script>
			
			<script>
				
				var frm_cantidad = document.getElementById("frm-cantidad");
				
				function cambioCantidad (){
					
					frm_cantidad.submit();
				}
			</script>
			
			
			<script>
				function validarFormulario(){
					
		
					var email = document.forms["frm-carrito"]["correo"].value;
					var atpos  = email.indexOf("@");
					var dotpos = email.lastIndexOf(".");
					
					var x = document.forms["frm-carrito"]["nombre"].value; 
					var y = document.forms["frm-carrito"]["correo"].value; 
					//var z = document.forms["formulario"]["mensaje"].value;
				
					
					if (atpos<1 || dotpos < atpos+2 || dotpos+2 >= email.length){
					  alert( "El correo que ingresaste no es valido o está vacío" );
					  return false;
					}//else if ( z == null || z == ""){
						//alert("Por favor escribe un correo electrónico");
						//return false;
					//}
					
					if ( x == null || x == "" ){
					  alert("Por favor escribe tu nombre");
					  return false;
					}else if ( y == null || y == "" ){
						alert("Por favor escribe un teléfono");
						return false;
					}
				}
				
				mensajeVacio();
				
				
			</script>
			
			
			
			<br>
			
			
		
		</div>
		<?php require_once('requeridos/footer.php'); ?>
	</body>
</html>


