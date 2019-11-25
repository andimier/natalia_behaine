	var ratioV = 1.77;
	var ratioT = 2.28;

	var img_prg = document.getElementsByClassName('img_prg');
	var laImagen = document.getElementsByClassName('prg-img');
	var tarjeta_prg = document.getElementsByClassName('tarjeta_prg');
	var cnt_txt_prg = document.getElementsByClassName('cnt_txt_prg');
	var txt_prg = document.getElementsByClassName('txt_prg');
	var ratios_arr = new Array();

	function CargarInicio(){
		for( t = 0; t < tarjeta_prg.length; t++){

			ratios_arr.push(laImagen[t].naturalWidth / laImagen[t].naturalHeight)

			if(window.innerWidth > 800){
				cnt_txt_prg[t].style.height = img_prg[t].offsetWidth / ratios_arr[t] + 'px';
			}
			else if (window.innerWidth < 801 && window.innerWidth > 480) {
				cnt_txt_prg[t].style.height = 80 + 'px';
			}
			else {
				cnt_txt_prg[t].style.height = 50 + 'px';
			}
		}
	}

	// window.addEventListener('resize', AjustarInicio,false);
	// window.addEventListener('load', CargarInicio,false);

	//AjustarInicio();