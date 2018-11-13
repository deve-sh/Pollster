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
				     	"options":["Devesh Kumar","Nidhi Ringe","Zaheer Khan","Ayush Kumar"]
				     },
				     {
				     	"totalvotes":90,
				     	"votes":{
				     		"Devesh Kumar":45,
				     		"Nidhi Ringe":40,
				     		"Zaheer Khan":5,
				     		"Ayush Kumar":0
				     	}
				     },
				     {
						"uservote":2
				     }
			    ]
			*/

			document.getElementById('poll').innerHTML=("<div id='polltitle'></div><br><br><div id='polloptions' align='center'></div>");
			document.getElementById('polltitle').textContent=json[0].title;
			

			// LOOP TO RENDER OPTIONS TO THE SCREEN OF THE USER

			console.log(Object.keys(json[1].votes));

			opstring="";

			for(key in Object.keys(json[1].votes)){
				opstring+=("<div class='optionlister' onclick='registervote("+pollid+","+userid+","+key+")'>"+Object.keys(json[1].votes)[key]+"</div><br><br>");
			}

			console.log(opstring);

			document.getElementById('polloptions').innerHTML+=opstring+"<div align='center'><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a></div>";

		}
		else if(getpoll.responseText=="[]"){
			document.getElementById('poll').innerHTML="<br><br>Poll Not Found!<br><br><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a>";	
		}
		else{
			document.getElementById('poll').innerHTML=getpoll.responseText+"<br><br><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a>";
		}
		
	}

	getpoll.send();

}

function renderresult(jsonob,userid){  // Function to render the result of a poll in real time to the screen.
	var newob=jsonob[1];

	var totalvotes=newob.totalvotes;
	var voteob=newob.votes;

	console.log(totalvotes);
	console.log(voteob);
}