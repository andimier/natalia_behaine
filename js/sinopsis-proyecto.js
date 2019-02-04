				
				var sinopsis = document.getElementById('txt1');
				var texto ='<?php echo $textos[0] ?>';
			    var res = texto.substr(0, 220);
				sinopsis.innerHTML = res;