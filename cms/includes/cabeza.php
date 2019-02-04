<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>School of Rock</title>
</head>

<body>
<style type="text/css">
/*Page Content*/

#pagina    {width:100% background-color:#999; font-size:18px}
#pagina h2 {color:#333;}
#pagina h3 {color:#666; font-style:normal; font-size:18px; font:Haettenschweiler;}
#pagina h4 {color:#666; font-style:normal; font-size:18px;}
#footer    {height:inherit; background-color:#CCC;}

table {border-collapse:collapse; vertical-align:top; color:#0FF;}
.cabezote     {width:100%; font-family:Haettenschweiler}
.contenido1   {width:300px; background-image:url(iconos/contenido_01.png); background-color:#FFF; padding-left:25px; font-family:Haettenschweiler; font-size:17px; color:#0Cf}
.contenido2   {width:450px; background-color:#FFF;  font-family:"Adobe Garamond Pro"; font-style:italic; font-size:12px; color:#999 }
.contenido3   {width:auto; background-color:#FFF;  font-family:"Adobe Garamond Pro"; font-style:italic; font-size:17px; color:#666;}
c  {padding:0px;   font-family:"Adobe Garamond Pro"; font-style:italic; font-size:18px; color:#333; font-weight:bold}

a    {color:#666; text-decoration:none}
a:hover{ color:#0CF}
li 	 {list-style:square; padding-left:0px}
body {background-color: #FFF; margin:0}

</style>

<div id="pagina">
<table >
<tr>
<td align="left" class="cabezote" colspan="4">ADMINISTRADOR DE CONTENIDOS<br />
<h3>AM DISEÑO</h3> <br />
</td>
</tr>


<tr>
<td colspan="2" rowspan="4" valign="top" class="contenido1">
<a href="logout.php"><img src="iconos/boton1.png" /></a><br /><br />
SCHOOL OF ROCK.COM.CO<br />
Usuario: <?php echo $_SESSION['username']; ?><br />
---------------------------------------------
<?php navegacion($noticia_seleccionada, $mes_seleccionado)?>

</td>
</tr>