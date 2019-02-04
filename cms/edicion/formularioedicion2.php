<form enctype="multipart/form-data" name="formularioedicion2" id="formularioedicion2" method="post">

<input type="hidden" name="id"     value="<? echo $id;?>"/>
<input type="hidden" name="tabla"  value="<? echo $tabla;?>"/>

<img class="intLink" title="Quitar Formato" onClick="qFormato('removeFormat');" src="edicion/iconos/formato1.png">
<img class="intLink" title="Negrilla" onClick="formatDoc('bold');"     src="edicion/iconos/bold.png" />

<img class="intLink" title="Enlazar"  onClick="linkear('createLink');" src="edicion/iconos/link.png" />
<img class="intLink" title="Desenlazar"  onClick="formatDoc('unlink');" src="edicion/iconos/unlink.png" />

<img class="intLink" title="Lista"  onClick="formatDoc('insertUnorderedList');" src="edicion/iconos/bullets.png" />

<img class="intLink" title="Subrayar"  onClick="formatDoc('underline');"   src="edicion/iconos/underline.png" />
&nbsp;
<img class="intLink" title="Sangria"  onClick="formatDoc('indent');"   src="edicion/iconos/sangria1.png" />
<img class="intLink" title="Sangria"  onClick="formatDoc('outdent');"   src="edicion/iconos/sangria2.png" />

<p id="editMode"><input type="checkbox" name="switchMode" id="switchBox" onChange="setDocMode(this.checked);" /> <label for="switchBox">ver en HTML</label></p>


<textarea style="display:none;" name="areadeficha" id="areadeficha" cols="100" rows="14"></textarea>
<div id="cajaficha" contenteditable="true"><? echo $ficha; ?></div> 
<br />

<input type="button" name="boton1" id="boton1" value="Guardar" onClick="javascript:submit_form();"/> 
</form>

