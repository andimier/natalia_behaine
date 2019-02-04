// PLAYLIST
				//
				var btn_mando = document.getElementById('mando');
				var tt_cancion = document.getElementById('tt_media');
				
			
				var audioPlayer = document.createElement('audio');
				var numero = 0;
				
				
				var	cancion = tt_cancion.getAttribute('src');
				
				var iniciando = true;
				
				
				function Rep(){
				
					audioPlayer.id = 'player';
					audioPlayer.src = cancion;
					
					
					document.body.appendChild(audioPlayer);
					audioPlayer.play();
		
				}
				
	
				
				
				audioPlayer.addEventListener('ended', function() {
				
					if(numero > canciones.length-2){
						audioPlayer.parentNode.removeChild(audioPlayer);
						//console.log('termino');
					}else{
						numero += 1;
						Rep();
					}
					
				}, false);
				
				/*
				ff.addEventListener('click', function(){
					
					if(numero < canciones.length-1){
						numero += 1;
						btn_mando.className = 'pausa';
						Rep();
					}else{
						numero = 0;
						btn_mando.className = 'pausa';
						Rep();
					}
				},false)
				*/
				
				
				btn_mando.addEventListener('click', function() {
					
					if(btn_mando.className == 'play' && iniciando == true){
						
						audioPlayer.id = 'player';
						audioPlayer.src = cancion;
						
						document.body.appendChild(audioPlayer);
						
						audioPlayer.play();
						
						btn_mando.className = 'pausa';
						iniciando = false;
						
					}else if( audioPlayer.paused ){
						audioPlayer.play();
						btn_mando.className = 'pausa';
					}else{
						
						audioPlayer.pause();
						btn_mando.className = 'play';
					}
				}, false);
				
				