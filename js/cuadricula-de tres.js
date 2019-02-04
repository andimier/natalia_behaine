<script>
				var ratioV = 1.77;
				var video = document.getElementsByClassName('video');
				
				
				
				window.addEventListener('resize', AjustarInicio,false);
				
				
				function AjustarInicio(){
					
					video[0].style.height = video[0].offsetWidth / ratioV + 'px';

					
					hf1 = tarjetas1[referencia1].offsetHeight;
					hf2 = tarjetas2[referencia2].offsetHeight;
				
					for( y = 0; y < tarjetas1.length; y++){
						if(y !== referencia1 ){
							tarjetas1[y].style.height = hf1 + 'px';
						}
					}
					
					for( z = 0; z < tarjetas2.length; z++){
						if(z !== referencia2 ){
							tarjetas2[z].style.height = hf2 + 'px';
						}
					}
					
					///////////
					if(foto.length >= 1){
						margen = $('.foto').first().css('margin-left');
					
						margenF = margen.replace('px', '');
						
						for( f = 0; f < foto.length; f++ ){
							foto[f].style.height = foto[0].offsetWidth + 'px';
						}
						
						$('.foto').each(function(){
							$(this).css({ marginTop : margenF *2 +'px'})
						});
					}
					
					///////////
	
					if(window.innerWidth > 800 ){
						tarjeta_prg[0].style.height = tarjeta_prg[0].offsetWidth / ratioT + 'px';
						img_prg[0].style.height = img_prg[0].offsetWidth / ratioP + 'px';
						
						var altura = img_prg[0].style.height ;
						console.log(altura)
						
						cnt_txt_prg[0].style.height = altura;
						txt_prg[0].style.height = altura;
					}else{
						tarjeta_prg[0].style.height = 'auto';
						img_prg[0].style.height = img_prg[0].offsetWidth / ratioP2 + 'px';
						
						cnt_txt_prg[0].style.height = 'auto';
						txt_prg[0].style.height = 'auto';
					}
					
					
				}
				
				
			
				
				
				var tarjetas1 = document.getElementsByClassName('tarjeta2');
				var tarjetas2 = document.getElementsByClassName('tarjeta2A');
				var array1 = [];
				var array2 = [];
	
				var hf1;
				var hf2;
				
				for( i=0; i < tarjetas1.length; i++){
					array1.push(tarjetas1[i].offsetHeight);
				}
				
				for( a=0; a<tarjetas2.length; a++){
					array2.push(tarjetas2[a].offsetHeight);
				}
				
				
				var referencia1 = array1.indexOf(Math.max.apply(Math, array1));
				var referencia2 = array2.indexOf(Math.max.apply(Math, array2));
				
				
				hf1 = tarjetas1[referencia1].offsetHeight;
				hf2 = tarjetas2[referencia2].offsetHeight;
				
				
				
				///////////////
				
				var foto = document.getElementsByClassName('foto');
				
				if(foto.length >= 1){
					
					var margen = $('.foto').first().css('margin-left');
					
					//var cosa = margen.replace(/[^-\d\.]/g, '');
					var margenF = margen.replace('px', '');
					
					for( f = 0; f < foto.length; f++ ){
						foto[f].style.height = foto[0].offsetWidth + 'px';
					}
					
					$('.foto').each(function(){
						$(this).css({ marginTop : margenF *2 +'px'})
					});
				}
				
				
				
				/////////////
				
				
				var img_prg = document.getElementsByClassName('img_prg');
				var tarjeta_prg = document.getElementsByClassName('tarjeta_prg');
				var cnt_txt_prg = document.getElementsByClassName('cnt_txt_prg');
				var txt_prg = document.getElementsByClassName('txt_prg');
				
				
				var ratioT = 2.28;
				var ratioP = 1.38;
				var ratioP2 = 1.5;
			
				
				AjustarInicio();
				
				
				/////////////////
				
				
				
				
				<?php if(mysql_num_rows($r_publicaciones) >= 1): ?>
				<div class="tt_seccion"><h1>Publicaciones</h1></div>
				<?php echo $expo['titulo']; ?>
				<?php while($pub =  mysql_fetch_array($r_publicaciones)): ?>
					<div class="tarjeta3">
		
						<div class="txt_tarjeta3">
							<h1 class="tt1"><?php echo $expo['titulo']; ?></h1>
							<p><?php echo $expo['contenido']; ?></p>
						</div>
						<div class="vacio"></div>
						
					</div>
				<?php endwhile; ?>
			<?php endif; ?>