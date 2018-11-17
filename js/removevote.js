function removevote(pollid){
	var removereq = new XMLHttpRequest();

	removereq.open('GET','removevote.php?pollid='+pollid);

	removereq.onload=function(){
		location.reload(true);
	}
	removereq.send();
}