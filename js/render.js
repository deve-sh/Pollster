function getpolldetails(pollid){
	var getpoll=new XMLHttpRequest();

	getpoll.open('GET','getdetails.php?pollid='+pollid);

	getpoll.onload = function(){
		var json=JSON.parse(getpoll.ResponseText);

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
			     }
		    ]
		*/


	}

	getpoll.send();
}