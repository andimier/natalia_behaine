	
	
	var menuarr = [
			{
				titulo:'¿qué es andimier? | servicios', 
				link:'quienes-somos', 
				fondo:'#666',
				color: '#ffffff'
			},
			{
				titulo:'diseño gráfico', 
				link:'diseno-grafico', 
				fondo:'#a8dce4',
				color: '#ffffff'
			},
				{
				titulo:'video & motion graphics',     
				link:'video-y-motion-graphics',         			 
				fondo:'#fc4b4b', 
				color: '#eeeeee'
			},	
			{
				titulo:'web',            
				link:'web',  			 
				fondo:'#eeeeee',
				color: '#ff0000'
			},
				
			{
				titulo:'dibujo',         
				link:'dibujo',         			 
				fondo:'#999',        
				color: '#fff'
			}
			
			
		];
		
		
		var menu = document.getElementById('menu-inicio');
		//
		
		
		for(i=0; i<menuarr.length; i++){
		
			var area = document.createElement('div');
			area.className = 'areas';
			
			var h1 = document.createElement('H1');
			var txtenlace = document.createTextNode(menuarr[i].titulo);
			
			h1.appendChild(txtenlace);
			area.appendChild(h1);
			menu.appendChild(area);
	
		}
		
		var areas = document.getElementsByClassName('areas');
		
		for(a=0; a<areas.length; a++){
			
			areas[a].addEventListener('click', function(){
				
				var index = $(this).index();
				window.location.href = menuarr[index].link
	
			});
			
			areas[a].addEventListener('mouseover', function(){
				
				var index = $(this).index();
				this.style.backgroundColor = menuarr[index].fondo;
				this.children[0].style.color = menuarr[index].color;
				
			});
			
			areas[a].addEventListener('mouseout', function(){
				
				this.style.backgroundColor = '';
				this.children[0].style.color = '#868482';
				
			});
		}
			