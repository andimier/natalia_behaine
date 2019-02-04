	
	
	var thumbs = document.getElementById('thumbs');

	var hThumb;

	var vimeoUserName = 'andimier';
	//var vimeoUserName = 'user4428348';
	
	var videosCallback = 'showThumbs';
	var videosUrl = 'http://vimeo.com/api/v2/album/'+galeria+ + vimeoUserName + '/videos.json?callback=' + videosCallback;
	

	
	var head = document.getElementsByTagName('head').item(0);
	
	var videosJs = document.createElement('script');
	videosJs.setAttribute('type', 'text/javascript');
	videosJs.setAttribute('src', videosUrl);
	head.appendChild(videosJs);
	

	function showThumbs(videos) {

		
		thumbs.innerHTML = '';

		
		for (var i = 0; i < videos.length; i++) {
			
			
			// DIV VIDEOS
			var div_videos = document.createElement('div');
			div_videos.style.position = 'relative';
			div_videos.className = 'video-gl';
			
			div_videos.style.width='33.33%';
			div_videos.style.height = 200 + 'px';
			
			div_videos.style.overflow = 'hidden';
			div_videos.style.cursor = 'pointer';
			div_videos.style.backgroundColor = 'black';

			
			
			// IMAGEN DEL VIDEO
			var thumb = document.createElement('img');
			var wThumb = thumb.offsetHeight;
			
			thumb.setAttribute('src', videos[i].thumbnail_large);
			thumb.setAttribute('alt', videos[i].title);
			thumb.style.width='180%';
			thumb.style.marginLeft = '-20%'

			
			//var titulo = document.createElement('div');
			//titulo.className = 'tt_video';
			//titulo.style.position = 'absolute';
			//titulo.style.top = '50%';
			//titulo.style.left = '0px';
			//titulo.style.width = 100+'px';
			//titulo.style.height = 200+'px';
		
			
			
			var urlvideo = videos[i].url;
			var numvideo = urlvideo.split("/");
			var num = numvideo[3];
			
			var enlace = 'video.php?video='+num;
			
			//titulo.innerHTML = '<a href="video.php?video=' + num + '">' + videos[i].title + '</a>';
			
			var a = document.createElement('a')
			//a.setAttribute('href', enlace);
			
			
			div_videos.setAttribute('id', num);
			
			
			var mascara = document.createElement('div');
			mascara.className = 'mascaras';
			mascara.style.position = 'absolute';
			mascara.style.top = '0';
			mascara.style.left = '0px';
			mascara.style.width = '100%';
			mascara.style.backgroundColor = 'black';
			

			div_videos.appendChild(thumb);
			a.appendChild(mascara);
			div_videos.appendChild(a);
			//div_videos.appendChild(titulo);

			var wLi = div_videos.offsetWidth;
			
			
			thumbs.appendChild(div_videos);
			
			
			//titulo.style.height = hThumb+'px';
			hThumb = thumb.offsetHeight;
			
			
			
		}
		

		var divs = document.getElementsByClassName('video-gl');
		//console.log(divs[0].offsetWidth)
		//var titulos = document.getElementsByClassName('tt_video');
		var mascaras = document.getElementsByClassName('mascaras');
		
		
		
		/////
		var wThumbs = thumbs.offsetWidth;
		var sumaVideos = divs[0].offsetWidth * videos.length;
		var resultado = sumaVideos / wThumbs;
		
		var filas = Math.ceil(resultado);
		
		
		/////
		var hPorciento = divs[0].offsetHeight * 0.005;
		//console.log(hPorciento);
		
		var margen = $('.video-gl').first().css('margin-left');
		var margenF = margen.replace('px', '');
		//console.log(margen);
		
		window.addEventListener('resize', AjustarVideos1);
		
		function AjustarVideos1(){
			InicioVideos1();
		}
		
		function InicioVideos1(){
			
			for (var b = 0; b < videos.length; b++) {
				
				if(window.innerWidth < 700){
					divs[b].style.width = '50%';
				}else{
					divs[b].style.width = '33.33%';
				}
			
				//titulos[b].style.height = 30+'px';
				//titulos[b].style.width = '100%';
				
				divs[b].style.height = divs[0].offsetWidth + 'px';
				
				divs[b].style.marginTop = margenF + 'px';
				divs[b].style.marginBottom = margenF + 'px';
				
				var altoVideo = divs[0].offsetHeight;
				mascaras[b].style.height = altoVideo + 'px';

				
			}
			
			
			var cnt_videos = document.getElementsByClassName('cnt-videos');
			
			var multiplicador;
			var divior;
			var multiplo;
			var u = 0;
			
			function alturaCntVideos(multiplo){
				
				cnt_videos[0].style.height = ( divs[0].offsetWidth * multiplo ) / divisor + 'px';
				thumbs.style.height = ( divs[0].offsetWidth * multiplo) / divisor + 'px';
				
				
				// SUMARLE AL CNT VIDEOS LA DIFERENCIA EN ALTURA CON THUMBS
				x = cnt_videos[0].offsetHeight - thumbs.offsetHeight;
				console.log(x)
				cnt_videos[0].style.height = cnt_videos[0].offsetHeight + x + 'px';
			}
			
			
			function hayarMultiplo(multiplo){
				// AVERIGUAR SI LA CANTIDAD DE VIDEOS ES UN NUMERO MULTIPLO DE 3,
				// DE LO CONTRARIO, SUMERLE 1
				console.log(u)
				console.log(multiplo)
				x = multiplo / 3;
				y = Math.round(x);
				z = x-y;
				
				if(z==0){
					// SI ES MULTIPLO DE 3, ENVIAR A FUNCION PONER ALTURA
					alturaCntVideos(multiplo);
				}else{
					multiplo = multiplo + 1;
					u++;
					hayarMultiplo(multiplo);
				}
	
			}
			

			// SI LA VENTANA ES MAYOR DE 699 LA FILA DE VIDEOS TIENE 3 ELEMENTOS
			if(window.innerWidth < 700) {
				divisor = 2;
				(divs.length%2 == 0) ? multiplicador=divs.length : multiplicador=divs.length+1;
				alturaCntVideos(multiplicador);
			}else{
				divisor = 3;
				multiplo = hayarMultiplo(divs.length);
			}

		}
		
		InicioVideos1();

	}
	
	
	


	
	
	
	

	