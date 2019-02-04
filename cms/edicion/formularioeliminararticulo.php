<form action="<? echo $archivo_eliminar; ?>" enctype="multipart/form-data" method="post">

    <input type="hidden" name="id"             value="<? echo $id; ?>"/>
    <input type="hidden" name="tabla" 	       value="<? echo $tabla; ?>"/>
    <input type="hidden" name="modulo" 	       value="<? echo $modulo; ?>"/>
    <input type="hidden" name="modulo_id" 	   value="<? echo $modulo_id; ?>"/>
    
    <input type="hidden" name="imagenprincipal" value="<? echo $imagenprincipal; ?>"/>
    
    <input type="submit" name="eliminar"  value="<? echo $tituloboton; ?>" onClick="return confirm('Esta acción eliminará definitivamente este contenido., quieres continuar?')"/>
    </form>