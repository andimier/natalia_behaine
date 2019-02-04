	var ratioV = 1.77;
	var ratioT = 2.28;
	
	var img_prg = document.getElementsByClassName('img_prg');
	var laImagen = document.getElementsByClassName('prg-img');
	
	var tarjeta_prg = document.getElementsByClassName('tarjeta_prg');
	
	var cnt_txt_prg = document.getElementsByClassName('cnt_txt_prg');
	var txt_prg = document.getElementsByClassName('txt_prg');
	
	
	
	var ratios_arr = new Array();
	
	window.addEventListener('load', CargarInicio,false);
	
	
	function CargarInicio(){

		for( t = 0; t < tarjeta_prg.length; t++){
			
			ratios_arr.push(laImagen[t].naturalWidth / laImagen[t].naturalHeight)
			
			if(window.innerWidth > 800 ){
				cnt_txt_prg[t].style.height = img_prg[t].offsetWidth / ratios_arr[t] + 'px';
		
			}else if(window.innerWidth < 801 && window.innerWidth > 480){
				cnt_txt_prg[t].style.height = 80 + 'px';
			}else{
				cnt_txt_prg[t].style.height = 50 + 'px';
			}
		}
		
	}	
	
	
	window.addEventListener('resize', AjustarInicio,false);
	
	function AjustarInicio(){

		for( t = 0; t < tarjeta_prg.length; t++){

			if(window.innerWidth > 800 ){
				cnt_txt_prg[t].style.height = img_prg[t].offsetWidth / ratios_arr[t] + 'px';
		
			}else if(window.innerWidth < 801 && window.innerWidth > 480){
				cnt_txt_prg[t].style.height = 80 + 'px';
			}else{
				cnt_txt_prg[t].style.height = 50 + 'px';
			}
		}
		/*
		if(window.innerWidth > 800 ){
			
			for( t = 0; t < tarjeta_prg.length; t++){
				
				tarjeta_prg[t].style.height = tarjeta_prg[0].offsetWidth / ratioT + 'px';
				img_prg[t].style.height     = img_prg[0].offsetWidth / ratioP + 'px';
				cnt_txt_prg[t].style.height = img_prg[0].offsetWidth / ratioP + 'px';
				txt_prg[t].style.height     = img_prg[0].offsetWidth / ratioP + 'px';
				img_prg[0].style.height = img_prg[0].offsetWidth / ratioP + 'px';
			
				var altura = img_prg[0].style.height ;
				
				cnt_txt_prg[0].style.height = altura;
				txt_prg[0].style.height = altura;
				
				
			}
			
		}else{
			
			for( t = 0; t < tarjeta_prg.length; t++){
				tarjeta_prg[t].style.height = 'auto';
				img_prg[t].style.height     = img_prg[0].offsetWidth / ratioP2 + 'px';
				
				cnt_txt_prg[t].style.height = 'auto';
				txt_prg[t].style.height     = 'auto';
			}
		}
		*/
	
	}
	
	
	
	
	
	
	
	/*
	var ratioP = 1.38;
	var ratioP2 = 1.5;
	
	
	var textos = [];
	
	
	var txt = document.getElementsByClassName('txt');
		
	<?php foreach($arr_textos as $key => $val){ ?>
		textos.push('<?php echo $val; ?>');
	<?php } ?>
	
	for(t=0; t<txt.length; t++){
		txt[t].innerHTML = textos[t].substr(0, 230);
	}
	*/
	AjustarInicio();