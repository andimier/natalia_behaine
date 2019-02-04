<h2>Imagenes de este Articulo</h2><br />
    <hr />
    <h4>Insertar una nueva imagen en este articulo</h4>
    <? $redireccion = '../editar-articulo.php?articulo_id='; ?>
    
     <form action="edicion/insertarimagen1.php" enctype="multipart/form-data" method="post">
     
        <input type="hidden" name="campo_id"  value="<?php echo $id; ?>" />
        <input type="hidden" name="tabla"     value="imagenes_articulos" />
        <input type="hidden" name="campo"     value="articulo_id" />
        <input type="hidden" name="modulo"    value="<? echo $modulo; ?>" />
        
        <input type="hidden" name="redireccion"     value="<? echo $redireccion; ?>" />
        
        <input type="file"   name="nombre_archivo" />
        <input type="submit" name="insertarimagen" value="Insertar Imagen"/>
  	</form>
  <hr />
  <br />

    <? while($imagenes = mysql_fetch_array($grupo_imagenes_articulo)): ?>
		  <? 
          $explotarnombre = explode('/', $imagenes['imagen1']); 
          $nombrearchivo = $explotarnombre[2]; 
          ?>
            
          <img src="<? echo $imagenes['imagen1']; ?>"  width="150" /> &nbsp; <? echo $nombrearchivo; ?> -
          <!--<img src="<? //echo $imagenes['imagen3']; ?>"  width="150" /> &nbsp; <? //echo $imagenes['imagen3']; ?> - -->
          <a href="edicion/eliminarimagenarticulo.php?imagen_id=<? echo $imagenes['id'];?>&articulo_id=<? echo $id; ?>&modulo=<? echo $modulo; ?>" onClick="return confirm('En realidad deseas eliminar esta imagen?')">Eliminar Imagen</a><br /><br />
    <? endwhile; ?>
    

    

