function getpolldetails(pollid,userid){
	var getpoll=new XMLHttpRequest();

	getpoll.open('GET','getdetails.php?pollid='+pollid+'&userid='+userid);

	getpoll.onload = function(){
		if(getpoll.responseText!=="Unauthorised." && getpoll.responseText!=="[]")
		{
			var json=JSON.parse(getpoll.responseText);

			console.log(json);

			// Since the request has been completely processed/parsed, now using the information.

			//  EXAMPLE :
			/*
			    json = 
			    [
				     {
				     	"title":"Who is the best?",
				     	"options":["Devesh Kumar","Nidhi Ringe","Zaheer Khan","Ayush Kumar"],
				     	"totalvotes":90
				     },
				     {
						"uservote":2
				     }
			    ]
			*/

			document.getElementById('poll').innerHTML=("<div id='polltitle'></div><br><br><div id='polloptions' align='center'></div>");
			document.getElementById('polltitle').textContent=json[0].title;
			

			// LOOP TO RENDER OPTIONS TO THE SCREEN OF THE USER

			opstring="";

			for(key in Object.keys(json[0].options)){
				if(key!=json[1].uservote)
					opstring+=("<div class='optionlister' title='Click To Vote' onclick='registervote("+pollid+","+userid+","+key+")'>"+json[0].options[Object.keys(json[0].options)[key]]+"</div><br><br>");
				else
					opstring+=("<div class='optionlister activevote'>"+json[0].options[Object.keys(json[0].options)[key]]+"</div><br><br>");
			}

			document.getElementById('polloptions').innerHTML+=opstring+"<div align='center'><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a></div>";
			document.getElementById('polloptions').innerHTML+="<br><button onclick='renderresult("+pollid+","+userid+")'>View Results</button>";
			
			if(json[1].uservote>=0)
				document.getElementById('poll').innerHTML+=("<button class='removevote("+userid+","+pollid+")'>REMOVE VOTE</button>"); // Remove Vote Button.

		}
		else if(getpoll.responseText=="[]")
			document.getElementById('poll').innerHTML="<br><br>Poll Not Found!<br><br><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a>";	
		else
			document.getElementById('poll').innerHTML=getpoll.responseText+"<br><br><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a>";		
	}

	getpoll.send();

}

function renderresult(pollid,userid){  // Function to render the result of a poll in real time to the screen.
	
}