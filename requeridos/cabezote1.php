	<div id="cabezote">
		<div id="logo">
			<a alt="Natalia Behaine - Artista Visual" href="./">
				<img src="imagenes/logo-natalia-behaine.png" />
			</a>
		</div>

		<div id="foto">
			<a href="./">
				<img src="cms/<?php echo $imgInicio; ?>" />
			</a>
		</div>

		<div id="menu">
			<div id="btn_menu">Menú</div>

			<div id="contenedor_enlaces">
                <?php for($i = 0; $i < count($gn_arr['secciones']); $i++ ): ?>
                    <?php if($i != 3): ?>
                        <div class="enlaces1">
                            <?php if($i == 0): ?>
                                <a class="link" href="./">
                            <?php else: ?>
                                <a class="link" href="<?php echo $gn_arr['url-lang'][$i][$idioma]; ?>">
                            <?php endif; ?>
                                    <?php echo $gn_arr['secciones'][$i][$idioma]; ?>
                                </a>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>

                <div id="cnt_idiomas">
                    <?php
                        $link_es = isset($title_es) ? $title_es : '';
                        $link_en = isset($title_en) ? $title_en : '';
                    ?>

                    <a href="<?php echo $gn_arr['url-lang'][$seccion][0] . $link_es; ?>">Español</a> /
                    <a href="<?php echo $gn_arr['url-lang'][$seccion][1] . $link_en ?>">English</a>
                </div>

                <div id="redes1">
                    <a href="<?php echo $redes[0]; ?>" target="_blank" ><div class="red1 fb"></div></a>
                    <a href="<?php echo $redes[1]; ?>" target="_blank" ><div class="red1 in"></div></a>
                </div>
			</div>
		</div>

		<script>
			var textoboton = 'Menú',
				abierto = 'false',
				link = document.getElementsByClassName('link'),
				seccion = '<?php echo $seccion; ?>',
				activo;

			$('#btn_menu').click(function(){
				$('#contenedor_enlaces').slideToggle(function(){
					if ($('#contenedor_enlaces').css('display') === 'none') {
						$('#btn_menu').text('<?php echo $gn_arr['titulos']['menu'][$idioma]; ?>');
                        $('#btn_menu').removeClass('abierto');
					} else {
						$('#btn_menu').text('<?php echo $gn_arr['titulos']['cerrar'][$idioma]; ?>');
                        $('#btn_menu').addClass('abierto');
					}
				});
			});

			// COLOR DE SECCION ACTIVA EN MENÚ
			if (link[seccion]) {
				activo = link[seccion].style.color="#33ffff";
			}
		</script>
	</div>
