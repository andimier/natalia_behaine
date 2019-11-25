<?php
	$tt = !isset($tt) ? '' : $tt;
	$num_gal = isset($_GET['g']) ? $_GET['g'] : '';

	$gn_arr = array(
		'idiomas' => array(
			0 => array( 0 => 'español', 1 => 'spanish', 2 => 'español', 'abrev' => ''),
			1 => array( 0 => 'inglés',  1 => 'english', 2 => 'español', 'abrev' => 'en'),
			2 => array( 0 => 'francés', 1 => 'french',  2 => 'français', 'abrev' => 'fr')
		),

        'ubicacion' => array(
            0 => array( 0 => 'Bogotá, Colombia', 1 => 'Bogota, Colombia')
        ),

		'secciones' => array(
			0 => array( 0 => 'Inicio',    1 => 'Home',     2 => 'Home'),
			1 => array( 0 => 'Bio',       1 => 'Bio',      2 => 'Bio'),
			2 => array( 0 => 'Obra', 1 => 'Artwork',  2 => 'Projets'),
			3 => array( 0 => 'Bitácora',  1 => 'Binacle' , 2 => 'Habitacle'),
			4 => array( 0 => 'Contacto',  1 => 'Contact' , 2 => 'contact')
		),

		'url' => array(
			0 => array( 0 => 'inicio',    1 => 'home',     2 => 'home'),
			1 => array( 0 => 'bio',       1 => 'bio',      2 => 'bio'),
			2 => array( 0 => 'proyectos', 1 => 'projects', 2 => 'projets'),
			3 => array( 0 => 'bitacora',  1 => 'binacle' , 2 => 'habitacle'),
			4 => array( 0 => 'contacto',  1 => 'contact' , 2 => 'contact'),
			5 => array( 0 => 'proyecto',  1 => 'project',  2 => 'pojet'),
			6 => array( 0 => 'galeria',   1 => 'gallery',  2 => 'galerie'),
			7 => array( 0 => 'bitacora',  1 => 'binacle',  2 => 'habitacle'),
			8 => array( 0 => 'carrito',   1 => 'cart',     2 => 'panier')
		),

		'url-lang' => array(
			0 => array( 0 => '',    1 => 'en/',         2 => 'fr/'),
			1 => array( 0 => 'bio',       1 => 'en/bio',      2 => 'fr/bio'),
			2 => array( 0 => 'proyectos', 1 => 'en/projects',  2 => 'fr/projets'),
			3 => array( 0 => 'bitacora',  1 => 'en/binacle',  2 => 'fr/habitacle'),
			4 => array( 0 => 'contacto',  1 => 'en/contact',  2 => 'fr/contact'),

			5 => array(
				0 => 'proyecto/'  . $tt = str_replace(' ', '-', $tt),
				1 => 'en/project/'. $tt = str_replace(' ', '-', $tt),
				2 => 'fr/projet/' . $tt
			),

			6 => array(
				0 => 'galeria-' . $num_gal,
				1 => 'en/gallery-' . $num_gal,
				2 => 'fr/galerie-' . $num_gal
			),

			7 => array(
				0 => 'bitacora/'    . $tt = str_replace(' ', '-', $tt),
				1 => 'en/bitacora/' . $tt = str_replace(' ', '-', $tt),
				2 => 'fr/bitacora/' . $tt = str_replace(' ', '-', $tt)
			),

			8 => array(
				0 => 'comercial/',
				1 => 'en/commercial/',
				2 => 'fr/commercial/'
			),

			9 => array(
				0 => 'carrito/',
				1 => 'cart/',
				2 => 'fr/carrito/'
			)
		),

		'tag-titulos' => array(
			0 => array( 0 => 'Natalia Behaine',            1 => 'Natalia Behaine',           2 => 'Natalia Behaine'),
			1 => array( 0 => 'Bio, Natalia Behaine',       1 => 'Bio, Natalia Behaine',      2 => 'Bio, Natalia Behaine'),
			2 => array( 0 => 'Proyectos, Natalia Behaine', 1 => 'Projects, Natalia Behaine', 2 => 'Projets, Natalia Behaine'),
			3 => array( 0 => 'Bitácora, Natalia Behaine',  1 => 'Binacle, Natalia Behaine',  2 => 'Habitacle, Natalia Behaine'),
			4 => array( 0 => 'Contacto, Natalia Behaine',  1 => 'Contact, Natalia Behaine',  2 => 'Contact, Natalia Behaine'),
			5 => array(
				0 => $tt = str_replace('-', ' ', $tt) . ', Natalia Behaine',
				1 => $tt = str_replace('-', ' ', $tt) . ', Natalia Behaine',
				2 => $tt = str_replace('-', ' ', $tt) . ', Natalia Behaine'
			),
			6 => array(
				0 => $tt = str_replace('-', ' ', $tt) . ', Natalia Behaine',
				1 => $tt = str_replace('-', ' ', $tt) . ', Natalia Behaine',
				2 => $tt = str_replace('-', ' ', $tt) . ', Natalia Behaine'
			),
			7 => array(
				0 => $tt = str_replace('-', ' ', $tt) . ', Natalia Behaine',
				1 => $tt = str_replace('-', ' ', $tt) . ', Natalia Behaine',
				2 => $tt = str_replace('-', ' ', $tt) . ', Natalia Behaine'
			),
			8 => array(
				0 => 'Commercial, Natalia Behaine',
				1 => 'Commercial, Natalia Behaine',
				2 => 'Commercial, Natalia Behaine'
			),

			9 => array(
				0 => 'Carrito,  Natalia Behaine',
				1 => 'Cart, Natalia Behaine',
				2 => 'Carrito, Natalia Behaine'
			)
		),

		'ruta' => array(
			0 => array( 0 => ' ', 1 => '../', 2 => '../'),
			1 => array( 0 => ' ', 1 => '../', 2 => '../'),
			2 => array( 0 => ' ', 1 => '../', 2 => '../'),
			3 => array( 0 => ' ', 1 => '../', 2 => '../'),
			4 => array( 0 => ' ', 1 => '../', 2 => '../'),
			5 => array( 0 => '../', 1 => '../../', 2 => '../../'),
			6 => array( 0 => '', 1 => '../', 2 => '../'),
			7 => array( 0 => '../', 1 => '../../', 2 => '../../')
		),

		'titulos' => array(
			'menu'      => array( 0 => 'Menú',      1 => 'Menu',     2 => 'Menu'),
			'cerrar'    => array( 0 => 'Cerrar',    1 => 'Close',    2 => 'Réduire'),
			'inicio'    => array( 0 => 'Inicio',    1 => 'Home',     2 => 'Home'),
			'bio'       => array( 0 => 'Bio',       1 => 'Bio',      2 => 'Bio'),
			'proyectos' => array( 0 => 'proyectos', 1 => 'pojects',  2 => 'projets'),
			'bitacora'  => array( 0 => 'Bitácora',  1 => 'Binacle' , 2 => ''),
			'contacto'  => array( 0 => 'Contacto',  1 => 'Contact' , 2 => 'Contact'),
			'proyecto'  => array( 0 => 'proyecto',  1 => 'project',  2 => 'pojet'),
			'galeria'   => array( 0 => 'galería',   1 => 'gallery',  2 => 'galerie'),

			'descripcion-de-la-obra' => array(
				0=> 'Descripción de la Obra',
				1=>'Description of the Work of Art',
				2=>'Description de l&apos;oeuvre'
			),
			'leer-mas' => array(
				0=> 'Leer más',
				1=> 'Read more',
				2=> 'Lire la suite'
			),
			'galeria-de-fotos' => array(
				0=> 'Galería de fotos',
				1=> 'Photo gallery',
				2=> 'Galerie de photos'
			),
			'galeria-de-videos' => array(
				0=> 'Galería de videos',
				1=> 'Video gallery',
				2=> 'Galerie de vidéos'
			),
			'ir-a-galeria-completa' => array(
                0=> 'Ir a galería completa',
                1=> 'View full gallery',
                2=>'Acceder à la galerie complète'
            ),
			'de' => array(
                0=> 'de ',
                1=> 'of',
                2=>''
            ),
			'siguiente' => array( 0=> 'siguiente', 1=> 'next', 2=>'suivant'),
			'anterior'  => array( 0=> 'anterior',  1=> 'previous', 2=>'précédent'),
			'nombre'  => array( 0=> 'nombre',  1=> 'name', 2=>'prènom'),
			'correo'  => array( 0=> 'e-mail',  1=> 'email', 2=>'email'),
			'mensaje' => array( 0=> 'mensaje', 1=> 'message', 2=>'message'),
			'enviar'  => array( 0=> 'enviar',  1=> 'send', 2=>'envoyer'),


			'correo-invalido' => array(
				0=> "El correo que ingresaste no es valido, por favor intenta de nuevo",
				1=> "The e-mail address is not valid, please try again",
				2=> "L'adresse e-mail est pas valide, s'il vous plaît essayer à nouveau"
			),

			'escribir-nombre' => array(
				0=> "Por favor escribe tu nombre",
				1=> "Please enter your name",
				2=> "S'il vous plaît entrer le nom"
			),

			'escribir-correo' => array(
				0=> "Por favor escribe un correo electrónico",
				1=> "Please type an e-mail address",
				2=> "S'il vous plaît entrer une adresse e-mail"
			),

			'escribir-mensaje' => array(
				0=> "Por favor escribe un mensaje",
				1=> "Please write a message",
				2=> "S'il vous plaît entrer une message"
			),

			'imgenes-del-proceso' => array(
				0 => 'Imágenes del Proceso',
				1 => 'Process Images',
				2 => 'Images du Processus'
			),

			'carrito-vacio' => array(
				0 => 'carrito vacio',
				1 => 'empty cart',
				2 => 'vatire bouta'
			),

			'obras-seleccionadas' => array(
				0 => 'obras seleccionadas',
				1 => 'selected pieces',
				2 => 'œuvres choisies'
			),

			'vaciar-carrito' => array(
				0 => 'vaciar carrito',
				1 => 'empty cart',
				2 => 'vaciar carrito francés'
			),

			'eliminar' => array(
				0 => 'eliminar',
				1 => 'remove',
				2 => 'supprimer'
			),

			'items-en-el-pedido' => array(
				0 => "items en el pedido",
				1 => "items in cart",
				2 => "éléments dans l'ordre"
			),

			'comprar-obra' => array(
				0 => "comprar obra",
				1 => "buy piece",
				2 => "acheter des oeuvres"
			),

			'cambiar' => array(
				0 => "cambiar",
				1 => "change",
				2 => "changer"
			),

			'nombre-de-la-obra' => array(
				0 => "nombre de la obra",
				1 => "piece name",
				2 => "changer"
			),

			'pedido' => array(
				0 => "pedido",
				1 => "order",
				2 => "ordre"
			)
		),

		'botones' => array (
			'btn-compra' => array ( 0=> 'Comprar Obra', 1=> 'Buy piece', 2=> 'acheter travail')
		)
	);
?>
