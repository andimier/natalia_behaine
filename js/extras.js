	
	
	var tt_seccion = document.getElementsByClassName('tt_flotante');
	var t3 = document.getElementsByClassName('tarjeta3');
	var cnt_tarjeta = document.getElementsByClassName('cnt-tarjeta3');
	
	
	for(t=0; t<tt_seccion.length; t++){
		// LISTENERS
		tt_seccion[t].style.cursor = 'pointer';
		tt_seccion[t].addEventListener('click', AbrirSeccion, false);
		
		tt_seccion[t].addEventListener('mouseover', function(){
			$(this).stop().animate({color:'red'});
		},false);
		
		tt_seccion[t].addEventListener('mouseout', function(){
			$(this).stop().animate({color:'black'});
		},false);
	}
	
	
	// CAPTURAR LA ALTURA DE LOS CONTENEDORES DE TEXTO
	for(x=0; x<cnt_tarjeta.length; x++){
		cnt_tarjeta[x].setAttribute('altura', t3[x].offsetHeight);
		
	}
	
	// CAPTURAR LA ALTURA DE LOS CONTENEDORES DE TEXTO
	window.onresize = function(){
		//console.log('hola');
		for(x=0; x<cnt_tarjeta.length; x++){
			cnt_tarjeta[x].setAttribute('altura', t3[x].offsetHeight);
			//console.log(cnt_tarjeta[x].getAttribute('altura'))
		}
		
		
	} 
	
	
	function AbrirSeccion(){
		
		var contenido = this.getAttribute('contenido');
		
		for(z = 0; z < cnt_tarjeta.length; z++){
		
			if(cnt_tarjeta[z].getAttribute('contenido') == contenido){
				
				if(cnt_tarjeta[z].offsetHeight < 1){
					$(cnt_tarjeta[z]).animate({height:cnt_tarjeta[z].getAttribute('altura')+'px'}, function(){
						// CAMBIAR A AUTO PARA QUE SE AJUSTE EL ALTO ONRESIZE
						$(this).css({height:'auto'});
					});
				}else{
					$(cnt_tarjeta[z]).stop().animate({height:'0px'});
				}
			}else{
				$(cnt_tarjeta[z]).stop().animate({height:'0px'});
			}

		}
	}