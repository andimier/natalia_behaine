	
	
	var fbox = document.getElementsByClassName("fbox");
	

	
	// PONERLE EL ALTO DE LA IMAGEN A LA MASCARA NEGRA PARA LOS THUMBS DE LOS EXTRAS
	var thumb = document.getElementsByClassName("thumb1");
	var mkthumb = document.getElementsByClassName("th-mask");
	
	for(h=0; h<thumb.length; h++){
		
		mkthumb[h].style.height = thumb[0].offsetWidth + 'px';
		mkthumb[h].style.width  = thumb[0].offsetWidth + 'px';
		
		console.log(thumb[h].offsetWidth + '-' + thumb[h].offsetHeight );
	}
	
	window.onresize = function(){
		for(h=0; h<thumb.length; h++){
			
			mkthumb[h].style.height = thumb[0].offsetWidth + 'px';
			mkthumb[h].style.width  = thumb[0].offsetWidth + 'px';
		}
	}
	
	
	// LISTENERS PARA CLICK Y HOVER
	for(x=0; x < fbox.length; x++){
		fbox[x].addEventListener('click', DisplayImagen, false);
		fbox[x].addEventListener('mouseover', fboxOpacidadIn, false);
		fbox[x].addEventListener('mouseout',  fboxOpacidadOut, false);
	}
	
	function fboxOpacidadIn(){
		$(this.children[0]).animate({opacity:0.5});
	}
	
	function fboxOpacidadOut(){
		$(this.children[0]).animate({opacity:1});
	}
	
	
	
	function DisplayImagen(e){
		
		e.preventDefault();
		
		
		//var texto = 'HTML Audio/Video DOM loadedmetadata Event - W3Schools www.w3schools.com/.../av_event_ loadedmetadata .as Traducir esta página audio|video.onloadedmetadata = function(){myScript};Try it. In JavaScript, using the addEventListener() method: audio |video. addEventListener ("loadedmetadata"  ...';
		//var texto = 'HTML Audio/Video DOM loadedmetadata Event - W3Schools www.w3schools.com/.  .Listener("loadedmetadata"  ...';
		
		//var idimgactiva = this.children[0].id;
		//var imgactiva = document.getElementById(idimgactiva);
		//var lasrc= imgactiva.src;
		var lasrc = this.href;
		var texto = this.getAttribute('texto');
		
		//PANTALLA
		var pantalla = document.createElement('div');
		pantalla.id = 'fbox-pantalla';
		pantalla.style.position = 'fixed';
		pantalla.style.top = 0;
		pantalla.id = 'pantalla';
		pantalla.style.width = '100%';
		pantalla.style.height = '100%';
		pantalla.style.backgroundColor = 'black';
		pantalla.style.opacity = .8;
		pantalla.style.cursor = 'pointer';

		
		//CONTENEDOR TODO
		var fbox_foto = document.createElement("div");
		fbox_foto.style.position = 'fixed';
		fbox_foto.id = 'fbox-foto';
		fbox_foto.height = 'auto';
		fbox_foto.style.top = '50%';
		fbox_foto.style.left = '50%';
		fbox_foto.style.opacity = 0;
		//fbox_foto.style.backgroundColor = 'red';
		
		
		// CNT FOTO
		var fbox_cntfoto = document.createElement("div");
		fbox_cntfoto.id = 'fbox-cnt-foto';
		fbox_cntfoto.style.position = 'relative';
		fbox_cntfoto.style.width = '100%';
		fbox_cntfoto.style.height = 'auto';
		fbox_cntfoto.style.backgroundColor = 'black';
		
		// TEXTO
		var fbox_texto = document.createElement("div");
		fbox_texto.id = 'fbox-texto';
		fbox_texto.style.width = '96%';
		fbox_texto.style.height = 'auto';
		fbox_texto.style.padding = '15px 2% 15px 2%';
		fbox_texto.style.textAlign = 'center';
		//fbox_texto.style.backgroundColor = 'black';
		
		fbox_texto.style.fontFamily = 'Arial';
		fbox_texto.style.fontSize = '13px';
		fbox_texto.style.fontWeight = 100;
		fbox_texto.style.color = 'white';
		//fbox_texto.style.opacity = '.7';
		
		var eltexto = document.createTextNode(texto);
		fbox_texto.appendChild(eltexto);
		
		// LA IMAGEN
		var fbox_img = document.createElement("img");
		fbox_img.id = 'fbox-img';
		fbox_img.src = lasrc;
		fbox_img.style.position = 'relative';
		//fbox_img.style.opacity = '.5';
		
		// BOTON CERRAR.
		var fbox_cerrar = document.createElement("div");
		fbox_cerrar.style.position = 'absolute';
		fbox_cerrar.style.width = '50px';
		fbox_cerrar.style.height = '50px';
		fbox_cerrar.style.top = '-55px';
		fbox_cerrar.style.right = '0';
		//fbox_cerrar.style.backgroundColor = 'blue';
		fbox_cerrar.style.cursor = 'pointer';
		fbox_cerrar.style.backgroundImage = 'url("imagenes/cerrar.png")';
		fbox_cerrar.style.backgroundSize = '100%';
		
		if(window.innerWidth < 600 ){
			fbox_cerrar.style.width = '40px';
			fbox_cerrar.style.height = '40px';
			fbox_cerrar.style.top = '-50px';
		}else{
			fbox_cerrar.style.width = '50px';
			fbox_cerrar.style.height = '50px';
			fbox_cerrar.style.top = '-60px';
		}
		
		
		// APPEND ELEMENTOS
		document.body.appendChild(pantalla);
		fbox_foto.appendChild(fbox_cerrar);
		fbox_foto.appendChild(fbox_img);
		document.body.appendChild(fbox_foto);
		
		
		
		
		fbox_img.addEventListener('load', function(){
			
			//console.log('cargado')
			//console.log('dimensiones w ='+window.innerWidth + 'x' +  window.innerHeight)
			//console.log('dimensiones='+this.width + 'x' +  this.height)
			
			var alturainicial = this.height;
			var anchoinicial = this.width;
			
			if(this.height > window.innerHeight){
				
				if(window.innerWidth < 450){
					var ratio = (window.innerHeight-170) / this.height;
				}else{
					
					var distancia = window.innerHeight - this.height;
				
					if(distancia < 100){
						//console.log('777')
						var ratio = (window.innerHeight-200) / this.height;
					}else{
						var ratio = (window.innerHeight-100) / this.height;
					}
					
				}
				
				var ancho = this.width;
				var alto  = this.height;
				
				this.height = alto * ratio;
				this.width  = ancho * ratio;
				
				fbox_foto.style.width = this.width + 'px';
				console.log('alto 1')
				
				
				
			}else{
				
				var distancia = window.innerHeight - this.height;
				
				if(distancia < 100 ){
					//alert('aqui')
					if(window.innerWidth < 450){
						var ratio = (window.innerHeight-150) / this.height;
					}else{
						var ratio = (window.innerHeight-250) / this.height;
					}
					var ancho = this.width;
					var alto  = this.height;
					
					this.height = alto * ratio;
					this.width  = ancho * ratio;
					
					fbox_foto.style.width = this.width + 'px';
					
					console.log('3.2')
				
				}else{
					fbox_foto.style.width = this.width + 'px';
				}
				
				
				console.log('3')
			}

			
			if( this.width > window.innerWidth){
				
				if(window.innerWidth < 450){
					var ratio = (window.innerWidth-70) / this.width;
				}else{
					var ratio = (window.innerWidth-150) / this.width;
				}
				
				var ancho = this.width;
				var alto  = this.height;
				
				this.height = alto * ratio;
				this.width  = ancho * ratio;
				
				fbox_foto.style.width = this.width + 'px';
				console.log('2')
				
			}
			
			//console.log('window.innerWidth = '+window.innerWidth)
			
			
			var altofinal = this.height;
			var anchofinal = this.width;
			// PONER ALTO EN = AUTO
			fbox_foto.style.height = 'auto';
			
			// REDUCCION DEL TAMAÑO DEL TEXTO
			
			if(fbox_texto){
				
				var w_ventana = window.innerWidth;
				var h_ventana = window.innerHeight;
				
				if(w_ventana < 700 && w_ventana > 500){
					fbox_texto.style.fontSize = '12px';
				}else if(w_ventana < 501){
					fbox_texto.style.fontSize = '11px';
				}
				
				if(h_ventana < 500){
					fbox_texto.style.fontSize = '11px';
				}
				

				
				// CENTRAR LA IMAGEN
				fbox_foto.style.marginTop = -(fbox_foto.offsetHeight / 2) + 'px';
				fbox_foto.style.marginLeft = -(fbox_foto.offsetWidth / 2) + 'px';
				
				
				// ANIMACION ENTRADA DE IMAGEN
				$(fbox_foto).animate({opacity:1}, 1000, function(){
					// CERRAR FOTO LISTENERS
					fbox_cerrar.addEventListener('click', CerrarFoto, false);
					pantalla.addEventListener('click', CerrarFoto, false);
				});
				
				
				
				// RESIZE
				var number = 0;
				var rw = window.innerWidth / anchofinal;
				var ri = anchofinal / altofinal;
				
				window.addEventListener('resize', function(){
			
					var ancho = fbox_img.width.width;
					
					fbox_img.width  = window.innerWidth / rw;
					fbox_img.height = fbox_img.width / ri;
					
					fbox_foto.style.width = fbox_img.width + 'px';
					
					// CENTRAR LA IMAGEN
					fbox_foto.style.marginTop = -(fbox_foto.offsetHeight / 2) + 'px';
					fbox_foto.style.marginLeft = -(fbox_foto.offsetWidth / 2) + 'px';
					
					if(window.innerWidth < 600 ){
						fbox_cerrar.style.width = '40px';
						fbox_cerrar.style.height = '40px';
						fbox_cerrar.style.top = '-50px';
					}else{
						fbox_cerrar.style.width = '50px';
						fbox_cerrar.style.height = '50px';
						fbox_cerrar.style.top = '-60px';
					}
					
					
				}, false);

			}
			
			
			
			
		}, false);
		
		
		// CERRAR
		function CerrarFoto(){
			$(fbox_foto).animate({opacity:0}, 1000, function(){
				document.body.removeChild(fbox_foto);
				document.body.removeChild(pantalla);
			});
		}

		
		// ADJUNTAR AL DIV EL CONTENEDOR DEL TEXTO
		fbox_foto.appendChild(fbox_texto);
		

		

	}
	
	

	
	

	
	
	