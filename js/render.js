/*
	File pertaining to all the rendering stuff of the polls.
*/

function getpolldetails(pollid,userid){
	var getpoll=new XMLHttpRequest();

	getpoll.open('GET','getdetails.php?pollid='+pollid+'&userid='+userid);

	getpoll.onload = function(){
		if(getpoll.responseText!=="Unauthorised." && getpoll.responseText!=="[]")
		{
			var json=JSON.parse(getpoll.responseText);

			// Since the request has been completely processed/parsed, now using the information.

			//  EXAMPLE :
			/*
			    json = 
			    [
				     {
				     	"title":"Who is the best?",
				     	"options":["XYZ", "ABC"],
				     	"totalvotes":90
				     },
				     {
						"uservote":2
				     }
			    ]
			*/

			document.getElementById('poll').innerHTML=("<div id='polltitle'></div><div id='polldesc' align='center'></div><br><br><div id='polloptions' align='center'></div>");
			document.getElementById('polltitle').textContent=json[0].title;

			// Details of the poll to be printed now.

			document.getElementById('polldesc').innerHTML+=("Date Created : "+json[0].date_created+"<br>Last Updated : "+json[0].last_updated);
			

			// LOOP TO RENDER OPTIONS TO THE SCREEN OF THE USER

			opstring="";

			for(key in Object.keys(json[0].options)){
				if(key!=json[1].uservote)
					opstring+=("<div class='optionlister' title='Click To Vote' onclick='registervote("+pollid+","+userid+","+key+")'>"+json[0].options[Object.keys(json[0].options)[key]]+"</div><br><br>");
				else
					opstring+=("<div class='optionlister activevote'>"+json[0].options[Object.keys(json[0].options)[key]]+"</div><br><br>");
			}

			document.getElementById('polloptions').innerHTML+=opstring+"<div align='center'><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a></div>";
			document.getElementById('polloptions').innerHTML+="<br><div align='center'><button onclick='renderresult("+pollid+","+userid+")' class='removebutton'>View Results</button></div>";
			
			if(json[1].uservote>=0)
				document.getElementById('poll').innerHTML+=("<div align='center'><button class='removebutton' onclick='removevote("+pollid+")'>Remove Vote</button></div>"); // Remove Vote Button.

		}
		else if(getpoll.responseText=="[]")
			document.getElementById('poll').innerHTML="<br><br>Poll Not Found!<br><br><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a>";	
		else
			document.getElementById('poll').innerHTML=getpoll.responseText+"<br><br><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a>";		
	}

	getpoll.send();

}

/* Function to render the results of the poll. */

function renderresult(pollid,userid){  // Function to render the result of a poll in real time to the screen.
	var render=new XMLHttpRequest();

	render.open('GET','getresults.php?userid='+userid+'&pollid='+pollid);

	render.send();

	render.onload=function(){

		// Getting rid of all the errors first.
		if(render.responseText=='350'){
			document.getElementById('poll').innerHTML="<br>Poll Not Found.<br>";
		}
		else if(render.responseText=='500')
		{
			document.getElementById('polloptions').innerHTML="<br>An Error Occured. Kindly Try Again.<br>";
		}
		else if(render.responseText=='400'){
			document.getElementById('poll').innerHTML="<br>Unauthorised.";
		}
		else if(render.responseText==='100'){
			document.getElementById('polloptions').innerHTML="<br>No Votes so far.<br>";
			document.getElementById('polloptions').innerHTML+="<br><div align='center'><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a><br><br><button class='removebutton' style='margin-top: 10px;' onclick='getpolldetails("+pollid+","+userid+")'>View Vote Panel</button></div>";		
		}
		else{
			// If no errors were encountered.

			var resultsjson=JSON.parse(render.responseText);

			var resultstring="",totalvotes=resultsjson[0].totalvotes,vote=0,percentage=100,colorstring="";

			for(var i=0;i<resultsjson[0].options.length;i++)
			{
				percentage=((resultsjson[0].results[i])/totalvotes*100);
				resultstring+=("<div class='optionlister' style='background : linear-gradient(90deg,#2c97de "+percentage+"%,#343434 "+percentage+"%);border-radius: 3px; box-shadow:none;color: #ffffff;'>"+resultsjson[0].options[i]+" - &nbsp&nbsp"+percentage.toPrecision(3)+"%</div><br><br>");
			}

			document.getElementById('polloptions').innerHTML="";
			document.getElementById('polloptions').innerHTML+=resultstring+"<br><div align='center'><a href='index.php'><button class='backbutton'><i class=\"fas fa-arrow-left fa-lg\"></i></button></a><br><button class='removebutton' onclick='getpolldetails("+pollid+","+userid+")'>View Vote Panel</button></div>";
		}
	}
}

// END
