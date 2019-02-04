
var sDefTxt;

function initDoc() {
  oDoc = document.getElementById('andi');
  //sDefTxt = oDoc.innerHTML;
  oDoc.innerHTML = 'andresito bonito';
   
 
}

function formatDoc(sCmd, sValue) {
	document.execCommand(sCmd, false, sValue);
}

function qFormato(sCmd, sValue) {
	document.execCommand(sCmd, false, sValue);
	//document.execCommand('backColor', false, '#FFFFFF');
	//document.execCommand('outdent', false, sValue);
}

function linkear(sCmd, sValue){
	var linkURL = prompt("Enter the URL for this link:", "http://"); 
	document.execCommand(sCmd, false, linkURL);
}




    

  	
  	
  	

 
