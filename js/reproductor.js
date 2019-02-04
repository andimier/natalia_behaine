
		
	
	window.onload = function(){
		
		var losvideos = document.getElementsByClassName('video-gl');
		var reproductor = document.getElementById('reproductor');
		var cnt_video = document.getElementById('cnt_video');
		
		var cerrar = document.getElementById('cerrar');
		
		var vid_siguiente = document.getElementById('btn-vid-siguiente');
		var vid_anterior = document.getElementById('btn-vid-anterior');
		
		var rep = document.getElementById('rep');
		var cadenarep = rep.src;
		
		var abierto = false;
		
		
		var ratio = 1.77;
		
		window.addEventListener('resize', function(){
			
			IniciarReproductor();
	
		});
		
		
		function IniciarReproductor(){
			
			
			
			if(window.innerWidth > 720){
				
				reproductor.style.width = '720px';
				reproductor.style.height = '407px';
				
				cnt_video.style.width = '720px';
				cnt_video.style.height = '407px';
				
				cerrar.style.width = '50px';
				cerrar.style.height = '50px';
				
				
				rep.style.width = 720 +'px';
				rep.style.height = 407 +'px';
				
			}else{
				
				reproductor.style.width = '85%';
				reproductor.style.height = reproductor.offsetWidth / ratio + 'px';
				
				cnt_video.style.width = '100%';
				cnt_video.style.height = reproductor.offsetWidth / ratio + 'px';
				
				
				
				cerrar.style.width = '35px';
				cerrar.style.height = '35px';
				
				
				// HAY QUE DARLE EL ANCHO AL VIDEO
				// PARA QUE OCUPE TODO EL CONTENDOR 
				rep.style.width = reproductor.offsetWidth +'px';
				rep.style.height = reproductor.offsetWidth / ratio +'px';
				
				
			}
			
		
			
			if(abierto == true){
				reproductor.style.marginRight = - (window.innerWidth /2 )-(reproductor.offsetWidth/2) + 'px'
				reproductor.style.marginTop = - (reproductor.offsetHeight/2) + 'px';
	
			}
			
			reproductor.style.marginTop = - (reproductor.offsetHeight/2) + 'px';

			document.onkeydown = function(e) {
				switch (e.keyCode) {
					case 37:
						//alert('left');
						videoteclas = $('#btn-vid-anterior').attr('video');
						verVideoAnterior(videoteclas);
						break;
					case 39:
						//alert('right');
						videoteclas = $('#btn-vid-siguiente').attr('video');
						verVideoSiguiente(videoteclas);
						break;
				}
				
			};
		}
		
		

		var videoteclas;
		
		var vid_activo;
		var videos_arr = new Array();
		
		var num_siguiente;
		var num_anterior ;
		
		var click_primero = false;
		
		
		// ASIGNAR FUNCION CLICK A LOS VIDEOS
		for(v=0; v<losvideos.length; v++){
			
			// *** ARRAY PARA FUNCIONES ANTERIOR Y SIGUIENTE
			videos_arr.push(losvideos[v].id);
			
			losvideos[v].setAttribute('index', v)
			losvideos[v].addEventListener('click', verVideo, false);
			
		}
		
		console.log('videos_arr = '+videos_arr[0])
		
		
		function verVideo (){
			
			var enlace = this.id;
			vid_activo = this.getAttribute('index');

			if(abierto == false){
				
				$('.video-gl').each(function(){
					$(this).animate({opacity:.7});
				});
				
				
				$('#reproductor').animate({
					marginRight: - (window.innerWidth /2 )-(reproductor.offsetWidth/2) + 'px'
					}, 1500, 
					function(){
						rep.src = 'https://player.vimeo.com/video/'+ enlace;
				});

				abierto = true;
			}else{
				rep.src = '//player.vimeo.com/video/'+ enlace;
			}
			

			$('#mask').css({display:'block'});
			$('#mask').animate({opacity:.5}, 1500);
			
			
			
			// *** PONER VIDEO A LOS BOTONES SIGUIENTE Y ANTERIOR.
	
			vid_anterior.setAttribute('video', Number(vid_activo));
			vid_siguiente.setAttribute('video', Number(vid_activo));
			
		}
		
		
		// *** FUNCIONES PARA LOS BOTONES FLECHAS 
		// SIGUIENTE Y ANTERIOR.
		
		var index_video;

		vid_anterior.addEventListener("click", verVideoAnterior, false);
		vid_siguiente.addEventListener("click", verVideoSiguiente, false);
		
		function verVideoAnterior(video){
			// OBTENER EL INDEX EN EL ARRAY DEL VIDEO ACTIVO
			if(video.type !== 'click'){
				index_video = video;
				index_video = Number(index_video);
			}else{
				index_video = this.getAttribute('video');
				index_video = Number(index_video);
			}
			
	
			if(index_video == 0){
				index_video = videos_arr.length -1;
			}else{
				index_video = index_video - 1;
			}
			
			// CARGAR EL NUEVO VIDEO
			rep.src = '//player.vimeo.com/video/'+ (videos_arr[index_video]);
			
			// PONER EL NUEVO INDEX A AMBOS BOTONES, ANTERIOR Y SIGUIENTE
			vid_anterior.setAttribute('video', index_video);
			vid_siguiente.setAttribute('video', index_video);
		}
		
	
		function verVideoSiguiente(video){
			// OBTENER EL INDEX EN EL ARRAY DEL VIDEO ACTIVO
			console.dir('video = '+video);
			console.log('video = '+video);

			if(video.type !== 'click'){
				index_video = video;
				index_video = Number(index_video);
			}else{
				index_video = this.getAttribute('video');
				index_video = Number(index_video);
			}
			
			if(index_video == videos_arr.length-1 ){
				index_video = 0;
			}else{
				index_video = index_video + 1;
			}
			
			// CARGAR EL NUEVO VIDEO
			rep.src = '//player.vimeo.com/video/'+ (videos_arr[index_video]);
			
			// PONER EL NUEVO INDEX A AMBOS BOTONES, ANTERIOR Y SIGUIENTE
			vid_siguiente.setAttribute('video', index_video);
			vid_anterior.setAttribute('video', index_video);
			
		}
		
		
		
		
		$('#cerrar , #mask').click(function () {
			
			$('#reproductor').animate({marginRight: 800 + 'px'}, function(){
				$('.video-gl').each(function(){
					$(this).animate({opacity:1});
					rep.src = '';
				})
			});
			
			$('#mask').animate({opacity:0}, 1500, function(){
				$(this).css('display','none');
			});
		
			abierto = false;
		});	
		
		
		IniciarReproductor();
		
	}