	
	
	
	function crearDivsX3(imagen, alt, contenedor, divisor, resize){
		
		console.log(divisor); 
		
		if(divisor==1){
			valor1 = 'auto';
			valor2 = 'none';
		}else{
			ancho = contenedor.offsetWidth / divisor;
			ratio = 1280 / 720;
			alto = ancho / ratio;
			valor1 = alto + 'px';
			valor2 = 'left';
		}
		
		if(resize==true){
			
			imagen.parentNode.parentNode.parentNode.style.width  = (contenedor.offsetWidth / divisor) + 'px';
			imagen.parentNode.parentNode.parentNode.style.height = valor1;
			imagen.parentNode.parentNode.parentNode.style.float  = valor2;

		}else{
			var divcntimg = document.createElement('DIV');
			divcntimg.style.width  = (contenedor.offsetWidth / divisor) + 'px';
			divcntimg.style.height = valor1;
			divcntimg.style.float  = valor2;
			divcntimg.style.overflow  = 'hidden';
			divcntimg.className = 'imagen';
			
			var cntimg = document.createElement('DIV');
			cntimg.style.width  = '100%';
			cntimg.style.height = '100%';
			
			var a = document.createElement('A');
			
			if (imagen.indexOf("pequenas") != -1 ){
				a.setAttribute('href', imagen.replace('pequenas','grandes'));
			}else{
				a.setAttribute('href', imagen);
			}
			
			a.setAttribute('data-fancybox-group', 'gallery');
			a.setAttribute('title', alt);

			var img = document.createElement('IMG');
			img.className = "img-grupo";
			img.src = imagen;
			img.alt = alt;
			
			
			a.appendChild(img);
			cntimg.appendChild(a);
			divcntimg.appendChild(cntimg);
			contenedor.appendChild(divcntimg);
		}

	}
	
	
	
	function asignarFuncion(multiplo, espar, imagenes, alt_arr, contenedor, resize){
		

		for(b=0;b<imagenes.length;b++){
				
			if(espar==true){
				if(multiplo==true){
					// SI ES MULTIPLO DE 3, ENVIAR A FUNCION PONER ALTURA
					crearDivsX3(imagenes[b], alt_arr[b], contenedor,3,resize);
				}else{
					crearDivsX3(imagenes[b], alt_arr[b], contenedor,2,resize);
				}
			}else{
				if(multiplo==true){
					// SI ES MULTIPLO DE 3, ENVIAR A FUNCION PONER ALTURA
					crearDivsX3(imagenes[b], alt_arr[b], contenedor,3,resize);
				}else{

					if(imagenes.length > 2){
						
						if(b<imagenes.length-1){
							crearDivsX3(imagenes[b], alt_arr[b], contenedor,2,resize);
						}else{
							crearDivsX3(imagenes[b], alt_arr[b], contenedor,1,resize);
						}

					}else{
						if(imagenes.length==2){
							// hay dos imágenes	
							crearDivsX3(imagenes[b], alt_arr[b], contenedor,2,resize);
						}else{
							crearDivsX3(imagenes[b], alt_arr[b], contenedor,1,resize);
						}
						
					}
				}
			}
			
			if(resize == false){
				if(b==imagenes.length-1){
					var vacio = document.createElement('DIV');
					vacio.className = 'vacio';
					contenedor.appendChild(vacio);
				}
			}
		}
		
	}
	
	function hayarPar(numero){
		//console.log(numero);
		x = numero / 2;
		cadena = x.toString();
		y = cadena.indexOf('.');
		
		(y==-1) ? par = true : par = false;
		return par;
	}
	
	
	function hayarMultiplo(multiplo){
		// AVERIGUAR SI LA CANTIDAD DE VIDEOS ES UN NUMERO MULTIPLO DE 3,
		// DE LO CONTRARIO, SUMERLE 1
		x = multiplo / 3;
		y = Math.round(x);
		z = x-y;
		
		if(z==0){
			// SI ES MULTIPLO DE 3, ENVIAR A FUNCION PONER ALTURA
			esmultiplo = true;
		}else{
			esmultiplo = false;
		}
		
		return esmultiplo;

	}
	
	
	// UBICAR LA IMAGEN DEL BANNER EN EL CENTRO
	function dimImagen(imagen, banner){
	
		var img = new Image();
		img.src = imagen.src;
		
		img.onload = function(){
			
			ratio = this.width / this.height;
			nuevah = window.innerWidth / ratio;
			imagen.style.marginTop = - (nuevah / 2) + 'px';
			
			if(window.innerWidth > 1100){
				banner.style.height = '350px';
			}else{
				// LA ALTURA DEL BANNER SERÁ LA MISMA QUE LA NUEVA ALTURA DE LA IMAGEN / 2 - 15px
				banner.style.height = (((nuevah)/2)-15) + 'px';
			}
		}
	}
	
	function dimImgGrupo(imagen, valor){
		
		//console.log('ENTRANDO = ' +imagen.parentNode.parentNode.parentNode.parentNode.className);
		//console.log('ENTRANDO = ' +imagen.parentNode.parentNode.parentNode.parentNode.children[1].className);
		hijosdelpadre = imagen.parentNode.parentNode.parentNode.parentNode.children;
		
		// SI LA CANTIDAD DE HIJOS DE "comercial-cnt-imagenes" ES MAYOR DE 2
		// "imgen" y "vacio", PONER MARGIN TOP,
		// DE LO CONTRARIO NO!!
		// LO QUE QUIERE DECIR QUE SOLO HAY UNA FOTO EN ESTE TRABAJO
		
		if(hijosdelpadre.length > 2 ){
			
			var img = new Image();
			img.src = imagen.src;

			img.onload = function(){
				
				ratio = this.width / this.height;
				//console.log(this.width);
				//console.log(this.height);
				//console.log(ratio);
				//console.log('nueva h = ' + imagen.offsetWidth / ratio);
				
				nuevah = imagen.offsetWidth / ratio;
				imagen.style.marginTop = -(nuevah / 2) + 'px';
				
			}
		}
		
	}
	
	function inicio(resize){
		

		for(i=0;i<cm_tarjeta.length;i++){
			
			//console.dir(cm_tarjeta[i].children[4].children);
			
			var contenedor = cm_tarjeta[i].children[4];
			contenedor.style.width  = cm_tarjeta.offsetWidth + 'px';
			contenedor.style.height = 'auto';
			
			var imagenes = new Array();
			var alt_arr  = new Array();
			
			if(resize==false){
				for(a=0;a<cm_tarjeta[i].children[3].children.length;a++){
					imagenes.push(cm_tarjeta[i].children[3].children[a].src);
					alt_arr.push(cm_tarjeta[i].children[3].children[a].alt);
					//console.log(cm_tarjeta[i].children[3].children[a].alt);
				}
			}else{
				var lasimagenes = cm_tarjeta[i].getElementsByClassName('imagen');
				for(a=0;a<lasimagenes.length;a++){
					imagenes.push(lasimagenes[a].querySelector("img"));
				}
				//console.log(cm_tarjeta[i].children[4].children);
				//console.log(cm_tarjeta[i].children[4].children.length);
				//
				//for(a=0;a<cm_tarjeta[i].children[4].children.length;a++){
				//	imagenes.push(cm_tarjeta[i].children[4].children[0].children[0].children[0].children[a]);
				//}
			}

			esmultiplo = hayarMultiplo(imagenes.length);
			espar = hayarPar(imagenes.length);
			
			asignarFuncion(esmultiplo, espar, imagenes, alt_arr, contenedor, resize);
		}
		
		// DIMENSIONES DEL BANNER Y MARGEN DE LA IMAGEN
		dimImagen(imagen_banner, comercial_banner);
		
		for(i=0;i<img_grupo.length;i++){
			dimImgGrupo(img_grupo[i], i);
		}
		
	}
	
	
	var comercial_banner = document.getElementById('comercial-banner');
	var imagen_banner = document.getElementById('comercial-img-banner').querySelector('img');
	var img_grupo = document.getElementsByClassName('img-grupo');
	var cm_tarjeta = document.getElementsByClassName('comercial-tarjeta');
	
	

	inicio(rezise=false);

	window.onresize = function(){
		inicio(rezise=true);
		
	}
	
	window.onload = function(){
		// DIMENSIONES DEL BANNER Y MARGEN DE LA IMAGEN
		dimImagen(imagen_banner, comercial_banner);

		for(i=0;i<img_grupo.length;i++){
			dimImgGrupo(img_grupo[i], i);
		}
	
	}
	
	function buscarPadre(padre){
		
		a = padre.parentNode;

		if(a.className=='comercial-tarjeta'){
			b = a;
		}else{
			buscarPadre(a);
		}
		return b;
		
	}
	
	
	document.onclick = function(e){
		
		//e.preventDefault();
		console.dir(e.target.tagName);
		
		if(e.target.tagName == 'IMG'){
			
			elpadre = e.target.parentNode.parentNode.parentNode
			
			if(e.target.parentNode.nodeName == 'A'){
				
				e.target.parentNode.setAttribute('class', 'fancybox');
				
				var padre = buscarPadre(e.target);
				if(padre !== ''){
					var imagenes_galeria = padre.getElementsByTagName('A');
					
					for(i=0;i<imagenes_galeria.length;i++){
						imagenes_galeria[i].setAttribute('class', 'fancybox');
					}
				}
			}
		}else{
			var losfancy = document.getElementsByTagName('A');
			for(i=0;i<losfancy.length;i++){
				losfancy[i].removeAttribute('class', 'fancybox');
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	