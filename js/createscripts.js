function errorchecker(){
	var error=0;

	if(!document.getElementsByClassName('pollinputtitle')[0].textContent)
		error++;

	for(var i=0;i<document.getElementsByClassName('pollinputoptions').length;i++){
		if(!document.getElementsByClassName('pollinputoptions')[i].textContent)
			error++;
	}

	return error;
}

function createpoll(){     // Function to organise and create the poll and send it to a particular PHP Page.
	if(errorchecker()==0){     // No empty input places in the document.

		document.getElementById('errors').innerHTML="";    // Clearing out all the previously logged errors.

		var optionarray=[],polltitle=document.getElementsByClassName('pollinputtitle')[0].textContent;

		for(var i=0;i<document.getElementsByClassName('pollinputoptions').length;i++){
			optionarray.push(encodeURIComponent(document.getElementsByClassName('pollinputoptions')[i].textContent.toString()));
		}

		optionarray=(JSON.stringify(optionarray));

		// Options Array Created.

		// Now creating an AJAX Request.

		var now = new Date();

		now=now.toString();

		now=now.substring(4,15);

		var create=new XMLHttpRequest();

		console.log('finalizepoll.php?options='+optionarray.toString()+'&nooptions='+document.getElementsByClassName('pollinputoptions').length+'&polltitle='+polltitle+'&time='+encodeURIComponent(now)+'');

		create.open('GET','finalizepoll.php?options='+optionarray+'&nooptions='+document.getElementsByClassName('pollinputoptions').length+'&polltitle='+encodeURIComponent(polltitle)+'&time='+encodeURIComponent(now)+'');

		create.onload=function(){
			var path=(window.location.protocol.toString()+"://"+window.location.hostname.toString()+window.location.pathname.toString()).toString();
			
			path=path.split("/").slice(0,-1).join("/");   // Got current path.

			if(create.responseText=='200'){
				self.location=('index.php');
			}
			else{
				console.log(create.responseText);
				document.getElementById('errors').innerHTML="<br><br>An Unknown Error Occured. Please Try Again Later.";
			}
		}

		create.send();
	}
	else{
		document.getElementById('errors').innerHTML="<br><br>Invalid Entries.";
	}
}

function setops(number){  // Function to set the number of options to the document.
	if(number>0){
		document.getElementById('options').innerHTML=""; // Clearing any previous possible made options.
		var opstring="";

		for(var i=1;i<=number;i++){
			opstring+="<div class='pollinputoptions' contenteditable='true' placehold='Option "+i+"'></div><br><br>";
		}

		opstring+="<button class='submitbutton' onclick='createpoll()'>Create Poll</button>";

		document.getElementById('options').innerHTML+=opstring;
	}
}
